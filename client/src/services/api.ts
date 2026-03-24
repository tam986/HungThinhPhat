export const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000/api";
export const STORAGE_BASE_URL = API_BASE_URL.replace(/\/api$/, "/storage");

export function getStorageUrl(path: string) {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    // Remove leading slash if exists
    const cleanPath = path.startsWith("/") ? path.slice(1) : path;
    return `${STORAGE_BASE_URL}/${cleanPath}`;
}

// -- Reusable fetch helper with ISR support --
async function apiFetch<T = any>(path: string, opts?: RequestInit & { revalidate?: number }): Promise<T> {
    const { revalidate, ...rest } = opts ?? {};
    const cacheOpt: RequestInit = revalidate != null
        ? { next: { revalidate } }
        : { cache: "no-store" };
    try {
        const res = await fetch(`${API_BASE_URL}${path}`, { ...cacheOpt, ...rest });
        if (!res.ok) throw new Error(`API ${path} failed: ${res.status}`);
        return res.json();
    } catch (err) {
        console.error(`Fetch error for ${path}:`, err);
        // During build time, we might want to return a fallback instead of crashing
        if (process.env.NODE_ENV === 'production' && !process.env.NEXT_PHASE) {
            // Basic fallback for build-time safety
            return {} as T;
        }
        throw err;
    }
}

// ---------- Products ----------

export async function fetchProducts(search?: string, category?: string[], supplier?: number, page: number = 1, product?: string[], type?: string[]) {
    const params = new URLSearchParams();
    if (search) params.append("search", search);
    if (category && category.length > 0) params.append("category", category.join(","));
    if (product && product.length > 0) params.append("product", product.join(","));
    if (type && type.length > 0) params.append("type", type.join(","));
    if (supplier) params.append("supplier", supplier.toString());
    if (page > 1) params.append("page", page.toString());

    return apiFetch(`/products?${params.toString()}`, { cache: "no-store" });
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
        return await apiFetch("/checkout/process", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });
    } catch (err) {
        console.error("Checkout process failed:", err);
        return { success: false, error: "Không thể kết nối đến máy chủ." };
    }
}

export async function uploadOrderProof(file: File) {
    try {
        const formData = new FormData();
        formData.append("file", file);

        return await apiFetch("/checkout/upload", {
            method: "POST",
            headers: {
                Accept: "application/json",
            },
            body: formData,
        });
    } catch (err) {
        console.error("Upload proof failed:", err);
        return { success: false, error: "Lỗi kết nối khi tải ảnh." };
    }
}

// ---------- Cart ----------

export async function validateCartStock(items: { id_bienthe: number | string; quantity: number }[]) {
    return apiFetch("/cart/validate", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({ items }),
    });
}

export async function fetchOrderDetail(id: string | number) {
    try {
        return await apiFetch(`/orders/${id}`);
    } catch {
        return null;
    }
}
