"use client";

import { useState, useEffect, Suspense } from "react";
import { useSearchParams, useRouter, usePathname } from "next/navigation";
import { fetchProducts } from "@/services/api";
import { ProductCard } from "@/components/product/ProductCard";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Search, Loader2, ChevronLeft, ChevronRight, X, ChevronDown } from "lucide-react";
import { useDebounce } from "@/hooks/useDebounce";
import { VoucherSection } from "@/components/vouchers/VoucherSection";

export function ProductsClient({ categories: initialCategoriesData, vouchers }: { categories: any[], vouchers: any[] }) {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();

  const initialCategories = searchParams.get("category") ? searchParams.get("category")!.split(",") : [];
  const initialProducts = searchParams.get("product") ? searchParams.get("product")!.split(",") : [];
  const initialTypes = searchParams.get("type") ? searchParams.get("type")!.split(",") : [];
  const initialSearch = searchParams.get("search") || "";
  const initialPage = parseInt(searchParams.get("page") || "1");

  const [selectedCategories, setSelectedCategories] = useState<string[]>(initialCategories);
  const [selectedProducts, setSelectedProducts] = useState<string[]>(initialProducts);
  const [selectedTypes, setSelectedTypes] = useState<string[]>(initialTypes);
  const [searchTerm, setSearchTerm] = useState(initialSearch);
  const [currentPage, setCurrentPage] = useState(initialPage);
  const [sortBy, setSortBy] = useState<string>(searchParams.get("sort") || "newest");
  const [navTree, setNavTree] = useState<any[]>([]);
  const [expandedCats, setExpandedCats] = useState<number[]>([]);
  const [expandedProds, setExpandedProds] = useState<number[]>([]);

  const debouncedSearch = useDebounce(searchTerm, 500);

  const [products, setProducts] = useState<any[]>([]);
  const [pagination, setPagination] = useState({ current_page: 1, last_page: 1, total: 0 });
  const [isLoading, setIsLoading] = useState(true);

  // Fetch nav tree
  useEffect(() => {
    const { fetchNavTree } = require("@/services/api");
    fetchNavTree().then(setNavTree).catch(console.error);
  }, []);

  // Fetch products when filters change
  useEffect(() => {
    async function loadProducts() {
      setIsLoading(true);
      try {
        const params = new URLSearchParams();
        if (selectedCategories.length > 0) params.set("category", selectedCategories.join(","));
        if (selectedProducts.length > 0) params.set("product", selectedProducts.join(","));
        if (selectedTypes.length > 0) params.set("type", selectedTypes.join(","));
        if (debouncedSearch) params.set("search", debouncedSearch);
        if (currentPage > 1) params.set("page", currentPage.toString());
        if (sortBy !== "newest") params.set("sort", sortBy);

        router.replace(`${pathname}?${params.toString()}`, { scroll: false });

        const res = await fetchProducts(debouncedSearch, selectedCategories, undefined, currentPage, selectedProducts, selectedTypes);
        let productsData = res.products?.data || [];
        
        // Client-side sorting
        if (sortBy === "price-asc") {
          productsData.sort((a: any, b: any) => (Number(a.sale_price) || Number(a.price)) - (Number(b.sale_price) || Number(b.price)));
        } else if (sortBy === "price-desc") {
          productsData.sort((a: any, b: any) => (Number(b.sale_price) || Number(b.price)) - (Number(a.sale_price) || Number(a.price)));
        } else if (sortBy === "newest") {
          // No explicit sort if newest is default from backend, or sort by created_at if present
          if (productsData.length > 0 && productsData[0].created_at) {
             productsData.sort((a: any, b: any) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
          }
        }

        setProducts(productsData);
        setPagination({
          current_page: res.products?.current_page || 1,
          last_page: res.products?.last_page || 1,
          total: res.products?.total || 0,
        });
      } catch (err) {
        console.error("Failed to fetch products", err);
      } finally {
        setIsLoading(false);
      }
    }
    loadProducts();
  }, [selectedCategories, debouncedSearch, currentPage, pathname, router, selectedProducts, selectedTypes, sortBy]);

  const handleCategoryChange = (idStr: string, checked: boolean) => {
    if (checked) {
      setSelectedCategories(prev => [...prev, idStr]);
    } else {
      setSelectedCategories(prev => prev.filter(c => c !== idStr));
    }
    setCurrentPage(1);
  };

  const handleProductChange = (name: string, checked: boolean) => {
    if (checked) {
      setSelectedProducts(prev => [...prev, name]);
    } else {
      setSelectedProducts(prev => prev.filter(p => p !== name));
    }
    setCurrentPage(1);
  };

  const handleTypeChange = (name: string, checked: boolean) => {
    if (checked) {
      setSelectedTypes(prev => [...prev, name]);
    } else {
      setSelectedTypes(prev => prev.filter(t => t !== name));
    }
    setCurrentPage(1);
  };

  const toggleCat = (id: number) => {
    setExpandedCats(prev => prev.includes(id) ? prev.filter(i => i !== id) : [...prev, id]);
  };

  const toggleProd = (id: number) => {
    setExpandedProds(prev => prev.includes(id) ? prev.filter(i => i !== id) : [...prev, id]);
  };

  const clearFilters = () => {
    setSearchTerm("");
    setSelectedCategories([]);
    setSelectedProducts([]);
    setSelectedTypes([]);
    setCurrentPage(1);
  };

  return (
    <div className="min-h-screen pb-20">
      {/* Hero Banner */}
      <section className="bg-primary/5 pt-24 pb-16 md:pt-32 md:pb-24 px-4 mb-12 relative overflow-hidden">
        <div className="absolute -top-8 -left-8 w-48 h-48 bg-accent/20 rounded-full blur-3xl -z-10" />
        <div className="container mx-auto text-center space-y-6 relative z-10">
          <p className="text-sm font-semibold text-primary uppercase tracking-widest px-4 py-1.5 bg-white/50 rounded-full w-fit mx-auto">
            Hương Vị Miền Tây
          </p>
          <h1 className="font-merriweather text-4xl md:text-6xl font-bold text-foreground">
            Danh Mục Đặc Sản
          </h1>
          <p className="text-muted-foreground max-w-2xl mx-auto text-lg md:text-xl">
            Khám phá những đặc sản tinh túy nhất từ mọi hạt phù sa của miền Tây Nam Bộ.
          </p>
        </div>
      </section>

      <div className="max-w-[1200px] mx-auto px-4 mb-12">
        <VoucherSection vouchers={vouchers} />
      </div>

      <main className="max-w-[1200px] mx-auto px-4 grid lg:grid-cols-4 gap-12">
        {/* Sidebar Filters */}
        <aside className="space-y-10 lg:sticky lg:top-28 h-max">
          <div className="space-y-4">
            <div className="flex items-center justify-between border-b pb-2">
              <h3 className="font-bold text-xl font-merriweather">Tìm kiếm</h3>
            </div>
            <div className="relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
              <Input
                placeholder="Nhập tên sản phẩm..."
                className="pl-11 bg-muted/50 border-transparent focus-visible:ring-primary rounded-2xl h-12 shadow-sm"
                value={searchTerm}
                onChange={(e) => { setSearchTerm(e.target.value); setCurrentPage(1); }}
              />
              {searchTerm && (
                <button onClick={() => setSearchTerm("")} className="absolute right-4 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground">
                  <X className="w-4 h-4" />
                </button>
              )}
            </div>
          </div>

          <div className="space-y-5">
            <h3 className="font-bold text-xl font-merriweather border-b pb-2">Loại Đặc Sản</h3>
            <div className="space-y-1">
              {(navTree.length > 0 ? navTree : initialCategoriesData).map((cat: any) => {
                const isSelected = selectedCategories.includes(cat.slug || "");
                const isExpanded = expandedCats.includes(cat.id);
                return (
                  <div key={cat.id} className="space-y-1">
                    <div className="flex items-center justify-between group">
                      <label className={`flex items-center space-x-3 p-3 rounded-xl cursor-pointer transition-colors flex-1 ${isSelected ? "bg-primary/10" : "hover:bg-muted/50"}`}>
                        <div className="relative flex items-center justify-center w-5 h-5 shrink-0">
                          <input
                            type="checkbox"
                            className="peer appearance-none w-5 h-5 border-2 border-muted-foreground/30 rounded focus:ring-2 focus:ring-primary/20 focus:outline-none checked:bg-primary checked:border-primary transition-all"
                            checked={isSelected}
                            onChange={(e) => handleCategoryChange(cat.slug || cat.tendanhmuc, e.target.checked)}
                          />
                          <svg className={`absolute w-3.5 h-3.5 text-white pointer-events-none transition-opacity ${isSelected ? "opacity-100" : "opacity-0"}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" />
                          </svg>
                        </div>
                        <span className={`text-[15px] font-medium transition-colors ${isSelected ? "text-primary" : "text-foreground/80"}`}>
                          {cat.name || cat.tendanhmuc}
                        </span>
                      </label>
                      {cat.products && cat.products.length > 0 && (
                        <button onClick={() => toggleCat(cat.id)} className="p-2 hover:bg-muted rounded-lg group">
                          <ChevronDown className={`w-4 h-4 transition-transform text-muted-foreground group-hover:text-primary ${isExpanded ? "rotate-180" : ""}`} />
                        </button>
                      )}
                    </div>

                    {isExpanded && cat.products && (
                      <div className="pl-6 space-y-1 border-l-2 border-primary/5 ml-5 mt-1 animate-in slide-in-from-top-1 duration-200">
                        {cat.products.map((sp: any) => {
                          const isProdExpanded = expandedProds.includes(sp.id);
                          const isProdSelected = selectedProducts.includes(sp.name);
                          return (
                            <div key={sp.id} className="space-y-1">
                              <div className="flex items-center justify-between group">
                                <label className={`flex items-center space-x-2.5 p-2 rounded-lg cursor-pointer transition-colors flex-1 ${isProdSelected ? "bg-primary/5 text-primary" : "hover:bg-muted/50"}`}>
                                  <input
                                    type="checkbox"
                                    className="w-4 h-4 rounded border-muted-foreground/30 text-primary focus:ring-primary/20"
                                    checked={isProdSelected}
                                    onChange={(e) => handleProductChange(sp.name, e.target.checked)}
                                  />
                                  <span className={`text-sm font-bold transition-colors ${isProdSelected ? "text-primary" : "text-foreground/70"}`}>
                                    {sp.name}
                                  </span>
                                </label>
                                {sp.types && sp.types.length > 0 && (
                                  <button onClick={() => toggleProd(sp.id)} className="p-1.5 hover:bg-muted rounded-md group">
                                    <ChevronDown className={`w-3.5 h-3.5 transition-transform text-muted-foreground group-hover:text-primary ${isProdExpanded ? "rotate-180" : ""}`} />
                                  </button>
                                )}
                              </div>
                              
                              {isProdExpanded && sp.types && (
                                <div className="pl-4 space-y-1 mt-1 border-l border-dashed border-primary/20 ml-2 animate-in slide-in-from-top-1 duration-200">
                                  {sp.types.map((t: any) => {
                                    const isTypeSelected = selectedTypes.includes(t.name);
                                    return (
                                      <label key={t.id} className={`flex items-center space-x-2 p-2 rounded-md cursor-pointer transition-colors ${isTypeSelected ? "bg-primary/5 text-primary" : "hover:bg-muted/50"}`}>
                                        <input
                                          type="checkbox"
                                          className="w-3.5 h-3.5 rounded border-muted-foreground/30 text-primary focus:ring-primary/20"
                                          checked={isTypeSelected}
                                          onChange={(e) => handleTypeChange(t.name, e.target.checked)}
                                        />
                                        <span className={`text-[13px] transition-colors ${isTypeSelected ? "text-primary font-medium" : "text-muted-foreground"}`}>
                                          {t.name}
                                        </span>
                                      </label>
                                    );
                                  })}
                                </div>
                              )}
                            </div>
                          );
                        })}
                      </div>
                    )}
                  </div>
                );
              })}
            </div>
          </div>
        </aside>

        {/* Product Grid */}
        <section className="lg:col-span-3 space-y-8">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-muted/30 p-4 rounded-2xl">
            <h2 className="font-bold text-lg text-foreground">
              {isLoading ? "Đang tải dữ liệu..." : `Hiển thị ${pagination.total} sản phẩm`}
            </h2>

            <div className="flex items-center gap-4">
              {/* Sort Dropdown */}
              <div className="relative group">
                <select 
                  value={sortBy}
                  onChange={(e) => setSortBy(e.target.value)}
                  className="appearance-none bg-white border-2 border-primary/10 rounded-xl px-4 py-2 pr-10 text-sm font-bold text-gray-700 shadow-sm focus:ring-2 focus:ring-primary/20 cursor-pointer outline-none hover:border-primary/30 transition-all"
                >
                  <option value="newest">Mới nhất</option>
                  <option value="price-asc">Giá tăng dần</option>
                  <option value="price-desc">Giá giảm dần</option>
                </select>
                <ChevronDown className="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
              </div>

              {(selectedCategories.length > 0 || selectedProducts.length > 0 || selectedTypes.length > 0 || searchTerm) && (
              <div className="flex items-center gap-2 flex-wrap">
                <span className="text-sm text-muted-foreground">Đang lọc:</span>
                {searchTerm && (
                  <span className="inline-flex items-center gap-1 bg-white border px-3 py-1 rounded-full text-xs font-medium">
                    &quot;{searchTerm}&quot;
                    <X className="w-3 h-3 cursor-pointer hover:text-destructive" onClick={() => setSearchTerm("")} />
                  </span>
                )}
                {selectedCategories.map(slugStr => {
                   const catName = (navTree.length > 0 ? navTree : initialCategoriesData).find((c: any) => (c.slug === slugStr))?.name || (navTree.length > 0 ? navTree : initialCategoriesData).find((c: any) => (c.slug === slugStr))?.tendanhmuc || slugStr;
                  return (
                    <span key={slugStr} className="inline-flex items-center gap-1 bg-primary/10 border-primary/20 border px-3 py-1 rounded-full text-xs font-bold text-primary">
                      {catName}
                      <X className="w-3 h-3 cursor-pointer hover:text-destructive" onClick={() => handleCategoryChange(slugStr, false)} />
                    </span>
                  );
                })}
                {selectedProducts.map(name => (
                  <span key={name} className="inline-flex items-center gap-1 bg-accent/20 border-accent/30 border px-3 py-1 rounded-full text-xs font-bold text-accent-foreground">
                    {name}
                    <X className="w-3 h-3 cursor-pointer hover:text-destructive" onClick={() => handleProductChange(name, false)} />
                  </span>
                ))}
                {selectedTypes.map(name => (
                  <span key={name} className="inline-flex items-center gap-1 bg-secondary/20 border-secondary/30 border px-3 py-1 rounded-full text-xs font-bold text-secondary-foreground">
                    {name}
                    <X className="w-3 h-3 cursor-pointer hover:text-destructive" onClick={() => handleTypeChange(name, false)} />
                  </span>
                ))}
                <Button variant="ghost" size="sm" onClick={clearFilters} className="text-xs h-7 text-muted-foreground hover:text-destructive">
                  Xóa tất cả
                </Button>
              </div>
            )}
            </div>
          </div>

          {isLoading ? (
            <div className="flex flex-col items-center justify-center py-32 space-y-4">
              <Loader2 className="w-10 h-10 animate-spin text-primary" />
              <p className="text-muted-foreground animate-pulse">Đang tìm kiếm đặc sản chắt lọc...</p>
            </div>
          ) : products.length > 0 ? (
            <>
              <div className="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-10">
                {products.map((item: any, idx: number) => (
                  <ProductCard key={`${item.id_bienthe || item.id}-${idx}`} product={item} />
                ))}
              </div>

              {pagination.last_page > 1 && (
                <div className="flex items-center justify-center pt-16 pb-8">
                  <div className="flex items-center gap-2 bg-muted/40 p-2 rounded-full border border-border/50">
                    <Button variant="ghost" size="icon" className="rounded-full hover:bg-white shadow-sm"
                      onClick={() => setCurrentPage(p => Math.max(1, p - 1))} disabled={pagination.current_page === 1}>
                      <ChevronLeft className="w-5 h-5" />
                    </Button>
                    <div className="flex items-center gap-1 px-4">
                      {Array.from({ length: pagination.last_page }).map((_, i) => {
                        const page = i + 1;
                        const isCurrent = page === pagination.current_page;
                        if (page === 1 || page === pagination.last_page || (page >= pagination.current_page - 1 && page <= pagination.current_page + 1)) {
                          return (
                            <button key={page} onClick={() => setCurrentPage(page)}
                              className={`w-9 h-9 rounded-full text-sm font-bold transition-all ${isCurrent ? "bg-primary text-white shadow-md" : "text-muted-foreground hover:bg-white hover:text-foreground"}`}>
                              {page}
                            </button>
                          );
                        } else if (page === pagination.current_page - 2 || page === pagination.current_page + 2) {
                          return <span key={page} className="px-1 text-muted-foreground">...</span>;
                        }
                        return null;
                      })}
                    </div>
                    <Button variant="ghost" size="icon" className="rounded-full hover:bg-white shadow-sm"
                      onClick={() => setCurrentPage(p => Math.min(pagination.last_page, p + 1))} disabled={pagination.current_page === pagination.last_page}>
                      <ChevronRight className="w-5 h-5" />
                    </Button>
                  </div>
                </div>
              )}
            </>
          ) : (
            <div className="flex flex-col items-center justify-center py-32 bg-muted/20 rounded-[40px] border-dashed border-2 border-muted text-center px-4">
              <div className="w-20 h-20 bg-muted rounded-full flex items-center justify-center mb-6">
                <Search className="w-10 h-10 text-muted-foreground/50" />
              </div>
              <h3 className="font-merriweather font-bold text-2xl mb-2">Không tìm thấy sản phẩm</h3>
              <p className="text-muted-foreground max-w-md mx-auto mb-8">
                Rất tiếc bộ lọc của bạn không khớp với đặc sản nào. Vui lòng thử lại với từ khoá hoặc danh mục khác.
              </p>
              <Button onClick={clearFilters} size="lg" className="rounded-full px-8">
                Xóa bộ lọc ngay
              </Button>
            </div>
          )}
        </section>
      </main>
    </div>
  );
}

export function ProductsClientWrapper({ categories, vouchers }: { categories: any[], vouchers: any[] }) {
  return (
    <Suspense fallback={
      <div className="min-h-screen flex flex-col items-center justify-center space-y-6">
        <Loader2 className="w-12 h-12 animate-spin text-primary" />
        <p className="font-merriweather font-bold text-primary animate-pulse">Khởi tạo dữ liệu cửa hàng...</p>
      </div>
    }>
      <ProductsClient categories={categories} vouchers={vouchers} />
    </Suspense>
  );
}
