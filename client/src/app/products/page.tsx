import type { Metadata } from "next";
import { fetchCategories, fetchVouchers } from "@/services/api";
import { ProductsClientWrapper } from "@/components/product/ProductsClient";

export const metadata: Metadata = {
  title: "Sản Phẩm – Hưng Thịnh Phát",
  description: "Khám phá hàng trăm đặc sản Miền Tây được tuyển chọn kỹ lưỡng: bánh, mứt, khô, trái cây sấy.",
  openGraph: {
    title: "Danh Mục Sản Phẩm – Hưng Thịnh Phát",
    description: "Đặc sản Miền Tây đa dạng, chất lượng cao.",
    type: "website",
  },
  keywords: ["đặc sản miền tây", "bánh kẹo miền tây", "khô cá", "mứt", "hưng thịnh phát"],
};

export const dynamic = "force-dynamic";

export default async function ProductsPage() {
  const [categories, vouchers] = await Promise.all([
    fetchCategories(),
    fetchVouchers()
  ]);
  
  return <ProductsClientWrapper categories={categories} vouchers={vouchers} />;
}
