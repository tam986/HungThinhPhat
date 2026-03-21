import { useState, useEffect } from "react";
import Link from "next/link";
import { ShoppingBag } from "lucide-react";
import { Button } from "@/components/ui/button";
import { useCartStore } from "@/store/useCartStore";

export function CartButton() {
  const [mounted, setMounted] = useState(false);
  const getTotalItems = useCartStore((state) => state.getTotalItems);
  const totalItems = getTotalItems();

  useEffect(() => {
    setMounted(true);
  }, []);

  return (
    <Link href="/cart">
      <Button variant="outline" className="rounded-full px-6 flex items-center gap-2 hover:bg-primary/10 hover:text-primary transition-colors">
        <ShoppingBag className="w-5 h-5" />
        <span>Cart</span>
        <span className="bg-primary text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
          {mounted ? totalItems : 0}
        </span>
      </Button>
    </Link>
  );
}
