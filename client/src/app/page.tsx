import { AspectRatio } from "@/components/ui/aspect-ratio";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
import { ChevronRight } from "lucide-react";
import type { Metadata } from "next";

import { fetchHomeData, fetchBlogPosts, fetchPartners, fetchBanners, fetchSaleProducts, fetchNavTree, fetchVouchers, getStorageUrl } from "@/services/api";
import Link from "next/link";
import { CategorySection } from "@/components/home/CategorySection";
import { ProductSliderSection } from "@/components/home/ProductSliderSection";
import { BlogSection } from "@/components/home/BlogSection";
import { PartnerSection } from "@/components/home/PartnerSection";
import { BannerCarousel } from "@/components/home/BannerCarousel";
import { HomeSidebar } from "@/components/home/HomeSidebar";
import { ServiceSection } from "@/components/home/ServiceSection";
import { VoucherSection } from "@/components/vouchers/VoucherSection";
import HotCategories from "@/components/home/HotCategories";

export const metadata: Metadata = {
  title: "Hưng Thịnh Phát – Đặc Sản Miền Tây",
  description: "Khám phá những đặc sản tinh túy nhất vùng Miền Tây Nam Bộ: bánh, mứt, khô, và nhiều hơn nữa.",
  openGraph: {
    title: "Hưng Thịnh Phát – Đặc Sản Miền Tây",
    description: "Đặc sản Miền Tây: Bánh, Mứt, Khô – Hương vị dân dã, tiêu chuẩn cao cấp.",
    type: "website",
  },
};

export const dynamic = "force-dynamic";

export default async function Home() {
  const [homeData, blogsRes, banners, partners, saleProductsRes, navTree, vouchers] = await Promise.all([
    fetchHomeData(),
    fetchBlogPosts(),
    fetchBanners(),
    fetchPartners(),
    fetchSaleProducts(),
    fetchNavTree(),
    fetchVouchers()
  ]);

  // Homepage uses homeData.productCate for category sections
  // and the /products/latest + /products/sale for slider sections
  const latestProducts = (homeData?.productCate || []).flatMap((c: any) => c.products || []).slice(0, 8);
  const saleProducts = Array.isArray(saleProductsRes) ? saleProductsRes : (saleProductsRes?.data || []);
  const blogs = Array.isArray(blogsRes) ? blogsRes : (blogsRes?.baivietMoi || blogsRes?.data || []);

  return (
    <div className="min-h-screen pb-20">
      <main className="max-w-[1200px] mx-auto px-4 pt-24 md:pt-32 space-y-16">
        {/* Hero Section */}
        <section className="flex flex-col lg:flex-row gap-6 lg:h-[450px]">
          {/* Left Category Sidebar (Mega Menu) */}
          <HomeSidebar navTree={navTree} />

          {/* Right Banner Slider */}
          <div className="flex-1 overflow-hidden h-full" style={{ minWidth: 0 }}>
            <BannerCarousel banners={banners} />
          </div>
        </section>

        {/* Voucher Section */}
        <VoucherSection vouchers={vouchers} />

        {/* Hot Categories Section */}
        <section className="space-y-8">
          <div className="flex items-center justify-between">
            <h3 className="font-merriweather text-2xl font-black text-foreground">Danh mục nổi bật</h3>
            <Link href="/products" className="text-sm font-bold text-muted-foreground hover:text-primary flex items-center gap-1 transition-colors">
              Xem tất cả <ChevronRight size={14} />
            </Link>
          </div>
          
          <HotCategories categories={homeData?.danhmucs || []} />
        </section>

        {/* Category Section */}
        <CategorySection categories={homeData?.productCate || []} />

        {/* New Products */}
        <ProductSliderSection title="Sản phẩm mới" products={latestProducts} />

        {/* Sale Products */}
        <ProductSliderSection title="Sản phẩm đang khuyến mãi" products={saleProducts} />

        {/* Blog */}
        <BlogSection posts={blogs} />

        {/* Partners */}
        <PartnerSection partners={partners} />

        {/* Services */}
        <ServiceSection />
      </main>
    </div>
  );
}
