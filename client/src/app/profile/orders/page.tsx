"use client";

import { useEffect, useState } from "react";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Package, Truck, CheckCircle2 } from "lucide-react";
import { useAuthStore } from "@/store/useAuthStore";
import Pusher from "pusher-js";
import { toast } from "sonner";

export default function OrderHistory() {
  const { user } = useAuthStore();
  
  const [orders, setOrders] = useState([
    { id: "ORD-9821A", realId: 1, date: "May 24, 2026", total: 95.00, status: "Processing", items: 2 },
    { id: "ORD-7543B", realId: 2, date: "April 12, 2026", total: 45.00, status: "Delivered", items: 1 },
    { id: "ORD-1234C", realId: 3, date: "June 05, 2026", total: 120.00, status: "Processing", items: 4 },
  ]);

  useEffect(() => {
    // We only listen if we have a valid user ID
    if (!user || !user.id) return;

    const pusherKey = process.env.NEXT_PUBLIC_PUSHER_APP_KEY;
    const pusherCluster = process.env.NEXT_PUBLIC_PUSHER_CLUSTER;

    if (!pusherKey) return;

    const pusher = new Pusher(pusherKey, {
      cluster: pusherCluster || "ap1",
    });

    const channelName = `user.order.${user.id}`;
    const channel = pusher.subscribe(channelName);

    channel.bind("App\\Events\\OrderStatusChanged", (data: any) => {
      console.log("Realtime Event:", data);
      
      let newStatus = "Processing";
      if (data.status === "đang giao") newStatus = "Shipping";
      if (data.status === "hoàn thành") newStatus = "Delivered";
      if (data.status === "đã hủy") newStatus = "Cancelled";

      toast.success(`Đơn hàng #${data.order_id} của bạn đã được cập nhật thành: ${data.status.toUpperCase()}`);

      // Update the local state
      setOrders(prev => prev.map(o => {
         // (Mock feature fallback: since we don't know the exact realId mapping yet, we just update the first processing one 
         // OR exactly the one matching order_id if it matched our hardcoded numbers)
         if (o.realId === data.order_id || o.status === "Processing") {
           return { ...o, status: newStatus };
         }
         return o;
      }));
    });

    return () => {
      channel.unbind_all();
      channel.unsubscribe();
      pusher.disconnect();
    };
  }, [user]);

  const getStatusBadge = (status: string) => {
    switch(status) {
      case "Processing": return <Badge className="bg-yellow-100 text-yellow-800 hover:bg-yellow-100/80 rounded-full border-transparent">Processing</Badge>;
      case "Shipping": return <Badge className="bg-blue-100 text-blue-800 hover:bg-blue-100/80 rounded-full border-transparent">Shipping</Badge>;
      case "Delivered": return <Badge className="bg-green-100 text-green-800 hover:bg-green-100/80 rounded-full border-transparent">Delivered</Badge>;
      default: return <Badge className="rounded-full">{status}</Badge>;
    }
  };

  return (
    <div className="container mx-auto px-4 py-16 max-w-4xl min-h-screen space-y-12">
      <div className="space-y-4">
        <h1 className="font-merriweather text-4xl font-bold">Order History</h1>
        <p className="text-muted-foreground text-lg">Track your artisan delicacies and view past purchases.</p>
      </div>

      <div className="space-y-8">
        {orders.map(order => (
          <Card key={order.id} className="rounded-[40px] overflow-hidden shadow-sm border-none bg-white">
            <CardHeader className="bg-secondary/20 p-6 md:px-10 flex flex-row items-center justify-between">
              <div>
                <CardTitle className="text-xl font-bold">Order <span className="text-primary">#{order.id}</span></CardTitle>
                <p className="text-sm text-muted-foreground mt-1">Placed on {order.date}</p>
              </div>
              <div className="text-right">
                <p className="font-bold text-accent text-xl">${order.total.toFixed(2)}</p>
                <div className="mt-1">{getStatusBadge(order.status)}</div>
              </div>
            </CardHeader>
            <CardContent className="p-6 md:p-10">
               {/* Vertical Tracking Timeline for Active Orders */}
               {order.status !== "Delivered" && (
                 <div className="mb-10 relative">
                    <div className="absolute left-[23px] top-6 bottom-6 w-0.5 bg-muted"></div>
                    <div className="space-y-8">
                       <div className="flex gap-6 items-center">
                         <div className="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center shrink-0 z-10 ring-4 ring-white"><CheckCircle2 className="w-5 h-5"/></div>
                         <div>
                           <h4 className="font-bold">Order Confirmed</h4>
                           <p className="text-sm text-muted-foreground">We have received your order.</p>
                         </div>
                       </div>
                       <div className="flex gap-6 items-center">
                         <div className={`w-12 h-12 rounded-full flex items-center justify-center shrink-0 z-10 ring-4 ring-white ${order.status === 'Shipping' ? 'bg-primary text-white' : 'bg-muted text-muted-foreground'}`}>
                           <Package className="w-5 h-5"/>
                         </div>
                         <div>
                           <h4 className={`font-bold ${order.status !== 'Shipping' ? 'text-muted-foreground' : ''}`}>Processing</h4>
                           <p className="text-sm text-muted-foreground">Artisans are preparing your items.</p>
                         </div>
                       </div>
                       <div className="flex gap-6 items-center">
                         <div className="w-12 h-12 rounded-full bg-muted text-muted-foreground flex items-center justify-center shrink-0 z-10 ring-4 ring-white"><Truck className="w-5 h-5"/></div>
                         <div>
                           <h4 className="font-bold text-muted-foreground">On the Way</h4>
                           <p className="text-sm text-muted-foreground">Pending handover to courier.</p>
                         </div>
                       </div>
                    </div>
                 </div>
               )}

               <div className="flex items-center gap-4 p-4 border rounded-[32px] bg-muted/10">
                 <div className="w-16 h-16 bg-sage-200 rounded-2xl shrink-0"></div>
                 <div className="flex-1">
                   <p className="font-bold text-sm">Premium Dried Shrimp</p>
                   <p className="text-muted-foreground text-xs">Variant: 500g x 1</p>
                 </div>
                 {order.items > 1 && (
                   <span className="text-sm text-muted-foreground pr-4">+ {order.items - 1} other item(s)</span>
                 )}
               </div>
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  );
}
