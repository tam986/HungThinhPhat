"use client";

import Link from "next/link";

interface Category {
  id: number;
  tendanhmuc: string;
  img_url?: string;
  slug: string;
}

import { useState, useEffect } from "react";

export default function HotCategories({ categories }: { categories: Category[] }) {
  const [mounted, setMounted] = useState(false);

  useEffect(() => {
    setMounted(true);
  }, []);

  if (!mounted) return (
    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 list-none p-0 animate-pulse">
      {[...Array(6)].map((_, i) => (
        <div key={i} className="aspect-square bg-slate-100 rounded-[10px]" />
      ))}
    </div>
  );

  const getImageUrl = (img?: string, imgUrl?: string) => {
    if (imgUrl) return imgUrl;
    if (!img) return "/placeholder.jpg";
    if (img.startsWith("http")) return img;
    return `${process.env.NEXT_PUBLIC_API_URL}/storage/${img}`;
  };

  return (
    <ul className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 list-none p-0">
      {categories.slice(0, 12).map((cat) => (
        <li key={cat.id} className="group cursor-pointer">
          <Link 
            href={`/products?category=${cat.slug}`} 
            className="block relative aspect-square bg-[#FDF5E6] rounded-[10px] overflow-hidden border border-amber-100/50 shadow-sm group-hover:shadow-md transition-all duration-300"
          >
            {/* Decorative Elements (Flowers pattern) */}
            <div className="absolute top-2 left-2 text-[#E2C48D] opacity-40">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C11.45 2 11 2.45 11 3V5.5C11 6.05 11.45 6.5 12 6.5S13 6.05 13 5.5V3C13 2.45 12.55 2 12 2M12 17.5C11.45 17.5 11 17.95 11 18.5V21C11 21.55 11.45 22 12 22S13 21.55 13 21V18.5C13 17.95 12.55 17.5 12 17.5M21 11H18.5C17.95 11 17.5 11.45 17.5 12S17.95 13 18.5 13H21C21.55 13 22 12.55 22 12S21.55 11 21 11M6.5 12C6.5 11.45 6.05 11 5.5 11H3C2.45 11 2 11.45 2 12S2.45 13 3 13H5.5C6.05 13 6.5 12.55 6.5 12M18.36 5.64C17.97 5.25 17.34 5.25 16.95 5.64S16.56 6.66 16.95 7.05L18.71 8.81C19.1 9.2 19.74 9.2 20.13 8.81S20.52 7.79 20.13 7.4L18.36 5.64M5.64 18.36C5.25 18.75 5.25 19.38 5.64 19.77S6.66 20.16 7.05 19.77L8.81 18.01C9.2 17.62 9.2 16.98 8.81 16.59S7.79 16.2 7.4 16.59L5.64 18.36M18.36 18.36L16.59 16.59C16.2 16.2 15.56 16.2 15.17 16.59S14.78 17.61 15.17 18L16.93 19.76C17.32 20.15 17.96 20.15 18.35 19.76S18.74 18.74 18.35 18.35L18.36 18.36M5.64 5.64L7.4 7.4C7.79 7.79 8.43 7.79 8.82 7.4S9.21 6.38 8.82 5.99L7.06 4.23C6.67 3.84 6.03 3.84 5.64 4.23S5.25 5.25 5.64 5.64Z"/></svg>
            </div>
            <div className="absolute bottom-10 right-2 text-[#E2C48D] opacity-40">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C11.45 2 11 2.45 11 3V5.5C11 6.05 11.45 6.5 12 6.5S13 6.05 13 5.5V3C13 2.45 12.55 2 12 2M12 17.5C11.45 17.5 11 17.95 11 18.5V21C11 21.55 11.45 22 12 22S13 21.55 13 21V18.5C13 17.95 12.55 17.5 12 17.5M21 11H18.5C17.95 11 17.5 11.45 17.5 12S17.95 13 18.5 13H21C21.55 13 22 12.55 22 12S21.55 11 21 11M6.5 12C6.5 11.45 6.05 11 5.5 11H3C2.45 11 2 11.45 2 12S2.45 13 3 13H5.5C6.05 13 6.5 12.55 6.5 12M18.36 5.64C17.97 5.25 17.34 5.25 16.95 5.64S16.56 6.66 16.95 7.05L18.71 8.81C19.1 9.2 19.74 9.2 20.13 8.81S20.52 7.79 20.13 7.4L18.36 5.64M5.64 18.36C5.25 18.75 5.25 19.38 5.64 19.77S6.66 20.16 7.05 19.77L8.81 18.01C9.2 17.62 9.2 16.98 8.81 16.59S7.79 16.2 7.4 16.59L5.64 18.36M18.36 18.36L16.59 16.59C16.2 16.2 15.56 16.2 15.17 16.59S14.78 17.61 15.17 18L16.93 19.76C17.32 20.15 17.96 20.15 18.35 19.76S18.74 18.74 18.35 18.35L18.36 18.36M5.64 5.64L7.4 7.4C7.79 7.79 8.43 7.79 8.82 7.4S9.21 6.38 8.82 5.99L7.06 4.23C6.67 3.84 6.03 3.84 5.64 4.23S5.25 5.25 5.64 5.64Z"/></svg>
            </div>

            {/* Main Image */}
            <div className="absolute inset-0 flex items-center justify-center p-8 group-hover:scale-110 transition-transform duration-500">
              <img 
                src={getImageUrl((cat as any).img, cat.img_url)} 
                alt={cat.tendanhmuc} 
                className="w-full h-full object-contain" 
                onError={(e) => {
                  (e.target as HTMLImageElement).src = "/placeholder.jpg";
                }}
              />
            </div>

            {/* Footer Name */}
            <div className="absolute bottom-0 left-0 right-0 py-2.5 bg-slate-100/80 backdrop-blur-sm border-t border-slate-200/50 flex items-center justify-center">
              <span className="text-xs font-black text-slate-700 tracking-tight group-hover:text-primary transition-colors">
                {cat.tendanhmuc}
              </span>
            </div>
          </Link>
        </li>
      ))}
    </ul>
  );
}
