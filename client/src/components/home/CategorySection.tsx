"use client";

import { ProductCard } from "@/components/product/ProductCard";
import Link from "next/link";
import { Button } from "@/components/ui/button";
import { ChevronRight } from "lucide-react";

export function CategorySection({ categories }: { categories: any[] }) {
  if (!categories || categories.length === 0) return null;

  return (
    <div className="space-y-16 mt-8">
      {categories.map((category: any) => {
        const products = category.products || [];
        if (products.length === 0) return null;

        return (
          <section key={category.id} className="space-y-6">
            <div className="flex items-center justify-between border-b pb-4">
              <h2 className="text-2xl font-black uppercase text-foreground">{category.tendanhmuc}</h2>
              <Link href={`/products?category=${category.slug}`}>
                <Button variant="ghost" className="text-muted-foreground hover:text-primary font-bold hidden md:flex items-center gap-1">
                  Xem tất cả <ChevronRight className="w-4 h-4" />
                </Button>
                <Button variant="ghost" size="icon" className="md:hidden text-primary">
                  <ChevronRight className="w-5 h-5" />
                </Button>
              </Link>
            </div>
            
            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
              {products.slice(0, 4).map((item: any) => (
                <div key={item.id_bienthe || item.id} className="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow group relative">
                  <ProductCard product={item} />
                </div>
              ))}
            </div>
          </section>
        );
      })}
    </div>
  );
}
