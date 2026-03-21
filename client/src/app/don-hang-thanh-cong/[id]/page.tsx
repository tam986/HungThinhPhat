"use client";

import { useEffect, useState } from "react";
import { useParams, useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { CheckCircle2, Package, ArrowRight, Home, Building2, Copy, Check } from "lucide-react";
import Link from "next/link";
import { motion } from "framer-motion";
import { fetchBankSettings } from "@/services/api";
import { toast } from "sonner";

export default function OrderSuccess() {
  const { id } = useParams();
  const [orderId, setOrderId] = useState<string>("");
  const [displayOrderCode, setDisplayOrderCode] = useState<string>("");
  const [bankInfo, setBankInfo] = useState<any>(null);
  const [copied, setCopied] = useState<string | null>(null);

  useEffect(() => {
    if (id) {
      const numericId = Array.isArray(id) ? id[0] : id;
      setOrderId(numericId);
      
      // Fetch order details to get ma_donhang
      import("@/services/api").then(api => {
        api.fetchOrderDetail(numericId).then(res => {
          if (res?.success && res.data) {
            setDisplayOrderCode(res.data.ma_donhang || numericId);
          } else {
            setDisplayOrderCode(numericId);
          }
        });
      });
    }
    
    async function loadBankInfo() {
      const api = await import("@/services/api");
      const res = await api.fetchBankSettings();
      if (res?.success) {
        setBankInfo(res.data);
      }
    }
    loadBankInfo();
  }, [id]);

  const copyToClipboard = (text: string, field: string) => {
    navigator.clipboard.writeText(text);
    setCopied(field);
    toast.success("Đã sao chép!");
    setTimeout(() => setCopied(null), 2000);
  };

  const getImageUrl = (path: string) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `http://127.0.0.1:8000/storage/${path}`;
  };

  return (
    <div className="container mx-auto px-4 py-24 min-h-screen flex items-center justify-center">
      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="max-w-2xl w-full text-center space-y-8"
      >
        <div className="relative inline-block">
            <motion.div
                initial={{ scale: 0 }}
                animate={{ scale: 1 }}
                transition={{ type: "spring", stiffness: 200, damping: 10, delay: 0.2 }}
                className="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto"
            >
                <CheckCircle2 className="w-12 h-12" />
            </motion.div>
            <motion.div 
                animate={{ scale: [1, 1.2, 1] }}
                transition={{ repeat: Infinity, duration: 2 }}
                className="absolute -top-1 -right-1 w-6 h-6 bg-primary rounded-full border-4 border-white"
            ></motion.div>
        </div>

        <div className="space-y-4">
            <h1 className="text-4xl font-merriweather font-bold text-neutral-900 border-b-4 border-primary inline-block pb-2">Đặt hàng thành công!</h1>
            <p className="text-muted-foreground text-lg">
                Cảm ơn bạn đã tin tưởng Hưng Thịnh Food. Đơn hàng của bạn đã được hệ thống ghi nhận.
            </p>
        </div>

        <div className="grid md:grid-cols-2 gap-6 items-start">
            <div className="bg-white p-6 rounded-[32px] border shadow-sm space-y-4 text-left">
                <div className="flex items-center justify-between text-sm">
                    <span className="text-muted-foreground flex items-center gap-2">
                        <Package className="w-4 h-4" />
                        Mã đơn hàng:
                    </span>
                    <span className="font-bold text-primary text-lg">#{displayOrderCode || orderId}</span>
                </div>
                <div className="pt-4 border-t space-y-2">
                    <p className="text-sm font-medium">Lưu ý:</p>
                    <ul className="text-xs text-muted-foreground space-y-2 list-disc pl-4">
                        <li>Hệ thống đã gửi email xác nhận chi tiết.</li>
                        <li>Nhân viên sẽ gọi điện xác nhận trong vòng 15-30 phút.</li>
                        <li>Vui lòng giữ điện thoại để nhận hàng.</li>
                    </ul>
                </div>
            </div>

            {bankInfo && (
                <div className="bg-neutral-900 text-white p-6 rounded-[32px] shadow-xl text-left space-y-4">
                    <div className="flex items-center gap-2 mb-2">
                        <Building2 className="w-5 h-5 text-primary" />
                        <h3 className="font-bold">Thông tin Chuyển khoản</h3>
                    </div>
                    
                    <div className="space-y-3">
                        <div className="bg-white/5 p-3 rounded-2xl flex justify-between items-center group">
                            <div>
                                <p className="text-[10px] text-white/50 uppercase">Số tài khoản</p>
                                <p className="font-bold font-mono text-primary text-lg">{bankInfo.bank_account_number}</p>
                            </div>
                            <button 
                                onClick={() => copyToClipboard(bankInfo.bank_account_number, 'stk')}
                                className="p-2 hover:bg-white/10 rounded-lg transition-colors"
                            >
                                {copied === 'stk' ? <Check className="w-4 h-4 text-green-400" /> : <Copy className="w-4 h-4" />}
                            </button>
                        </div>

                        <div className="bg-white/5 p-3 rounded-2xl">
                            <p className="text-[10px] text-white/50 uppercase">Chủ tài khoản</p>
                            <p className="font-bold">{bankInfo.bank_account_name}</p>
                        </div>
                        
                        <div className="bg-white/5 p-3 rounded-2xl">
                            <p className="text-[10px] text-white/50 uppercase">Ngân hàng</p>
                            <p className="font-bold text-sm">{bankInfo.bank_name}</p>
                        </div>
                    </div>

                    {bankInfo.bank_qr_code && (
                        <div className="pt-2 flex justify-center">
                            <div className="bg-white p-2 rounded-2xl w-32 h-32">
                                <img src={getImageUrl(bankInfo.bank_qr_code)} alt="QR" className="w-full h-full object-contain" />
                            </div>
                        </div>
                    )}
                </div>
            )}
        </div>

        <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button asChild className="h-14 px-8 rounded-2xl bg-primary hover:bg-primary/90 text-white font-bold text-lg gap-2 shadow-xl shadow-primary/20">
                <Link href="/">
                    Tiếp tục mua sắm
                    <ArrowRight className="w-5 h-5" />
                </Link>
            </Button>
            <Button asChild variant="outline" className="h-14 px-8 rounded-2xl gap-2 font-bold border-2">
                <Link href="/profile">
                    <Home className="w-5 h-5" />
                    Lịch sử đơn hàng
                </Link>
            </Button>
        </div>

        <div className="pt-8 border-t">
            <p className="text-sm text-muted-foreground">
                Mọi thắc mắc vui lòng liên hệ: <a href="tel:0123456789" className="font-bold text-neutral-900 hover:text-primary transition-colors">0123 456 789</a>
            </p>
        </div>
      </motion.div>
    </div>
  );
}
