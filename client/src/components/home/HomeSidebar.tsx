"use client";

import { useState } from "react";
import Link from "next/link";
import { ChevronRight } from "lucide-react";

interface NavItem {
  id: number;
  name: string;
  tendanhmuc?: string;
  slug: string;
  products?: {
    id: number;
    name: string;
    types?: {
      id: number;
      name: string;
    }[];
  }[];
}

export function HomeSidebar({ navTree }: { navTree: NavItem[] }) {
  const [hoveredCat, setHoveredCat] = useState<number | null>(null);

  return (
    <aside className="hidden lg:block relative w-[260px] shrink-0 h-[450px]">
      <div className="bg-white border border-border/60 rounded-xl shadow-sm h-full py-3 flex flex-col relative z-20">
        <div className="px-5 mb-2">
            <h3 className="text-[15px] font-bold text-primary flex items-center gap-2">
                <span className="w-1 h-4 bg-primary rounded-full"></span>
                DANH MỤC SẢN PHẨM
            </h3>
        </div>
        <div className="flex-1 hide-scrollbar">
          {navTree.map((cat) => (
            <div
              key={cat.id}
              className="relative"
              onMouseEnter={() => setHoveredCat(cat.id)}
              onMouseLeave={() => setHoveredCat(null)}
            >
              <Link
                href={`/products?category=${cat.slug}`}
                className={`px-5 py-3 transition-all text-[14px] font-medium flex justify-between items-center group
                  ${hoveredCat === cat.id ? "bg-primary/5 text-primary" : "text-foreground/80 hover:bg-muted/30"}`}
              >
                <span className="transition-transform group-hover:translate-x-0.5">{cat.name || cat.tendanhmuc}</span>
                <ChevronRight className={`w-4 h-4 transition-all ${hoveredCat === cat.id ? "opacity-100 translate-x-0" : "opacity-40 -translate-x-1"}`} />
              </Link>

              {/* Mega Menu Fly-out */}
              {hoveredCat === cat.id && cat.products && cat.products.length > 0 && (
                <div className="absolute top-[-12px] left-full w-[600px] min-h-[450px] bg-white border border-border/60 rounded-xl shadow-xl ml-2 p-6 z-30 animate-in fade-in zoom-in-95 duration-200">
                   <div className="grid grid-cols-2 gap-x-8 gap-y-8">
                     {cat.products.map((sp) => (
                       <div key={sp.id} className="space-y-3">
                         <Link 
                           href={`/products?category=${cat.slug}&product=${encodeURIComponent(sp.name)}`}
                           className="text-[14px] font-bold text-foreground hover:text-primary transition-colors block border-b border-muted pb-1.5"
                         >
                           {sp.name}
                         </Link>
                         <div className="flex flex-wrap gap-2">
                            {sp.types?.map((t) => (
                                <Link
                                    key={t.id}
                                    href={`/products?category=${cat.slug}&product=${encodeURIComponent(sp.name)}&type=${encodeURIComponent(t.name)}`}
                                    className="text-[12px] text-muted-foreground hover:text-primary hover:bg-primary/5 px-2 py-1 rounded-md transition-all border border-transparent hover:border-primary/20"
                                >
                                    {t.name}
                                </Link>
                            ))}
                         </div>
                       </div>
                     ))}
                   </div>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </aside>
  );
}
