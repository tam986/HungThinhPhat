"use client";

import React from "react";
import { Ticket, Copy, CheckCircle2 } from "lucide-react";
import { toast } from "sonner";
import { cn } from "@/lib/utils";
import { 
  Carousel, 
  CarouselContent, 
  CarouselItem, 
  CarouselNext, 
  CarouselPrevious 
} from "@/components/ui/carousel";
import { Button } from "@/components/ui/button";

interface Voucher {
  id: number;
  magiamgia: string;
  mota: string | null;
  hesogiamgia: number;
  sotientoithieu: number;
  thoidiemketthuc: string;
}

interface VoucherSectionProps {
  vouchers: Voucher[];
}

export function VoucherSection({ vouchers }: VoucherSectionProps) {
  if (!vouchers || vouchers.length === 0) return null;

  const handleCopy = (code: string) => {
    navigator.clipboard.writeText(code);
    toast.success(`Đã sao chép mã: ${code}`, {
        icon: <CheckCircle2 className="w-4 h-4 text-emerald-500" />
    });
  };

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(amount);
  };

  return (
    <section className="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
      <div className="flex items-center justify-between">
        <div className="space-y-1">
          <h3 className="font-merriweather text-2xl font-black text-foreground flex items-center gap-2">
            <Ticket className="text-primary w-6 h-6" />
            Ưu đãi từ Hưng Thịnh Phát
          </h3>
          <p className="text-sm text-muted-foreground font-medium">Lấy mã giảm giá để nhận ưu đãi hấp dẫn ngay hôm nay!</p>
        </div>
      </div>

      <Carousel
        opts={{
          align: "start",
          loop: vouchers.length > 4,
        }}
        className="w-full"
      >
        <CarouselContent className="-ml-4">
          {vouchers.map((voucher) => (
            <CarouselItem key={voucher.id} className="pl-4 basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4">
              <div className="group relative bg-white border border-slate-200 rounded-[32px] p-6 transition-all hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 overflow-hidden h-full flex flex-col justify-between">
                {/* Background Pattern */}
                <div className="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-150 duration-500" />
                
                <div className="relative space-y-4">
                  <div className="flex items-center justify-between">
                    <div className="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                        Đang diễn ra
                    </div>
                    <span className="text-[10px] text-muted-foreground font-medium">
                        HSD: {new Date(voucher.thoidiemketthuc).toLocaleDateString("vi-VN")}
                    </span>
                  </div>

                  <div>
                    <h4 className="text-2xl font-black text-primary font-merriweather">
                      Giảm {voucher.hesogiamgia > 100 ? formatCurrency(voucher.hesogiamgia) : `${voucher.hesogiamgia}%`}
                    </h4>
                    <p className="text-xs font-bold text-foreground mt-1 min-h-[32px] line-clamp-2">
                      {voucher.mota || `Giảm giá cho đơn hàng từ ${formatCurrency(voucher.sotientoithieu)}`}
                    </p>
                  </div>

                  <div className="pt-2 border-t border-dashed border-slate-100">
                    <div className="flex flex-col gap-1">
                        <span className="text-[10px] text-muted-foreground uppercase font-bold tracking-widest leading-none">Mã giảm giá</span>
                        <div className="flex items-center justify-between gap-2 mt-1">
                            <code className="text-sm font-black text-slate-700 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 flex-1 text-center">
                                {voucher.magiamgia}
                            </code>
                            <button
                                onClick={() => handleCopy(voucher.magiamgia)}
                                className="p-2.5 bg-primary text-slate-900 rounded-xl hover:bg-primary/90 transition-all shadow-md shadow-primary/20 active:scale-90"
                                title="Sao chép mã"
                            >
                                <Copy size={16} />
                            </button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </CarouselItem>
          ))}
        </CarouselContent>
        {vouchers.length > 4 && (
            <>
                <CarouselPrevious className="hidden md:flex -left-6 bg-white/80 hover:bg-white shadow-md border-transparent text-primary" />
                <CarouselNext className="hidden md:flex -right-6 bg-white/80 hover:bg-white shadow-md border-transparent text-primary" />
            </>
        )}
      </Carousel>
    </section>
  );
}
