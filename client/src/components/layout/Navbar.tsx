"use client";

import Link from "next/link";
import { Menu, ChevronDown } from "lucide-react";
import { Button } from "@/components/ui/button";
import { fetchCategories } from "@/services/api";
import { CartButton } from "./CartButton";
import { NavbarSearch } from "./NavbarSearch";
import { useEffect, useState } from "react";

export function Navbar({ initialNavTree = [] }: { initialNavTree?: any[] }) {
  const [navTree, setNavTree] = useState<any[]>(Array.isArray(initialNavTree) ? initialNavTree : []);
  const [activeCategory, setActiveCategory] = useState<any>(
    Array.isArray(initialNavTree) && initialNavTree.length > 0 ? initialNavTree[0] : null
  );
  const [isScrolled, setIsScrolled] = useState(false);

  useEffect(() => {
    // We now receive navTree from Server Layout, avoiding CORS issues.
    
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };
    
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <header className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
      isScrolled 
        ? "py-2 px-4" 
        : "py-0 px-0"
    }`}>
      <div className={`mx-auto transition-all duration-300 ${
        isScrolled 
          ? "max-w-[1200px] bg-white/90 backdrop-blur-md shadow-md rounded-full border border-white/20 px-6 h-16" 
          : "w-full bg-background border-b h-20 px-4 xl:px-8"
      } flex items-center justify-between`}>
        <div className="flex items-center gap-8">
          <Link href="/" className="flex items-center gap-4">
            <h1 className="font-merriweather font-bold text-2xl text-primary">Mekong</h1>
          </Link>
          
          <nav className="hidden md:flex items-center gap-6">
            <Link href="/" className="text-sm font-medium hover:text-primary transition-colors">Trang chủ</Link>
            
            {/* Mega Menu cho Sản Phẩm */}
            <div className="relative group/mega">
              <Link href="/products" className="text-sm font-medium hover:text-primary transition-colors flex items-center gap-1 py-4">
                Sản phẩm <ChevronDown className="w-4 h-4" />
              </Link>
              
              <div className="absolute top-full left-0 opacity-0 invisible group-hover/mega:opacity-100 group-hover/mega:visible transition-all duration-300 z-50">
                <div className="pt-2">
                  <div className="bg-white rounded-3xl shadow-2xl border border-primary/5 p-0 overflow-hidden flex w-[700px] min-h-[400px]">
                    {/* Left Panel: Categories */}
                    <div className="w-1/3 bg-muted/30 border-r p-4 space-y-1">
                      <h4 className="px-4 py-2 text-[11px] font-bold uppercase tracking-widest text-muted-foreground/60">Danh mục</h4>
                      {navTree.map((cat: any) => (
                        <button 
                          key={cat.id}
                          onMouseEnter={() => setActiveCategory(cat)}
                          className={`w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center justify-between group ${activeCategory?.id === cat.id ? "bg-white text-primary shadow-sm" : "hover:bg-white/50 text-foreground/70"}`}
                        >
                          {cat.name}
                          <ChevronDown className={`w-4 h-4 -rotate-90 transition-transform ${activeCategory?.id === cat.id ? "translate-x-1" : "opacity-0"}`} />
                        </button>
                      ))}
                    </div>

                    {/* Right Panel: Products & Types */}
                    <div className="flex-1 p-6 bg-white overflow-y-auto max-h-[500px]">
                       {activeCategory ? (
                         <div className="space-y-8 animate-in fade-in slide-in-from-left-2 duration-300">
                            <div className="flex items-center justify-between border-b pb-4">
                              <h3 className="font-merriweather text-xl font-bold text-primary">{activeCategory.name}</h3>
                              <Link href={`/products?category=${activeCategory.slug}`} className="text-xs font-bold text-muted-foreground hover:text-primary">Xem tất cả</Link>
                            </div>

                            <div className="grid grid-cols-2 gap-x-8 gap-y-8">
                               {activeCategory.products && activeCategory.products.map((sp: any) => (
                                 <div key={sp.id} className="space-y-3">
                                   <h5 className="font-bold text-sm text-foreground hover:text-primary cursor-pointer transition-colors border-l-2 border-primary/20 pl-3">
                                      {sp.name}
                                   </h5>
                                   <div className="flex flex-col gap-2 pl-3">
                                      {sp.types && sp.types.map((type: any) => (
                                        <Link 
                                          key={type.id} 
                                          href={`/products?category=${activeCategory.slug}&search=${encodeURIComponent(sp.name)}`}
                                          className="text-[13px] text-muted-foreground hover:text-primary hover:translate-x-1 transition-all"
                                        >
                                          • {type.name}
                                        </Link>
                                      ))}
                                   </div>
                                 </div>
                               ))}
                            </div>
                         </div>
                       ) : (
                         <div className="h-full flex items-center justify-center text-muted-foreground">
                            Chọn một danh mục để bắt đầu khám phá
                         </div>
                       )}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <Link href="/blog" className="text-sm font-medium hover:text-primary transition-colors">Blog</Link>
            <Link href="/about" className="text-sm font-medium hover:text-primary transition-colors">Về chúng tôi</Link>
          </nav>
        </div>
        
        <div className="hidden lg:flex flex-1 max-w-md mx-8">
           <NavbarSearch />
        </div>

        <div className="flex items-center gap-4">
          <Button variant="ghost" size="icon" className="md:hidden rounded-full">
            <Menu className="w-6 h-6" />
          </Button>

          <CartButton />
        </div>
      </div>
    </header>
  );
}
