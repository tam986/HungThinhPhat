"use client";

import { useState, useEffect, useMemo } from "react";
import Image from "next/image";
import { Button } from "@/components/ui/button";
import { AspectRatio } from "@/components/ui/aspect-ratio";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
import { Minus, Plus, ShoppingCart, Check } from "lucide-react";
import AddToCart from "@/components/product/AddToCart";
import { cn } from "@/lib/utils";

interface Variant {
  id: number;
  slug: string;
  full_name: string;
  price: number;
  sale_price: number | null;
  stock: number;
  weight: string | null;
  filling: string | null;
  hinh: string | null;
  id_khoiluong: number;
  id_nhanbanh: number | null;
}

interface Product {
  id: number;
  tensp: string;
  mota: string | null;
  img: string | null;
  danhmuc: { tendanhmuc: string };
  nhacungcap: { tennhacungcap: string };
}

interface Props {
  product: Product;
  variants: Variant[];
  available_weights: { id: number; khoiluong: string }[];
  available_fillings: { id: number; tenNhanBanh: string }[];
  sibling_products: { id: number; tensp: string; img: string | null; slug: string | null }[];
  targeted_variant_id: number | null;
}

export default function ProductSelection({
  product,
  variants = [],
  available_weights = [],
  available_fillings = [],
  sibling_products = [],
  targeted_variant_id,
}: Props) {
  // Find the initial targeted variant
  const initialVariant = useMemo(() => {
    if (!variants || variants.length === 0) return null;
    return variants.find(v => v.id === targeted_variant_id) || variants[0];
  }, [variants, targeted_variant_id]);

  const [selectedWeight, setSelectedWeight] = useState<number | null>(initialVariant?.id_khoiluong || null);
  const [selectedFilling, setSelectedFilling] = useState<number | null>(initialVariant?.id_nhanbanh || null);
  const [quantity, setQuantity] = useState(1);

  // Find the currently matched variant
  const currentVariant = useMemo(() => {
    if (!variants) return null;
    return variants.find(v => 
      v.id_khoiluong === selectedWeight && 
      v.id_nhanbanh === selectedFilling
    );
  }, [variants, selectedWeight, selectedFilling]);

  if (!initialVariant) return <div className="p-12 text-center text-muted-foreground">Đang tải cấu hình sản phẩm...</div>;

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
  };

  const getImageUrl = (path: string | null) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith('http')) return path;
    return `http://127.0.0.1:8000/storage/${path}`;
  };

  const isAvailable = (weight: number, filling: number | null) => {
    return variants.some(v => v.id_khoiluong === weight && v.id_nhanbanh === filling);
  };

  return (
    <div className="grid md:grid-cols-2 gap-12 lg:gap-20">
      {/* Left Column: Image/Gallery */}
      <div className="space-y-4">
        <AspectRatio ratio={4/5} className="bg-muted rounded-[10px] overflow-hidden relative shadow-xl border border-primary/5">
          <img 
            src={getImageUrl(currentVariant?.hinh || product.img)} 
            alt={currentVariant?.full_name || product.tensp} 
            className="object-cover w-full h-full transition-all duration-500 ease-in-out" 
          />
          {!currentVariant && (
            <div className="absolute inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center text-white font-bold p-6 text-center">
              Lựa chọn này hiện không có sẵn
            </div>
          )}
        </AspectRatio>
      </div>

      {/* Right Column: Information & Selection */}
      <div className="space-y-8 animate-in fade-in slide-in-from-right-4 duration-500">
        <div className="space-y-3">
          <div className="flex items-center gap-2">
            <span className="text-primary font-black tracking-tighter uppercase text-[10px] px-3 py-1 bg-primary/10 rounded-full w-fit border border-primary/10 animate-pulse">
              Đặc sản chất lượng
            </span>
            <span className="text-muted-foreground text-[10px] font-bold uppercase tracking-widest">
              {product.nhacungcap.tennhacungcap}
            </span>
          </div>
          <h1 className="font-merriweather text-6xl md:text-8xl font-black text-foreground leading-none tracking-tighter uppercase italic">
            {product.danhmuc.tendanhmuc}
          </h1>
        </div>

        {/* Pricing - Moved Up per Drawing */}
        <div className="flex items-baseline gap-6 py-4 border-y border-border/50">
          {currentVariant ? (
            <>
              <p className="text-5xl text-primary font-black tracking-tighter">
                {formatPrice(currentVariant.sale_price || currentVariant.price)}
              </p>
              {currentVariant.sale_price && currentVariant.sale_price < currentVariant.price && (
                <p className="text-2xl text-muted-foreground/50 line-through decoration-primary/30 font-medium">
                  {formatPrice(currentVariant.price)}
                </p>
              )}
            </>
          ) : (
            <p className="text-lg text-muted-foreground italic font-medium">Chọn thông tin để xem giá</p>
          )}
        </div>

        {/* Attribute Selection */}
        <div className="space-y-8">
          {/* San Pham Selector (Replacing Loai Banh) */}
          <div className="space-y-4">
            <span className="font-black text-[13px] uppercase tracking-[0.2em] text-foreground flex items-center gap-2">
              <div className="w-1.5 h-4 bg-primary rounded-full shadow-sm shadow-primary/40" />
              Sản phẩm
            </span>
            <div className="flex flex-wrap gap-3">
              {sibling_products?.map(s => {
                const active = s.id === product.id;
                return (
                  <button
                    key={s.id}
                    onClick={() => s.slug && (window.location.href = `/products/${s.slug}`)}
                    className={cn(
                      "px-6 py-4 rounded-[20px] text-sm font-black transition-all border-2 flex items-center justify-center min-w-[140px]",
                      active 
                        ? "bg-white border-slate-900 text-slate-900 shadow-xl scale-105 ring-4 ring-slate-900/5" 
                        : "bg-white border-slate-100 text-muted-foreground hover:border-slate-900/30 hover:bg-slate-50/50"
                    )}
                  >
                    {s.tensp}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Khoi Luong */}
          <div className="space-y-4">
            <span className="font-black text-[11px] uppercase tracking-[0.2em] text-muted-foreground/60 flex items-center gap-2">
               <div className="w-1 h-3 bg-primary rounded-full" />
               Khối lượng
            </span>
            <div className="flex flex-wrap gap-2.5">
              {available_weights.map(w => {
                 const active = selectedWeight === w.id;
                 const exists = variants.some(v => v.id_khoiluong === w.id);
                 const count = variants.filter(v => v.id_khoiluong === w.id).length;
                 return (
                   <button
                     key={w.id}
                     onClick={() => setSelectedWeight(w.id)}
                     className={cn(
                       "px-5 py-3 rounded-2xl text-sm font-black transition-all border-2 flex items-center gap-2",
                       active 
                        ? "bg-primary border-primary text-slate-900 shadow-lg shadow-primary/10" 
                        : "bg-white border-slate-100 text-muted-foreground hover:border-primary/40",
                       !exists && "opacity-30 grayscale cursor-not-allowed border-dashed"
                     )}
                   >
                     {w.khoiluong}
                     <span className={cn("text-[10px] ml-1 opacity-50", active ? "text-slate-900" : "text-muted-foreground")}>({count})</span>
                   </button>
                 );
              })}
            </div>
          </div>

          {/* Nhan Banh (Optional) */}
          {available_fillings.length > 0 && (
            <div className="space-y-4">
              <span className="font-black text-[11px] uppercase tracking-[0.2em] text-muted-foreground/60 flex items-center gap-2">
                <div className="w-1 h-3 bg-primary rounded-full" />
                Nhân bánh
              </span>
              <div className="flex flex-wrap gap-2.5">
                 <button
                  onClick={() => setSelectedFilling(null)}
                  className={cn(
                    "px-5 py-3 rounded-2xl text-sm font-black transition-all border-2",
                    selectedFilling === null 
                      ? "bg-primary border-primary text-slate-900 shadow-lg shadow-primary/10" 
                      : "bg-white border-slate-100 text-muted-foreground hover:border-primary/40"
                  )}
                >
                  Nguyên bản
                </button>
                {available_fillings.map(f => {
                   const active = selectedFilling === f.id;
                   const exists = variants.some(v => v.id_khoiluong === selectedWeight && v.id_nhanbanh === f.id);
                   const count = variants.filter(v => v.id_nhanbanh === f.id).length;
                   return (
                     <button
                       key={f.id}
                       onClick={() => setSelectedFilling(f.id)}
                       className={cn(
                         "px-5 py-3 rounded-2xl text-sm font-black transition-all border-2 flex items-center gap-2",
                         active 
                          ? "bg-primary border-primary text-slate-900 shadow-lg shadow-primary/10" 
                          : "bg-white border-slate-100 text-muted-foreground hover:border-primary/40",
                         !exists && "opacity-30 grayscale border-dashed"
                       )}
                     >
                       {f.tenNhanBanh}
                       <span className={cn("text-[10px] ml-1 opacity-50", active ? "text-slate-900" : "text-muted-foreground")}>({count})</span>
                     </button>
                   );
                })}
              </div>
            </div>
          )}
        </div>

        {/* Quantity & Action */}
        <div className="pt-8 border-t border-border/50">
           <div className="flex flex-col sm:flex-row gap-6">
              <div className="flex items-center bg-muted/50 p-1.5 rounded-2xl w-fit border border-border/50 shadow-inner">
                <Button 
                  variant="ghost" 
                  size="icon" 
                  className="rounded-xl w-10 h-10" 
                  onClick={() => setQuantity(Math.max(1, quantity - 1))}
                >
                  <Minus size={16} />
                </Button>
                <span className="w-12 text-center font-bold text-lg">{quantity}</span>
                <Button 
                  variant="ghost" 
                  size="icon" 
                  className="rounded-xl w-10 h-10"
                  onClick={() => setQuantity(quantity + 1)}
                >
                  <Plus size={16} />
                </Button>
              </div>

              {currentVariant ? (
                <div className="flex-1">
                  <AddToCart 
                    product={{
                      id: currentVariant.id,
                      id_bienthe: currentVariant.id,
                      name: currentVariant.full_name,
                      price: currentVariant.sale_price || currentVariant.price,
                      image: currentVariant.hinh ?? undefined,
                      weight: currentVariant.weight ?? undefined,
                    }} 
                    quantity={quantity}
                  />
                </div>
              ) : (
                <Button disabled className="h-14 rounded-2xl flex-1 text-base font-bold">
                  Hết hàng hoặc không sẵn có
                </Button>
              )}
           </div>
        </div>

        {/* Description */}
        <div className="pt-4">
           <p className="text-muted-foreground leading-relaxed italic text-sm">
             * Vui lòng chọn đầy đủ các thuộc tính để xem giá chính xác và hình ảnh thực tế của từng loại đặc sản.
           </p>
        </div>
      </div>
    </div>
  );
}
