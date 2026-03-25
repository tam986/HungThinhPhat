'use client';
import { useEffect, useState } from "react";
import { Button } from "@/components/ui/button";
import { Minus, Plus, Trash2, ArrowRight, AlertCircle, ShoppingBag } from "lucide-react";
import { useCartStore } from "@/store/useCartStore";
import { validateCartStock, getStorageUrl } from "@/services/api";
import Link from "next/link";
import { toast } from "sonner";
import { useRouter } from "next/navigation";

export default function Cart() {
  const router = useRouter();
  const { items: cartItems, removeItem, updateQuantity } = useCartStore();
  
  const [stockStatus, setStockStatus] = useState<Record<string, { status: string, available: number }>>({});
  const [isValidating, setIsValidating] = useState(false);
  const [checkoutAllowed, setCheckoutAllowed] = useState(false);

  // Subtotal calculating
  const subtotal = cartItems.reduce((acc, item) => acc + (item.price * item.quantity), 0);
  const hasItems = cartItems.length > 0;

  useEffect(() => {
    async function checkStock() {
      if (!hasItems) return;
      setIsValidating(true);
      try {
        const payload = cartItems.map(item => ({ id_bienthe: item.id_bienthe, quantity: item.quantity }));
        const res = await validateCartStock(payload);
        
        if (res && res.validation) {
          const statusMap: Record<string, any> = {};
          let canCheckout = true;

          res.validation.forEach((v: any) => {
            statusMap[v.id_bienthe] = { status: v.status, available: v.available };
            if (v.status === 'out_of_stock' || v.status === 'not_found') {
              canCheckout = false;
            }
            if (v.status === 'not_enough_stock') {
              // Automatically clamp the quantity
              updateQuantity(v.id_bienthe, v.available);
              toast.error(`Sản phẩm đã bị giới hạn chỉ còn ${v.available} hộp trong kho.`);
            }
          });

          setStockStatus(statusMap);
          setCheckoutAllowed(canCheckout);
        }
      } catch (err) {
        console.error("Cart validation failed", err);
      } finally {
        setIsValidating(false);
      }
    }

    checkStock();
  }, [cartItems]); // Depends on cart items

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price);
  };

  const getImageUrl = (path?: string) => getStorageUrl(path || "");

  if (!hasItems) {
     return (
        <div className="container mx-auto px-4 py-32 flex flex-col items-center justify-center min-h-[60vh]">
           <div className="w-24 h-24 bg-muted rounded-full flex items-center justify-center mb-6">
             <ShoppingBag className="w-10 h-10 text-muted-foreground" />
           </div>
           <h2 className="font-merriweather text-3xl mb-4 font-bold">Giỏ hàng trống</h2>
           <p className="text-muted-foreground mb-8">Bạn chưa thêm bất kỳ đặc sản nào vào giỏ hàng.</p>
           <Link href="/products">
             <Button className="rounded-full px-8 h-12">Khám phá Đặc Sản ngay</Button>
           </Link>
        </div>
     )
  }

  return (
    <div className="container mx-auto px-4 py-32 max-w-6xl min-h-screen">
      <h1 className="font-merriweather text-4xl mb-12 font-bold">Giỏ Hàng Của Bạn</h1>
      
      <div className="grid lg:grid-cols-3 gap-12">
        {/* Cart Items List */}
        <div className="lg:col-span-2 space-y-6">
          {isValidating && (
             <div className="text-sm text-primary animate-pulse mb-4 flex items-center gap-2">
               <span className="w-4 h-4 border-2 border-primary border-t-transparent rounded-full animate-spin"></span>
               Đang kiểm tra tình trạng kho hàng...
             </div>
          )}

          {cartItems.map((item) => {
             const statusRecord = stockStatus[item.id_bienthe];
             const isOutOfStock = statusRecord && (statusRecord.status === 'out_of_stock' || statusRecord.status === 'not_found');
             const hasNotEnough = statusRecord && statusRecord.status === 'not_enough_stock';

             return (
               <div key={item.id_bienthe} className={`flex gap-6 items-center p-4 bg-white rounded-[32px] shadow-sm border ${isOutOfStock ? 'border-red-200 bg-red-50/50 opacity-80' : 'border-muted/50'} relative transition-all`}>
                 <div className="w-28 h-28 bg-muted rounded-2xl shrink-0 overflow-hidden relative">
                   {/* eslint-disable-next-line @next/next/no-img-element */}
                   <img src={getImageUrl(item.image)} alt={item.name} className={`w-full h-full object-cover ${isOutOfStock ? 'grayscale opacity-70' : ''}`} />
                   {isOutOfStock && (
                      <div className="absolute inset-0 bg-white/40 flex items-center justify-center">
                         <span className="bg-red-500 text-white text-[10px] uppercase font-bold px-2 py-1 rounded">Hết hàng</span>
                      </div>
                   )}
                 </div>
                 
                 <div className="flex-1 space-y-1">
                   <h3 className={`font-bold text-lg ${isOutOfStock ? 'line-through text-gray-500' : ''}`}>{item.name}</h3>
                   {item.weight && <p className="text-muted-foreground text-sm">Biến thể: {item.weight}</p>}
                   <p className="font-medium text-accent pt-1">{formatPrice(item.price)}</p>
                   
                   {isOutOfStock && (
                      <div className="flex items-center gap-1 text-xs text-red-500 font-bold mt-2">
                        <AlertCircle className="w-3 h-3" /> Sản phẩm này vừa hết hàng. Vui lòng xoá!
                      </div>
                   )}
                   {hasNotEnough && (
                      <div className="flex items-center gap-1 text-xs text-orange-500 mt-2">
                        <AlertCircle className="w-3 h-3" /> Kho chỉ còn {statusRecord.available} hộp
                      </div>
                   )}
                 </div>
                 
                 <div className="flex flex-col sm:flex-row items-center gap-4 px-4">
                   <div className={`flex items-center bg-muted/50 rounded-full p-1 ${isOutOfStock ? 'pointer-events-none opacity-50' : ''}`}>
                      <Button 
                        variant="ghost" size="icon" className="w-8 h-8 rounded-full"
                        onClick={() => updateQuantity(item.id_bienthe, Math.max(1, item.quantity - 1))}
                        disabled={isOutOfStock || item.quantity <= 1}
                      >
                        <Minus className="w-3 h-3" />
                      </Button>
                      <span className="w-8 text-center text-sm font-medium">{item.quantity}</span>
                      <Button 
                        variant="ghost" size="icon" className="w-8 h-8 rounded-full"
                        onClick={() => updateQuantity(item.id_bienthe, item.quantity + 1)}
                        disabled={isOutOfStock || (statusRecord && statusRecord.available <= item.quantity)}
                      >
                        <Plus className="w-3 h-3" />
                      </Button>
                   </div>
                   <Button variant="ghost" size="icon" className="text-muted-foreground hover:text-destructive hover:bg-red-50 rounded-full" onClick={() => removeItem(item.id_bienthe)}>
                     <Trash2 className="w-5 h-5" />
                   </Button>
                 </div>
               </div>
             )
          })}
        </div>

        {/* Order Summary Checkout Panel */}
        <div className="bg-secondary/20 p-8 rounded-[40px] h-fit sticky top-28 space-y-6 border border-secondary/30">
          <h2 className="font-merriweather text-2xl font-bold">Tóm tắt đơn hàng</h2>
          <div className="space-y-4 text-muted-foreground">
             <div className="flex justify-between">
               <span>Tạm tính ({cartItems.length} sản phẩm)</span>
               <span className="font-medium text-foreground">{formatPrice(subtotal)}</span>
             </div>
             <div className="flex justify-between">
               <span>Phí vận chuyển</span>
               <span className="font-medium text-foreground text-sm">Tính toán ở Bước thanh toán</span>
             </div>
             <div className="border-t border-border pt-4 mt-4 flex justify-between text-lg text-foreground">
               <span className="font-bold">Tổng cộng</span>
               <span className="font-bold text-accent">{formatPrice(subtotal)}</span>
             </div>
          </div>
          
          <Button 
            className="w-full h-14 rounded-full bg-primary hover:bg-primary/90 text-lg group shadow-lg"
            disabled={!checkoutAllowed || isValidating}
            onClick={() => router.push('/checkout')}
          >
            {isValidating ? "Đang xác thực..." : "Tiến hành Thanh Toán"}
            <ArrowRight className="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" />
          </Button>
          {!checkoutAllowed && (
            <p className="text-xs text-center text-red-500 mx-auto font-medium leading-relaxed">
              Bạn có sản phẩm "Hết hàng" trong giỏ. Vui lòng xoá bớt để tiếp tục.
            </p>
          )}
        </div>
      </div>
    </div>
  );
}
