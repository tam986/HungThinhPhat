import type { Metadata } from "next";
import { Droplet, Sun, Clock } from "lucide-react";
import { ProductCard } from "@/components/product/ProductCard";
import ProductSelection from "@/components/product/ProductSelection";
import { VoucherSection } from "@/components/vouchers/VoucherSection";
import { fetchVouchers } from "@/services/api";

async function getProduct(slug: string) {
  try {
    const res = await fetch(`http://127.0.0.1:8000/api/sanpham/${slug}`, {
      next: { revalidate: 300 }, // ISR: 5 minutes
    });
    if (!res.ok) return null;
    return res.json();
  } catch (error) {
    console.error("Failed to fetch product:", error);
    return null;
  }
}

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const { slug } = await params;
  const data = await getProduct(slug);
  const product = data?.product;
  if (!product) return { title: "Sản phẩm không tồn tại" };

  const imageUrl = product.img
    ? product.img.startsWith("http") ? product.img : `http://127.0.0.1:8000/storage/${product.img}`
    : undefined;

  return {
    title: `${product.tensp} – Hưng Thịnh Phát`,
    description: `Mua ${product.tensp} chính hãng tại Hưng Thịnh Phát. Giá tốt, đậc sản Miền Tây chất lượng cao.`,
    openGraph: {
      title: product.tensp,
      images: imageUrl ? [{ url: imageUrl }] : [],
      type: "website",
    },
    keywords: [product.tensp, "đặc sản miền tây"].filter(Boolean),
  };
}

export default async function ProductDetail({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const [data, vouchers] = await Promise.all([
    getProduct(slug),
    fetchVouchers()
  ]);

  if (!data || !data.product) {
    return (
      <div className="container py-32 text-center text-red-500 font-bold">
        Sản phẩm không tồn tại.
      </div>
    );
  }

  const { 
    product, 
    variants = [], 
    available_weights = [], 
    available_fillings = [], 
    targeted_variant_id = null, 
    sibling_products = [] 
  } = data;

  return (
    <div className="container mx-auto px-4 py-12 md:py-24 max-w-7xl">
      {/* Interactive Selection Section */}
      <ProductSelection 
        product={product}
        variants={variants}
        available_weights={available_weights}
        available_fillings={available_fillings}
        sibling_products={sibling_products}
        targeted_variant_id={targeted_variant_id}
      />

      <div className="mt-12 mb-20">
        <VoucherSection vouchers={vouchers} />
      </div>

      {/* Story Behind */}
      <div className="mt-20 grid md:grid-cols-2 gap-12 border-t pt-16">
        <div className="prose prose-lg max-w-none">
          <h3 className="font-merriweather text-3xl mb-6">Mô tả sản phẩm</h3>
          <div className="text-muted-foreground leading-relaxed" dangerouslySetInnerHTML={{ __html: product.mota || '' }} />
        </div>
        
        <div className="space-y-8 bg-primary/5 p-8 md:p-12 rounded-[40px] border border-primary/10">
          <h3 className="font-merriweather text-2xl mb-6">Giá Trị Tinh Hoa</h3>
          <div className="grid sm:grid-cols-2 gap-8">
            <div className="flex items-start gap-4">
              <div className="bg-white p-3 rounded-2xl text-primary shadow-sm"><Droplet className="w-5 h-5" /></div>
              <div>
                <h4 className="font-bold">Đậm Vị Miền Tây</h4>
                <p className="text-sm text-muted-foreground mt-1">Hương vị dân dã đặc trưng vùng phù sa.</p>
              </div>
            </div>
            <div className="flex items-start gap-4">
              <div className="bg-white p-3 rounded-2xl text-accent shadow-sm"><Sun className="w-5 h-5" /></div>
              <div>
                <h4 className="font-bold">Thơm Ngon Khó Cưỡng</h4>
                <p className="text-sm text-muted-foreground mt-1">Giữ trọn hương vị ban đầu tự nhiên.</p>
              </div>
            </div>
            <div className="flex items-start gap-4">
              <div className="bg-white p-3 rounded-2xl text-primary shadow-sm"><Clock className="w-5 h-5" /></div>
              <div>
                <h4 className="font-bold">Bí Truyền Lâu Năm</h4>
                <p className="text-sm text-muted-foreground mt-1">Làm theo công thức gia truyền tận tâm.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {sibling_products && sibling_products.length > 0 && (
        <div className="mt-24 border-t pt-16">
          <div className="flex items-center justify-between mb-8">
            <h2 className="font-merriweather text-3xl font-bold">Sản phẩm cùng danh mục</h2>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {sibling_products.map((item: any) => (
              <ProductCard key={item.id_bienthe || item.id} product={item} />
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
