import React, { useState, useMemo } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm, router } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Plus, 
  Trash2, 
  Search, 
  User, 
  Package, 
  ShoppingCart, 
  CreditCard, 
  Truck,
  CheckCircle2,
  AlertCircle,
  ChevronRight,
  Calculator
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface Variant {
  id: number;
  id_sp: number;
  id_nhanbanh: number | null;
  id_khoiluong: number;
  soluong: number;
  gia: number;
  giakm: number | null;
  khoiluong: { id: number; khoiluong: string };
  nhanbanh: { id: number; tenNhanBanh: string } | null;
}

interface Product {
  id: number;
  tensp: string;
  bienthe: Variant[];
}

interface Customer {
  id: number;
  hoten: string;
  email: string;
  sodienthoai: string;
  diachi: string;
}

interface Voucher {
  id: number;
  tenphieu: string;
  hesogiamgia: number;
  sotientoithieu: number;
}

interface Props {
  users: Customer[];
  sanphams: Product[];
  vouchers: Voucher[];
}

export default function OrderCreate({ users, sanphams, vouchers }: Props) {
  const [selectedProduct, setSelectedProduct] = useState<number | ''>('');
  const [selectedVariant, setSelectedVariant] = useState<number | ''>('');
  const [quantity, setQuantity] = useState(1);
  const [searchCustomer, setSearchCustomer] = useState('');

  const { data, setData, post, processing, errors } = useForm({
    id_user: '',
    tennguoinhan: '',
    phone: '',
    email: '',
    diachi: '',
    thanhtoan: 'pay_later',
    vanchuyen: 'fast',
    trangthai: 'chĐ xác nhận',
    id_giamgia: '',
    sotiengiam: 0,
    ghichu: '',
    order_items: [] as any[],
  });

  const filteredUsers = useMemo(() => {
    if (!searchCustomer) return [];
    return users.filter(u => 
      u.hoten.toLowerCase().includes(searchCustomer.toLowerCase()) || 
      u.sodienthoai.includes(searchCustomer)
    );
  }, [searchCustomer, users]);

  const selectUser = (user: Customer) => {
    setData(prev => ({
      ...prev,
      id_user: user.id.toString(),
      tennguoinhan: user.hoten,
      phone: user.sodienthoai,
      email: user.email,
      diachi: user.diachi || '',
    }));
    setSearchCustomer('');
  };

  const currentProduct = useMemo(() => 
    sanphams.find(p => p.id === selectedProduct), 
  [selectedProduct, sanphams]);

  const currentVariant = useMemo(() => 
    currentProduct?.bienthe.find(v => v.id === selectedVariant),
  [currentProduct, selectedVariant]);

  const addItem = () => {
    if (!selectedProduct || !selectedVariant || !currentVariant) return;
    
    const existing = data.order_items.find(item => item.id_bienthe === selectedVariant);
    if (existing) {
       setData('order_items', data.order_items.map(item => 
         item.id_bienthe === selectedVariant ? { ...item, soluong: item.soluong + quantity } : item
       ));
    } else {
       setData('order_items', [
         ...data.order_items,
         {
           id_bienthe: currentVariant.id,
           tensp: currentProduct?.tensp,
           variant_name: `${currentVariant.khoiluong.khoiluong} • ${currentVariant.nhanbanh?.tenNhanBanh || 'Không nhận'}`,
           soluong: quantity,
           gia: currentVariant.giakm || currentVariant.gia
         }
       ]);
    }
    
    setSelectedProduct('');
    setSelectedVariant('');
    setQuantity(1);
  };

  const removeItem = (id: number) => {
    setData('order_items', data.order_items.filter(item => item.id_bienthe !== id));
  };

  const subtotal = useMemo(() => 
    data.order_items.reduce((sum, item) => sum + (item.gia * item.soluong), 0),
  [data.order_items]);

  const shippingFee = data.vanchuyen === 'superFast' ? 50000 : 30000;
  
  const selectedVoucher = useMemo(() => 
    vouchers.find(v => v.id.toString() === data.id_giamgia),
  [data.id_giamgia, vouchers]);

  const calculatedDiscount = useMemo(() => {
    if (!selectedVoucher || subtotal < selectedVoucher.sotientoithieu) return 0;
    return selectedVoucher.hesogiamgia;
  }, [selectedVoucher, subtotal]);

  const total = subtotal + shippingFee - calculatedDiscount;

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('donhang.store'), {
       onSuccess: () => router.visit(route('donhang.index')),
    });
  };

  return (
    <AdminLayout>
      <Head title="Tạo đơn hàng mới" />

      <div className="flex items-center gap-4 mb-8">
        <Link href={route('donhang.index')} className="p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-400 hover:text-primary transition-all shadow-sm">
          <ArrowLeft size={20} />
        </Link>
        <div>
           <h1 className="text-2xl font-black tracking-tight text-slate-900 text-dark">Tạo đơn hàng mới</h1>
           <p className="text-slate-500 text-sm font-bold italic">Tạo đơn hàng thủ Bán hàng cho khách tại quầy hoặc qua điện thoại.</p>
        </div>
      </div>

      <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {/* Main Form */}
        <div className="lg:col-span-2 space-y-8">
           {/* Customer Selection */}
           <div className="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm text-dark relative">
              <h3 className="font-black text-slate-800 mb-6 flex items-center gap-2 uppercase tracking-tight">
                 <User size={20} className="text-primary" />
                 Thàng tin khách hàng
              </h3>
              
              <div className="space-y-6">
                 <div className="relative">
                    <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Tìm kiếm khách hàng cũ</label>
                    <div className="relative">
                       <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300" size={18} />
                       <input 
                         type="text"
                         value={searchCustomer}
                         onChange={e => setSearchCustomer(e.target.value)}
                         placeholder="Nhập tiền hoặc số điện thoại..."
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 pl-12 pr-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                       />
                    </div>
                    {filteredUsers.length > 0 && (
                      <div className="absolute z-10 w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-xl max-h-60 overflow-y-auto p-2 space-y-1 animate-in fade-in zoom-in-95 duration-200">
                         {filteredUsers.map(user => (
                           <button
                             key={user.id}
                             type="button"
                             onClick={() => selectUser(user)}
                             className="w-full text-left p-3 hover:bg-slate-50 rounded-xl flex items-center justify-between group transition-colors"
                           >
                             <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                   {user.hoten.charAt(0)}
                                </div>
                                <div className="flex flex-col">
                                   <span className="font-bold text-sm">{user.hoten}</span>
                                   <span className="text-[10px] text-slate-400 font-black">{user.sodienthoai}</span>
                                </div>
                             </div>
                             <Plus size={16} className="text-slate-300 group-hover:text-primary" />
                           </button>
                         ))}
                      </div>
                    )}
                 </div>

                 <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tên ngưĐi nhận</label>
                       <input 
                         required
                         type="text"
                         value={data.tennguoinhan}
                         onChange={e => setData('tennguoinhan', e.target.value)}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                       />
                       {errors.tennguoinhan && <p className="text-red-500 text-[10px] font-bold mt-1 uppercase italic">{errors.tennguoinhan}</p>}
                    </div>
                    <div className="space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Số điện thoại</label>
                       <input 
                         required
                         type="text"
                         value={data.phone}
                         onChange={e => setData('phone', e.target.value)}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                       />
                    </div>
                    <div className="space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                       <input 
                         required
                         type="email"
                         value={data.email}
                         onChange={e => setData('email', e.target.value)}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                       />
                    </div>
                    <div className="space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Địa chỉ nhận hàng</label>
                       <input 
                         required
                         type="text"
                         value={data.diachi}
                         onChange={e => setData('diachi', e.target.value)}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                       />
                    </div>
                 </div>
              </div>
           </div>

           {/* Product Builder */}
           <div className="bg-white rounded-[32px] border border-slate-200 shadow-sm text-dark overflow-hidden">
              <div className="p-8 border-b border-slate-100 pb-6">
                 <h3 className="font-black text-slate-800 flex items-center gap-2 uppercase tracking-tight">
                    <Package size={20} className="text-indigo-500" />
                    Thêm sản phẩm vào giĐ
                 </h3>
                 
                 <div className="mt-6 flex flex-col md:flex-row gap-4">
                    <div className="flex-1 space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">ChĐn sản phẩm</label>
                       <select 
                         value={selectedProduct}
                         onChange={e => { setSelectedProduct(Number(e.target.value)); setSelectedVariant(''); }}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all appearance-none"
                       >
                          <option value="">-- ChĐn sản phẩm --</option>
                          {sanphams.map(sp => <option key={sp.id} value={sp.id}>{sp.tensp}</option>)}
                       </select>
                    </div>
                    <div className="flex-1 space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">ChĐn phần loại</label>
                       <select 
                         value={selectedVariant}
                         disabled={!selectedProduct}
                         onChange={e => setSelectedVariant(Number(e.target.value))}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all appearance-none disabled:opacity-50"
                       >
                          <option value="">-- ChĐn phần loại --</option>
                          {currentProduct?.bienthe.map(v => (
                            <option key={v.id} value={v.id}>
                               {v.khoiluong.khoiluong} • {v.nhanbanh?.tenNhanBanh || 'Không nhận'} ({new Intl.NumberFormat('vi-VN').format(v.giakm || v.gia)} đ)
                            </option>
                          ))}
                       </select>
                    </div>
                    <div className="w-24 space-y-2">
                       <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-center block">S.Lượng</label>
                       <input 
                         type="number"
                         min="1"
                         value={quantity}
                         onChange={e => setQuantity(Number(e.target.value))}
                         className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-2 text-center text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                       />
                    </div>
                    <div className="flex items-end">
                       <button 
                         type="button"
                         onClick={addItem}
                         className="w-full md:w-auto px-6 py-3.5 bg-primary text-slate-900 rounded-2xl font-black text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 active:scale-95"
                       >
                          Thêm
                       </button>
                    </div>
                 </div>
              </div>

              {/* Items Table */}
              <div className="p-0">
                 {data.order_items.length > 0 ? (
                   <div className="overflow-x-auto">
                      <table className="w-full text-left">
                         <thead className="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-100">
                            <tr>
                               <th className="px-8 py-4">Sản phẩm / Phân loại</th>
                               <th className="px-8 py-4 text-center">Đơn giĐ?</th>
                               <th className="px-8 py-4 text-center">Số lượng</th>
                               <th className="px-8 py-4 text-right">Thình tiĐn</th>
                               <th className="px-8 py-4"></th>
                            </tr>
                         </thead>
                         <tbody className="divide-y divide-slate-50">
                            {data.order_items.map((item) => (
                              <tr key={item.id_bienthe} className="hover:bg-slate-50/30 transition-colors group">
                                 <td className="px-8 py-5">
                                    <div className="flex flex-col">
                                       <span className="font-bold text-slate-900 line-clamp-1">{item.tensp}</span>
                                       <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5 italic">{item.variant_name}</span>
                                    </div>
                                 </td>
                                 <td className="px-8 py-5 text-center font-bold text-slate-600">
                                    {new Intl.NumberFormat('vi-VN').format(item.gia)} đ
                                 </td>
                                 <td className="px-8 py-5 text-center">
                                    <span className="px-3 py-1 bg-slate-100 rounded-lg text-xs font-black text-slate-600">x{item.soluong}</span>
                                 </td>
                                 <td className="px-8 py-5 text-right font-black text-primary">
                                    {new Intl.NumberFormat('vi-VN').format(item.gia * item.soluong)} đ
                                 </td>
                                 <td className="px-8 py-5 text-right">
                                    <button 
                                      type="button"
                                      onClick={() => removeItem(item.id_bienthe)}
                                      className="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all"
                                    >
                                       <Trash2 size={18} />
                                    </button>
                                 </td>
                              </tr>
                            ))}
                         </tbody>
                      </table>
                   </div>
                 ) : (
                   <div className="p-20 flex flex-col items-center justify-center text-slate-300">
                      <ShoppingCart size={48} className="mb-4 opacity-20" />
                      <p className="font-black uppercase tracking-widest text-xs">Chưa cĐ? sản phẩm nào trong đơn</p>
                   </div>
                 )}
              </div>
           </div>
        </div>

        {/* Sidebar Summary */}
        <div className="space-y-8">
           {/* Summary Tool */}
           <div className="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm text-dark sticky top-8">
              <h3 className="font-black text-slate-800 mb-8 flex items-center gap-2 uppercase tracking-tight">
                 <Calculator size={20} className="text-primary" />
                 Tổng kết hóa đơn
              </h3>
              
              <div className="space-y-6">
                 <div className="space-y-2">
                    <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Loại vận chuyển</label>
                    <div className="grid grid-cols-2 gap-2">
                       <button
                         type="button"
                         onClick={() => setData('vanchuyen', 'fast')}
                         className={cn(
                           "p-3 rounded-2xl border text-[10px] font-black uppercase tracking-widest transition-all",
                           data.vanchuyen === 'fast' ? "bg-primary border-primary text-slate-900 shadow-lg shadow-primary/20" : "bg-slate-50 border-slate-100 text-slate-400"
                         )}
                       >
                         Giao nhanh
                       </button>
                       <button
                         type="button"
                         onClick={() => setData('vanchuyen', 'superFast')}
                         className={cn(
                           "p-3 rounded-2xl border text-[10px] font-black uppercase tracking-widest transition-all",
                           data.vanchuyen === 'superFast' ? "bg-amber-500 border-amber-500 text-slate-900 shadow-lg shadow-amber-200" : "bg-slate-50 border-slate-100 text-slate-400"
                         )}
                       >
                         HĐa tốc
                       </button>
                    </div>
                 </div>

                 <div className="space-y-2">
                    <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">MĐ? giảm giĐ?</label>
                    <select 
                      value={data.id_giamgia}
                      onChange={e => setData('id_giamgia', e.target.value)}
                      className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all appearance-none"
                    >
                       <option value="">-- Không sử dụng --</option>
                       {vouchers.map(v => (
                         <option key={v.id} value={v.id} disabled={subtotal < v.sotientoithieu}>
                            {v.tenphieu} (Giảm {new Intl.NumberFormat('vi-VN').format(v.hesogiamgia)} đ)
                         </option>
                       ))}
                    </select>
                    {selectedVoucher && subtotal < selectedVoucher.sotientoithieu && (
                      <p className="text-amber-600 text-[9px] font-bold mt-1 uppercase italic">* Đơn chưa đạt tối thiểu {new Intl.NumberFormat('vi-VN').format(selectedVoucher.sotientoithieu)} đ</p>
                    )}
                 </div>

                 <div className="pt-6 border-t border-slate-100 space-y-4">
                    <div className="flex justify-between items-center text-xs font-bold text-slate-500">
                       <span>Tạm tiềnh</span>
                       <span>{new Intl.NumberFormat('vi-VN').format(subtotal)} đ</span>
                    </div>
                    <div className="flex justify-between items-center text-xs font-bold text-slate-500">
                       <span>Vận chuyển</span>
                       <span>{new Intl.NumberFormat('vi-VN').format(shippingFee)} đ</span>
                    </div>
                    <div className="flex justify-between items-center text-xs font-bold text-rose-500">
                       <span>Giảm giĐ?</span>
                       <span>-{new Intl.NumberFormat('vi-VN').format(calculatedDiscount)} đ</span>
                    </div>
                    <div className="pt-4 mt-2 border-t-2 border-dashed border-slate-100 flex justify-between items-center">
                       <span className="text-sm font-black text-slate-900 uppercase tracking-widest">Tổng tiĐn</span>
                       <span className="text-2xl font-black text-slate-900">{new Intl.NumberFormat('vi-VN').format(total)} đ</span>
                    </div>
                 </div>

                 <div className="space-y-4 pt-8">
                    <div className="flex items-center gap-2 p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                       <input 
                         type="checkbox" 
                         required 
                         id="confirm"
                         className="w-5 h-5 rounded-lg border-blue-200 text-blue-500 focus:ring-blue-500"
                       />
                       <label htmlFor="confirm" className="text-[10px] font-black text-blue-700 uppercase tracking-widest cursor-pointer select-none">
                          Xác nhận thàng tin chình xác
                       </label>
                    </div>

                    <button
                      type="submit"
                      disabled={processing || data.order_items.length === 0}
                      className="w-full flex items-center justify-center gap-3 px-8 py-5 bg-primary text-slate-900 rounded-[24px] font-black text-sm hover:bg-primary/95 transition-all shadow-xl shadow-primary/30 active:scale-95 disabled:opacity-50 disabled:grayscale"
                    >
                      <ShoppingCart size={20} />
                      {processing ? 'Đang tạo đơn...' : 'HOĐ?N TẤT TẠO ĐƠN'}
                    </button>
                    
                    <textarea 
                      placeholder="Ghi chĐ? đơn hàng (nếu cĐ?)..."
                      rows={3}
                      value={data.ghichu}
                      onChange={e => setData('ghichu', e.target.value)}
                      className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none mt-4 italic"
                    />
                 </div>
              </div>
           </div>
        </div>
      </form>
    </AdminLayout>
  );
}
