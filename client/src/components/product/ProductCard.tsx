"use client";

import Link from "next/link";
import { useRouter } from "next/navigation";
import { ShoppingBag, Eye, Heart, Star } from "lucide-react";
import { useCartStore } from "@/store/useCartStore";
import { toast } from "sonner";
import { motion } from "framer-motion";

interface ProductCardProps {
  product: any;
}

export function ProductCard({ product }: ProductCardProps) {
  const getImageUrl = (path: string) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `${process.env.NEXT_PUBLIC_API_URL}/storage/${path}`;
  };

  const router = useRouter();
  const addItem = useCartStore((state) => state.addItem);

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price);
  };

  const bienthe = product.bienthes && product.bienthes.length > 0 ? product.bienthes[0] : product; 
  const tensp = product.full_name || product.name || product.tensp || product.sanpham?.tensp || "Sản phẩm";
  const idBienthe = product.id_bienthe || bienthe?.id || product.id;
  const hinhAnh = product.image || bienthe?.hinh || product.hinh || product.hinhanh || product.sanpham?.img;
  
  const giakm = product.sale_price ?? product.giakm ?? (bienthe?.sale_price || bienthe?.giakm || 0);
  const gia = product.price ?? (bienthe?.price || bienthe?.gia || 0);
  const displayPrice = (giakm > 0 && giakm < gia) ? giakm : gia;
  
  const categoryName = product.category || product.danhmuc?.tendanhmuc || product.danhmucs?.tendanhmuc || product.sanpham?.danhmuc?.tendanhmuc || "CATEGORY";
  const weight = product.weight || product.khoiluong?.khoiluong || product.bienthe?.khoiluong?.khoiluong || null;
  const filling = product.filling || product.nhanbanh?.tenNhanBanh || product.bienthe?.nhanbanh?.tenNhanBanh || null;

  const discountPercent = giakm > 0 && giakm < gia ? Math.round(((gia - giakm) / gia) * 100) : 0;

  const handleAddToCart = (e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    
    addItem({
      id: product.id || idBienthe,
      id_bienthe: idBienthe,
      name: tensp,
      price: displayPrice,
      quantity: 1,
      image: hinhAnh,
    });
    toast.success("Đã thêm vào giỏ hàng");
  };

  return (
    <motion.div 
      whileHover="hover"
      initial="initial"
      className="group bg-[#F9F8F4] rounded-[40px] overflow-hidden border-none shadow-sm transition-all duration-300 hover:shadow-2xl cursor-pointer flex flex-col h-full"
    >
      <Link href={`/products/${product.slug || product.id}`} className="block relative">
        <div className="relative aspect-[4/5] rounded-[32px] m-3 overflow-hidden bg-white shadow-inner flex items-center justify-center">
          {discountPercent > 0 && (
            <span className="absolute top-4 left-4 z-20 rounded-full bg-[#D8A48F] text-white font-bold px-3 py-1 text-xs border-none pointer-events-none">
              {discountPercent}% Off
            </span>
          )}

          <motion.div
            variants={{
              initial: { scale: 1 },
              hover: { scale: 1.05 }
            }}
            transition={{ duration: 0.4, ease: "easeOut" }}
            className="w-full h-full"
          >
            {/* eslint-disable-next-line @next/next/no-img-element */}
            <img
              src={getImageUrl(hinhAnh)}
              alt={tensp}
              className="object-cover w-full h-full"
            />
          </motion.div>

          {/* Vertical Glassmorphism Toolbar */}
          <motion.div 
            variants={{
              initial: { opacity: 0, x: 20 },
              hover: { opacity: 1, x: 0 }
            }}
            transition={{ duration: 0.3 }}
            className="absolute right-3 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-20"
          >
            <button 
              className="w-10 h-10 rounded-full backdrop-blur-md bg-white/60 hover:bg-white flex items-center justify-center text-gray-700 hover:text-[#D8A48F] transition-colors shadow-sm"
              onClick={(e) => { e.preventDefault(); toast.success("Đã thêm vào mục Yêu thích"); }}
              title="Yêu thích"
            >
              <Heart className="w-4 h-4" />
            </button>
            <button 
              className="w-10 h-10 rounded-full backdrop-blur-md bg-white/60 hover:bg-white flex items-center justify-center text-gray-700 hover:text-[#B2AC88] transition-colors shadow-sm"
              onClick={(e) => { e.preventDefault(); router.push(`/products/${product.slug || product.id}`); }}
              title="Xem nhanh"
            >
              <Eye className="w-4 h-4" />
            </button>
            <button 
              className="w-10 h-10 rounded-full backdrop-blur-md bg-white/60 hover:bg-white flex items-center justify-center text-gray-700 hover:text-[#D8A48F] transition-colors shadow-sm"
              onClick={handleAddToCart}
              title="Thêm vào giỏ hàng"
            >
              <ShoppingBag className="w-4 h-4" />
            </button>
          </motion.div>

          {/* Quick Add Bottom Button - Hidden by default, slide up */}
          <motion.div
            variants={{
              initial: { opacity: 0, y: 30 },
              hover: { opacity: 1, y: 0 }
            }}
            transition={{ duration: 0.3, type: "spring", stiffness: 300, damping: 20 }}
            className="absolute bottom-3 left-3 right-3 z-20"
          >
            <button 
              onClick={handleAddToCart}
              className="w-full rounded-full bg-[#B2AC88] hover:bg-[#B2AC88]/90 text-white font-bold shadow-lg h-11 transition-colors"
            >
              Thêm vào giỏ hàng
            </button>
          </motion.div>

        </div>
      </Link>

      <div className="pt-2 pb-6 px-6 flex flex-col flex-1">
        <span className="text-[#B2AC88] text-xs font-bold tracking-widest uppercase mb-1 line-clamp-1">
          {categoryName}
        </span>
        <h3 className="font-merriweather font-semibold text-[17px] text-gray-800 line-clamp-2 group-hover:text-[#D8A48F] transition-colors leading-snug mb-2 min-h-[46px]">
          {tensp}
        </h3>
        
        {/* Detail Info */}
        {(weight || filling) ? (
          <div className="flex flex-col gap-1 mb-3 text-[13px] text-gray-500">
            {weight && (
              <span className="flex items-center gap-1">
                <span className="font-medium text-gray-700">Khối lượng:</span> {weight}
              </span>
            )}
            {filling && (
              <span className="flex items-center gap-1">
                <span className="font-medium text-gray-700">Nhân:</span> {filling}
              </span>
            )}
          </div>
        ) : (
          <div className="mb-3 h-10"></div>
        )}

        <div className="flex flex-col gap-1 mt-auto pt-3 border-t border-gray-100/80">
          <div className="flex items-baseline gap-2">
            <span className="text-[#D8A48F] font-bold text-lg">{formatPrice(displayPrice)}</span>
            {giakm > 0 && (
              <span className="text-gray-400 line-through text-sm font-medium">{formatPrice(gia)}</span>
            )}
          </div>
        </div>
      </div>
    </motion.div>
  );
}
