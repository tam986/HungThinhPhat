export const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000/api";

// -- Reusable fetch helper with ISR support --
async function apiFetch<T = any>(path: string, opts?: RequestInit & { revalidate?: number }): Promise<T> {
    const { revalidate, ...rest } = opts ?? {};
    const cacheOpt: RequestInit = revalidate != null
        ? { next: { revalidate } }
        : { cache: "no-store" };
    const res = await fetch(`${API_BASE_URL}${path}`, { ...cacheOpt, ...rest });
    if (!res.ok) throw new Error(`API ${path} failed: ${res.status}`);
    return res.json();
}

// ---------- Products ----------

export async function fetchProducts(search?: string, category?: string[], supplier?: number, page: number = 1, product?: string[], type?: string[]) {
    const url = new URL(`${API_BASE_URL}/products`);
    if (search) url.searchParams.append("search", search);
    if (category && category.length > 0) url.searchParams.append("category", category.join(","));
    if (product && product.length > 0) url.searchParams.append("product", product.join(","));
    if (type && type.length > 0) url.searchParams.append("type", type.join(","));
    if (supplier) url.searchParams.append("supplier", supplier.toString());
    if (page > 1) url.searchParams.append("page", page.toString());

    // Dynamic (filters change per user) – no store
    const res = await fetch(url.toString(), { cache: "no-store" });
    if (!res.ok) throw new Error("Failed to fetch products");
    return res.json();
}

export async function fetchProductDetail(slug: string) {
    // ISR: revalidate every 5 minutes – product data rarely changes
    return apiFetch(`/products/${slug}`, { revalidate: 300 });
}

export async function fetchSaleProducts() {
    // ISR: revalidate every 2 minutes
    return apiFetch("/products/sale", { revalidate: 120 });
}

/** Returns nav tree: Category > Product > Types */
export async function fetchNavTree() {
    return apiFetch("/nav-tree", { revalidate: 300 });
}

/** Returns danhmucs[] – use HomeData instead where possible */
export async function fetchCategories() {
    // ISR: categories change rarely
    const data = await apiFetch("/categories", { revalidate: 300 });
    return data;
}

// ---------- Home ----------

export async function fetchHomeData() {
    // ISR: revalidate every 2 minutes
    return apiFetch("/", { revalidate: 10 });
}

// ---------- Blog ----------

export async function fetchBlogPosts() {
    // ISR: revalidate every 5 minutes
    return apiFetch("/posts", { revalidate: 300 });
}

export async function fetchBlogPostDetail(slug: string) {
    // ISR: revalidate every 1 minute
    return apiFetch(`/baiviet/${slug}`, { revalidate: 60 });
}

// ---------- Partners ----------

export async function fetchPartners() {
    // ISR: rarely changes
    return apiFetch("/partners", { revalidate: 10 });
}

// ---------- Settings ----------

export async function fetchBankSettings() {
    try {
        return await apiFetch("/settings/bank", { revalidate: 600 });
    } catch {
        return null;
    }
}

export async function fetchGeneralSettings() {
    try {
        const data = await apiFetch("/settings", { revalidate: 600 });
        return data.success ? data.data : null;
    } catch {
        return null;
    }
}

// ---------- Banners ----------

export async function fetchBanners() {
    try {
        return await apiFetch("/banners", { revalidate: 60 });
    } catch {
        return [];
    }
}

// ---------- Vouchers ----------

export async function fetchVouchers() {
    try {
        return await apiFetch("/vouchers", { revalidate: 0 });
    } catch (err) {
        console.error("Error fetching vouchers:", err);
        return [];
    }
}

// ---------- Checkout (stateful – never cache) ----------

export async function processCheckout(payload: any) {
    try {
        const res = await fetch(`${API_BASE_URL}/checkout/process`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();
        if (!res.ok) {
            return {
                success: false,
                error: typeof data.error === 'string' ? data.error : (data.message || "Lỗi khi xử lý thanh toán")
            };
        }
        return data;
    } catch (err) {
        console.error("Checkout process failed:", err);
        return { success: false, error: "Không thể kết nối đến máy chủ." };
    }
}

export async function uploadOrderProof(file: File) {
    try {
        const formData = new FormData();
        formData.append("file", file);

        const res = await fetch(`${API_BASE_URL}/checkout/upload`, {
            method: "POST",
            headers: {
                Accept: "application/json",
            },
            body: formData,
        });
        const data = await res.json();
        if (!res.ok) {
            return {
                success: false,
                error: typeof data.error === 'string' ? data.error : (data.message || "Lỗi khi tải ảnh")
            };
        }
        return data;
    } catch (err) {
        console.error("Upload proof failed:", err);
        return { success: false, error: "Lỗi kết nối khi tải ảnh." };
    }
}

// ---------- Cart ----------

export async function validateCartStock(items: { id_bienthe: number | string; quantity: number }[]) {
    const res = await fetch(`${API_BASE_URL}/cart/validate`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({ items }),
    });
    return res.json();
}

export async function fetchOrderDetail(id: string | number) {
    try {
        return await apiFetch(`/orders/${id}`);
    } catch {
        return null;
    }
}
