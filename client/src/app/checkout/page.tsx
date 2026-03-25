"use client";

import { useState, useEffect } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Label } from "@/components/ui/label";
import { Building2, Truck, Upload as UploadIcon, CheckCircle2 } from "lucide-react";
import { fetchBankSettings, uploadOrderProof, processCheckout, getStorageUrl } from "@/services/api";

import { useAuthStore } from "@/store/useAuthStore";
import { useCartStore } from "@/store/useCartStore";
import { toast } from "sonner";
import { useRouter } from "next/navigation";
import { Upload, message } from "antd";

export default function Checkout() {
  const router = useRouter();
  const { user } = useAuthStore();
  const { items, getTotalPrice, clearCart } = useCartStore();

  const [paymentMethod, setPaymentMethod] = useState("cod");
  const [bankInfo, setBankInfo] = useState<any>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [transferProofUrl, setTransferProofUrl] = useState("");
  const [selectedVoucher, setSelectedVoucher] = useState<{ id: string; name: string; value: number } | null>(null);

  // Form states
  const [firstName, setFirstName] = useState(user?.name?.split(" ")[0] || "");
  const [lastName, setLastName] = useState(user?.name?.split(" ").slice(1).join(" ") || "");
  const [email, setEmail] = useState(user?.email || "");
  const [phone, setPhone] = useState(user?.phone || "");
  const [street, setStreet] = useState("");
  const [city, setCity] = useState("");
  const [zipCode, setZipCode] = useState("");

  const subtotal = getTotalPrice();
  const shippingFee = 15000;

  // Determine available vouchers based on subtotal
  const availableVouchers = [
    { id: "v10", name: "Voucher Ưu đãi 10k", value: 10000, min: 0, max: 500000 },
    { id: "v50", name: "Siêu ưu đãi 50k", value: 50000, min: 500001, max: 1000000 },
    { id: "v100", name: "Đại tiệc 100k", value: 100000, min: 1000001, max: 2000000 },
    { id: "v200", name: "Voucher Đặc biệt 200k", value: 200000, min: 2000001, max: Infinity },
  ].filter(v => subtotal >= v.min);

  const voucherValue = selectedVoucher ? selectedVoucher.value : 0;
  const total = subtotal + shippingFee - voucherValue;

  useEffect(() => {
    async function loadSettings() {
      const res = await fetchBankSettings();
      if (res?.success) {
        setBankInfo(res.data);
      }
    }
    loadSettings();
  }, []);

  const handlePlaceOrder = async () => {
    if (!firstName || !lastName || !email || !phone || !street || !city) {
      toast.error("Vui lòng điền đầy đủ thông tin.");
      return;
    }
    
    if (items.length === 0) {
      toast.error("Giỏ hàng của bạn đang trống.");
      return;
    }

    if (paymentMethod === "bankTransfer" && !transferProofUrl) {
      toast.error("Vui lòng tải lên ảnh bằng chứng chuyển khoản.");
      return;
    }

    setIsSubmitting(true);
    try {
      const payload = {
        payment_type: paymentMethod, // 'cod' or 'bankTransfer'
        id_user: user?.id || null,
        tennguoinhan: `${firstName} ${lastName}`,
        email,
        phone,
        diachi: `${street}, ${city} ${zipCode}`,
        cart: items.map(item => ({
          id_bienthe: item.id_bienthe,
          soluong: item.quantity,
          gia: item.price,
          tensp: item.name
        })),
        shipping_fee: shippingFee,
        voucher_value: voucherValue,
        transfer_proof: transferProofUrl
      };

      const res = await processCheckout(payload);
      
      if (res.success) {
        toast.success("Đặt hàng thành công!");
        clearCart();
        router.push(`/don-hang-thanh-cong/${res.order_id}`);
      } else {
        const errorMsg = typeof res.error === 'string' ? res.error : (res.message || "Không thể đặt hàng.");
        toast.error(errorMsg);
      }
    } catch (error) {
       console.error(error);
       toast.error("Có lỗi xảy ra khi xử lý đơn hàng.");
    } finally {
       setIsSubmitting(false);
    }
  };

  const getImageUrl = (path: string) => getStorageUrl(path);

  const handleUpload = async (options: any) => {
    const { file, onSuccess, onError } = options;
    try {
      const res = await uploadOrderProof(file);
      if (res.success) {
        setTransferProofUrl(res.url);
        onSuccess("ok");
        message.success("Tải ảnh lên thành công!");
      } else {
        onError("fail");
        message.error("Tải ảnh thất bại.");
      }
    } catch (err) {
      onError(err);
      message.error("Lỗi khi tải ảnh.");
    }
  };

  return (
    <div className="container mx-auto px-4 py-16 max-w-6xl min-h-screen">
      
      <div className="flex flex-col mb-12">
          <h1 className="text-4xl font-merriweather font-bold mb-2">Thanh toán</h1>
          <p className="text-muted-foreground">Hoàn tất đơn hàng của bạn</p>
      </div>

      <div className="grid lg:grid-cols-3 gap-12">
        
        {/* Form Left */}
        <div className="lg:col-span-2 space-y-10">
           
           <section className="space-y-6 bg-white p-8 rounded-3xl border shadow-sm">
              <h2 className="font-merriweather text-2xl font-bold flex items-center gap-2">
                <span className="w-8 h-8 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm">1</span>
                Thông tin nhận hàng
              </h2>
              <div className="grid md:grid-cols-2 gap-4">
                <Input value={firstName} onChange={(e) => setFirstName(e.target.value)} placeholder="Họ" className="rounded-2xl h-14" required />
                <Input value={lastName} onChange={(e) => setLastName(e.target.value)} placeholder="Tên" className="rounded-2xl h-14" required />
              </div>
              <Input value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" type="email" className="rounded-2xl h-14" required />
              <Input value={phone} onChange={(e) => setPhone(e.target.value)} placeholder="Số điện thoại" type="tel" className="rounded-2xl h-14" required />
              <Input value={street} onChange={(e) => setStreet(e.target.value)} placeholder="Địa chỉ chi tiết" className="rounded-2xl h-14" required />
              <div className="grid md:grid-cols-2 gap-4">
                <Input value={city} onChange={(e) => setCity(e.target.value)} placeholder="Tỉnh/Thành phố" className="rounded-2xl h-14" required />
                <Input value={zipCode} onChange={(e) => setZipCode(e.target.value)} placeholder="Mã bưu điện (tùy chọn)" className="rounded-2xl h-14" />
              </div>
           </section>

           <section className="space-y-6 bg-white p-8 rounded-3xl border shadow-sm">
              <h2 className="font-merriweather text-2xl font-bold flex items-center gap-2">
                <span className="w-8 h-8 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm">2</span>
                Voucher của bạn
              </h2>
              <RadioGroup value={selectedVoucher?.id} onValueChange={(val) => setSelectedVoucher(availableVouchers.find(v => v.id === val) || null)} className="grid grid-cols-1 md:grid-cols-2 gap-4">
                {availableVouchers.length > 0 ? (
                    availableVouchers.map((v) => (
                        <Label key={v.id} className={`flex items-center justify-between p-4 border rounded-2xl cursor-pointer transition-all ${selectedVoucher?.id === v.id ? 'border-primary bg-primary/5 ring-1 ring-primary' : 'hover:bg-muted/50'}`}>
                            <div className="flex items-center gap-3">
                                <RadioGroupItem value={v.id} id={v.id} />
                                <div>
                                    <p className="font-bold">{v.name}</p>
                                    <p className="text-xs text-muted-foreground">Giảm {new Intl.NumberFormat('vi-VN').format(v.value)}đ</p>
                                </div>
                            </div>
                            <CheckCircle2 className={`w-5 h-5 ${selectedVoucher?.id === v.id ? 'text-primary' : 'text-muted/30'}`} />
                        </Label>
                    ))
                ) : (
                    <p className="text-sm text-muted-foreground italic">Không có voucher nào phù hợp với đơn hàng này.</p>
                )}
              </RadioGroup>
           </section>
           
           <section className="space-y-6 bg-white p-8 rounded-3xl border shadow-sm">
              <h2 className="font-merriweather text-2xl font-bold flex items-center gap-2">
                <span className="w-8 h-8 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm">3</span>
                Phương thức thanh toán
              </h2>
              <RadioGroup value={paymentMethod} onValueChange={setPaymentMethod} className="space-y-4">
                
                <div className={`flex items-center space-x-3 p-5 border rounded-2xl transition-all cursor-pointer ${paymentMethod === 'cod' ? 'border-primary bg-primary/5 ring-1 ring-primary' : 'hover:bg-muted/50'}`}>
                  <RadioGroupItem value="cod" id="cod" className="w-5 h-5" />
                  <Label htmlFor="cod" className="flex flex-1 items-center justify-between cursor-pointer">
                    <div>
                        <p className="font-bold text-lg">Thanh toán khi nhận hàng (COD)</p>
                        <p className="text-sm text-muted-foreground">Trả tiền mặt khi người giao hàng đến</p>
                    </div>
                    <Truck className="w-8 h-8 text-primary/60" />
                  </Label>
                </div>
                
                <div className={`flex flex-col p-5 border rounded-2xl transition-all ${paymentMethod === 'bankTransfer' ? 'border-primary bg-primary/5 ring-1 ring-primary' : 'hover:bg-muted/50'}`}>
                  <div className="flex items-center space-x-3 w-full">
                    <RadioGroupItem value="bankTransfer" id="bankTransfer" className="w-5 h-5" />
                    <Label htmlFor="bankTransfer" className="flex flex-1 items-center justify-between cursor-pointer">
                        <div>
                            <p className="font-bold text-lg">Chuyển khoản ngân hàng</p>
                            <p className="text-sm text-muted-foreground">Chuyển khoản trực tiếp vào tài khoản shop</p>
                        </div>
                        <Building2 className="w-8 h-8 text-primary/60" />
                    </Label>
                  </div>
                  
                  {paymentMethod === "bankTransfer" && (
                    <div className="w-full pt-6 mt-6 border-t animate-in fade-in slide-in-from-top-4">
                       <div className="bg-white p-6 rounded-2xl shadow-sm border flex flex-col md:flex-row gap-8 items-center md:items-start">
                         <div className="w-40 h-40 shrink-0 rounded-2xl overflow-hidden bg-muted border p-2">
                           {bankInfo?.bank_qr_code ? (
                             // eslint-disable-next-line @next/next/no-img-element
                             <img src={getImageUrl(bankInfo.bank_qr_code)} alt="Bank QR Code" className="object-contain w-full h-full" />
                           ) : (
                             <div className="w-full h-full flex items-center justify-center text-xs text-muted-foreground text-center">QR Code Chưa cập nhật</div>
                           )}
                         </div>
                         <div className="flex-1 space-y-4">
                            <div className="space-y-1">
                                <p className="text-xs uppercase tracking-wider text-muted-foreground font-bold">Thông tin tài khoản</p>
                                <b className="text-primary text-2xl block">{bankInfo?.bank_name || "Mekong Delta Specialties"}</b>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <p className="text-xs text-muted-foreground">Số tài khoản</p>
                                    <p className="font-bold text-lg">{bankInfo?.bank_account_number || "0123456789"}</p>
                                </div>
                                <div>
                                    <p className="text-xs text-muted-foreground">Chủ tài khoản</p>
                                    <p className="font-bold text-lg">{bankInfo?.bank_account_name || "Mekong Shop"}</p>
                                </div>
                            </div>
                            <div className="bg-amber-50 p-3 rounded-xl border border-amber-200">
                                <p className="text-amber-800 text-xs font-medium">Nội dung chuyển khoản: <span className="font-bold underline">Checkout_{user?.id || 'GUEST'}_{Date.now().toString().slice(-6)}</span></p>
                            </div>

                            <div className="pt-4">
                                <p className="text-sm font-bold mb-3">Tải lên chứng từ thanh toán:</p>
                                <Upload customRequest={handleUpload} maxCount={1} listType="picture" showUploadList={{ showRemoveIcon: true }}>
                                    <Button variant="outline" className="w-full md:w-auto rounded-xl gap-2 h-12">
                                        <UploadIcon className="w-4 h-4" />
                                        Tải ảnh lên
                                    </Button>
                                </Upload>
                                {transferProofUrl && <p className="text-xs text-green-600 mt-2 flex items-center gap-1 font-bold"><CheckCircle2 className="w-3 h-3" /> Đã nhận ảnh chứng minh</p>}
                            </div>
                         </div>
                       </div>
                    </div>
                  )}
                </div>

              </RadioGroup>
           </section>
        </div>

        {/* Order Summary (Side) */}
        <div>
          <div className="bg-neutral-900 text-white p-8 rounded-[40px] space-y-8 sticky top-28 shadow-2xl">
            <h2 className="font-merriweather text-2xl font-bold">Đơn hàng của bạn</h2>
            
            <div className="space-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
               {items.map((item) => (
                 <div key={item.id_bienthe} className="flex items-center gap-4">
                   <div className="w-16 h-16 bg-white/10 rounded-2xl overflow-hidden shrink-0 border border-white/5">
                      {item.image && (
                        <div className="w-full h-full bg-cover bg-center" style={{ backgroundImage: `url(${getImageUrl(item.image)})` }} />
                      )}
                   </div>
                   <div className="flex-1 min-w-0">
                     <p className="font-bold text-sm truncate">{item.name}</p>
                     <p className="text-white/50 text-xs">SL: {item.quantity}</p>
                   </div>
                   <span className="font-medium shrink-0">
                      {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.price * item.quantity)}
                   </span>
                 </div>
               ))}
            </div>
            
            <div className="border-t border-white/10 pt-6 space-y-3 text-sm">
               <div className="flex justify-between text-white/60">
                 <span>Tạm tính</span>
                 <span>{new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(subtotal)}</span>
               </div>
               <div className="flex justify-between text-white/60">
                 <span>Phí vận chuyển</span>
                 <span>{new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(shippingFee)}</span>
               </div>
               {selectedVoucher && (
                 <div className="flex justify-between text-green-400 font-bold">
                    <span>Voucher ({selectedVoucher.name})</span>
                    <span>-{new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(selectedVoucher.value)}</span>
                 </div>
               )}
            </div>

            <div className="border-t border-white/10 pt-6 flex justify-between items-end">
               <span className="text-white/60">Tổng thanh toán</span>
               <span className="text-3xl font-bold text-primary">{new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total)}</span>
            </div>

            <Button disabled={isSubmitting || items.length === 0} onClick={handlePlaceOrder} className="w-full h-16 rounded-2xl bg-primary hover:bg-primary/90 text-white text-xl font-bold mt-6 shadow-xl shadow-primary/20 transition-all active:scale-[0.98]">
              {isSubmitting ? (
                <div className="flex items-center gap-2">
                    <span className="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    Đang xử lý...
                </div>
              ) : "Xác nhận Đặt hàng"}
            </Button>

            <p className="text-[10px] text-center text-white/30 px-4">Bằng cách nhấn đặt hàng, bạn đồng ý với các Điều khoản & Chính sách của Hưng Thịnh Food.</p>
          </div>
        </div>

      </div>
    </div>
  );
}
