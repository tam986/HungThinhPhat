"use client";

import { useState, useEffect } from "react";

export function PartnerSection({ partners }: { partners: any[] }) {
  const [mounted, setMounted] = useState(false);

  useEffect(() => {
    setMounted(true);
  }, []);

  if (!partners || partners.length === 0) return null;
  if (!mounted) return null;

  const getImageUrl = (path: string) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `http://127.0.0.1:8000/storage/${path}`;
  };

  return (
    <section className="space-y-8 pb-10">
      <h3 className="font-merriweather text-center text-2xl font-bold text-muted-foreground">Đối tác của chúng tôi</h3>
      
      <div className="w-full">
         <ul className="flex flex-wrap items-center justify-center gap-8 md:gap-16">
            {partners.map(p => (
              <li key={p.id} className="w-32 h-16 relative grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 flex items-center justify-center">
                 {/* eslint-disable-next-line @next/next/no-img-element */}
                 <img 
                   src={p.hinhanh_url || "/placeholder.jpg"} 
                   alt={p.tennhacungcap} 
                   className="max-h-12 w-auto object-contain" 
                   onError={(e) => {
                     (e.target as HTMLImageElement).src = "/placeholder.jpg";
                   }}
                 />
              </li>
            ))}
         </ul>
      </div>
    </section>
  );
}
