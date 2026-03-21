"use client";

import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Heart, Minus, Plus } from "lucide-react";
import { useCartStore } from "@/store/useCartStore";
import { toast } from "sonner";

interface AddToCartProps {
  product: {
    id: number;
    id_bienthe: number;
    name: string;
    price: number;
    image?: string;
    weight?: string;
  };
  quantity?: number;
}

export default function AddToCart({ product, quantity: externalQuantity }: AddToCartProps) {
  const [internalQuantity, setInternalQuantity] = useState(1);
  const quantity = externalQuantity !== undefined ? externalQuantity : internalQuantity;
  const setQuantity = setInternalQuantity;
  const addItem = useCartStore((state) => state.addItem);

  const handleAdd = () => {
    addItem({
      id: product.id,
      id_bienthe: product.id_bienthe,
      name: product.name,
      price: product.price,
      quantity,
      image: product.image,
      weight: product.weight,
    });
    toast.success(`Đã thêm ${quantity} ${product.name} vào giỏ hàng!`);
  };

  return (
    <div className="flex items-center gap-6 pt-4">
      {externalQuantity === undefined && (
        <div className="flex items-center bg-muted/50 rounded-full h-14 p-1">
          <Button 
            variant="ghost" 
            size="icon" 
            className="rounded-full h-12 w-12 hover:bg-white"
            onClick={() => setQuantity(Math.max(1, quantity - 1))}
          >
            <Minus className="w-4 h-4" />
          </Button>
          <span className="w-12 text-center font-medium">{quantity}</span>
          <Button 
            variant="ghost" 
            size="icon" 
            className="rounded-full h-12 w-12 hover:bg-white"
            onClick={() => setQuantity(quantity + 1)}
          >
            <Plus className="w-4 h-4" />
          </Button>
        </div>
      )}
      <Button 
        onClick={handleAdd}
        className="flex-1 h-14 rounded-full bg-primary hover:bg-primary/90 text-lg shadow-lg shadow-primary/20"
      >
        Thêm vào giỏ hàng
      </Button>
      <Button variant="outline" size="icon" className="h-14 w-14 rounded-full shrink-0">
        <Heart className="w-5 h-5" />
      </Button>
    </div>
  );
}
