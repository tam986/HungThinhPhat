"use client";

import { useState, useEffect, useRef } from "react";
import { Search } from "lucide-react";
import Link from "next/link";
import { useDebounce } from "@/hooks/useDebounce";
import { API_BASE_URL, getStorageUrl } from "@/services/api";

export function NavbarSearch() {
  const [query, setQuery] = useState("");
  const [results, setResults] = useState<any[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [isOpen, setIsOpen] = useState(false);
  const searchRef = useRef<HTMLDivElement>(null);

  const debouncedQuery = useDebounce(query, 500);

  useEffect(() => {
    async function search() {
      if (!debouncedQuery.trim()) {
        setResults([]);
        setIsOpen(false);
        return;
      }

      setIsLoading(true);
      try {
        const res = await fetch(`${API_BASE_URL}/sanpham?search=${encodeURIComponent(debouncedQuery)}`);
        if (res.ok) {
          const data = await res.json();
          // The API returns { bienthes: { data: [...] }, ... }
          const items = data.bienthes?.data || [];
          setResults(items);
          setIsOpen(true);
        }
      } catch (error) {
        console.error("Search failed:", error);
      } finally {
        setIsLoading(false);
      }
    }

    search();
  }, [debouncedQuery]);

  // Click outside to close dropdown
  useEffect(() => {
    function handleClickOutside(event: MouseEvent) {
      if (searchRef.current && !searchRef.current.contains(event.target as Node)) {
        setIsOpen(false);
      }
    }
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  const getImageUrl = (path: string) => getStorageUrl(path);

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
  };

  return (
    <div ref={searchRef} className="relative w-full">
      <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" />
      <input 
        type="text" 
        value={query}
        onChange={(e) => setQuery(e.target.value)}
        onFocus={() => {
          if (results.length > 0) setIsOpen(true);
        }}
        placeholder="Tìm kiếm sản phẩm..." 
        className="w-full h-12 pl-12 pr-4 rounded-[28px] bg-muted/50 focus:outline-none focus:ring-2 ring-primary transition-all text-sm"
      />

      {/* Dropdown Results */}
      {isOpen && (
        <div className="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl border overflow-hidden z-50 animate-in fade-in slide-in-from-top-2">
          {isLoading ? (
            <div className="p-4 text-center text-sm text-muted-foreground">Đang tìm kiếm...</div>
          ) : results.length > 0 ? (
            <div className="max-h-[400px] overflow-y-auto p-2">
              <div className="px-3 md:px-4 py-2 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                Kết quả tìm kiếm
              </div>
              {results.map((item) => {
                const gia = item.price ?? item.gia ?? 0;
                const giakm = item.giakm ?? 0;
                const isSale = giakm > 0 && giakm < gia;
                const currentPrice = isSale ? giakm : gia;
                const hinhAnh = item.image || item.hinhanh || item.hinh;
                const tensp = item.name || item.tensp || item.sanpham?.tensp || "Sản phẩm";

                return (
                  <Link 
                    key={item.id_bienthe || item.id} 
                    href={`/products/${item.slug || item.id_bienthe}`}
                    onClick={() => setIsOpen(false)}
                    className="flex items-center gap-4 p-3 hover:bg-muted/50 rounded-xl transition-colors group"
                  >
                    <div className="w-16 h-16 shrink-0 bg-muted rounded-lg overflow-hidden">
                      {hinhAnh && (
                        // eslint-disable-next-line @next/next/no-img-element
                        <img 
                          src={getImageUrl(hinhAnh)} 
                          alt={tensp} 
                          className="w-full h-full object-cover group-hover:scale-105 transition-transform"
                        />
                      )}
                    </div>
                    <div className="flex-1 min-w-0">
                      <h4 className="font-bold text-base truncate text-foreground group-hover:text-primary transition-colors">
                        {tensp}
                      </h4>
                      <div className="flex items-center gap-3 mt-1">
                        <span className={`font-bold ${isSale ? 'text-destructive' : 'text-foreground'}`}>
                          {formatPrice(currentPrice)}
                        </span>
                        {isSale && (
                          <span className="text-sm text-muted-foreground line-through decoration-muted-foreground/50">
                            {formatPrice(gia)}
                          </span>
                        )}
                      </div>
                    </div>
                  </Link>
                )
              })}
            </div>
          ) : (
            <div className="p-4 text-center text-sm text-muted-foreground">Không tìm thấy sản phẩm nào.</div>
          )}
        </div>
      )}
    </div>
  );
}
