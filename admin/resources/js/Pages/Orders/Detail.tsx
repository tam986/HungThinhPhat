import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Package, 
  Truck, 
  CheckCircle2, 
  XCircle, 
  Clock, 
  CreditCard, 
  User, 
  MapPin, 
  Phone, 
  Mail,
  Printer,
  Calendar,
  AlertCircle
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface OrderItem {
  id: number;
  id_bienthe: number;
  soluong: number;
  gia: number;
  bienthe: {
    id: number;
    gia: number;
    giakm: number | null;
    khoiluong: { id: number; khoiluong: string };
    nhanbanh: { id: number; tenNhanBanh: string };
    sanpham: { id: number; tensp: string };
  };
}

interface Order {
  id: number;
  id_user: number;
  tennguoinhan: string;
  phone: string;
  email: string;
  diachi: string;
  ghichu: string | null;
  thanhtoan: string;
  vanchuyen: string;
  trangthai: string;
  tienvc: number;
  tongtien: number;
  sotiengiam: number;
  thanhtien: number;
  created_at: string;
  user: { id: number; hoten: string; email: string };
  thanh_toan: { id: number; trangthai: string; phuongthucthanhtoan: string; sotienthanhtoan: number };
  donhangchitiet: OrderItem[];
}

interface Props {
  order: Order;
}

export default function OrderDetail({ order }: Props) {
  const statusColors: Record<string, string> = {
    'chờ xác nhận': 'bg-amber-100 text-amber-600 border-amber-200',
    'đã xác nhận': 'bg-blue-100 text-blue-600 border-blue-200',
    'đang giao': 'bg-indigo-100 text-indigo-600 border-indigo-200',
    'hoàn thành': 'bg-emerald-100 text-emerald-600 border-emerald-200',
    'đã hủy': 'bg-red-100 text-red-600 border-red-200',
    'hủy': 'bg-red-100 text-red-600 border-red-200',
  };

  const statusIcons: Record<string, any> = {
    'chờ xác nhận': Clock,
    'đã xác nhận': CheckCircle2,
    'đang giao': Truck,
    'hoàn thành': CheckCircle2,
    'đã hủy': XCircle,
    'hủy': XCircle,
  };

  const updateStatus = (newStatus: string) => {
    if (confirm(`Xác nhận thay đổi trạng thái sang: ${newStatus}?`)) {
      router.put(route('donhang.updateStatus', order.id), { trangthai: newStatus });
    }
  };

  const updatePaymentStatus = (newStatus: string) => {
    if (!order.thanh_toan) {
        alert("Thông tin thanh toán không tồn tại.");
        return;
    }
    if (confirm(`Xác nhận cập nhật trạng thái thanh toán sang: ${newStatus}?`)) {
      router.put(route('donhang.updateTT', order.thanh_toan.id), { trangthai: newStatus });
    }
  };

  const StatusIcon = statusIcons[order.trangthai] || AlertCircle;

  return (
    <AdminLayout>
      <Head title={`Chi tiết Đãn hàng #${order.id}`} />

      {/* Header */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div className="flex items-center gap-4">
          <Link 
            href={route('donhang.index')} 
            className="p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-400 hover:text-primary hover:border-primary/30 transition-all shadow-sm group"
          >
            <ArrowLeft size={20} className="group-hover:-translate-x-1 transition-transform" />
          </Link>
          <div>
            <div className="flex items-center gap-3">
               <h1 className="text-2xl font-black tracking-tight text-slate-900 text-dark">Đơn hàng #{order.id}</h1>
               <span className={cn(
                 "px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border",
                 statusColors[order.trangthai]
               )}>
                 {order.trangthai}
               </span>
            </div>
            <div className="flex items-center gap-2 mt-1 text-slate-400 text-xs font-bold">
               <Calendar size={14} />
               Ngày Đặt: {new Date(order.created_at).toLocaleString('vi-VN')}
            </div>
          </div>
        </div>
        <div className="flex items-center gap-2">
           <button className="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
              <Printer size={18} />
              In hóa đơn
           </button>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {/* Left Column: Order Info & Items */}
        <div className="lg:col-span-2 space-y-8">
           {/* Order Items */}
           <div className="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden text-dark">
              <div className="p-6 border-b border-slate-100 flex items-center justify-between">
                 <div className="flex items-center gap-3">
                    <div className="p-2 bg-indigo-50 text-indigo-500 rounded-xl">
                       <Package size={20} />
                    </div>
                    <h3 className="font-bold text-slate-800">Sản phẩm trong đơn hàng</h3>
                 </div>
                 <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1 rounded-full">
                    {order.donhangchitiet.length} Sản phẩm
                 </span>
              </div>
              <div className="divide-y divide-slate-50">
                 {order.donhangchitiet.map((item) => (
                   <div key={item.id} className="p-6 flex items-center gap-6 group">
                      <div className="w-16 h-16 bg-slate-50 rounded-2xl flex-shrink-0 flex items-center justify-center text-slate-300 border border-slate-100 group-hover:border-primary/20 transition-all">
                         <Package size={32} />
                      </div>
                      <div className="flex-1">
                         <h4 className="font-bold text-slate-900 line-clamp-1 group-hover:text-primary transition-colors">{item.bienthe.sanpham.tensp}</h4>
                         <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">
                            Khối lượng: {item.bienthe.khoiluong.khoiluong} • Nhân: {item.bienthe.nhanbanh.tenNhanBanh}
                         </p>
                      </div>
                      <div className="text-right">
                         <p className="font-bold text-slate-900">{new Intl.NumberFormat('vi-VN').format(item.gia)} đ</p>
                         <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Số lượng: x{item.soluong}</p>
                      </div>
                   </div>
                 ))}
              </div>
              {/* Summary Footer */}
              <div className="p-8 bg-slate-50/50 border-t border-slate-100 space-y-4">
                  <div className="flex justify-between items-center text-sm font-bold text-slate-500">
                    <span>Tạm tính</span>
                    <span>{new Intl.NumberFormat('vi-VN').format(order.tongtien)} đ</span>
                 </div>
                 <div className="flex justify-between items-center text-sm font-bold text-slate-500">
                    <span>Phí vận chuyển</span>
                    <span>{new Intl.NumberFormat('vi-VN').format(order.tienvc)} đ</span>
                 </div>
                 <div className="flex justify-between items-center text-sm font-bold text-rose-500">
                    <span>Giảm giá</span>
                    <span>-{new Intl.NumberFormat('vi-VN').format(order.sotiengiam)} đ</span>
                 </div>
                 <div className="pt-4 border-t border-slate-200 flex justify-between items-center">
                    <span className="text-base font-black text-slate-900 uppercase tracking-widest">Tổng cộng</span>
                    <span className="text-2xl font-black text-slate-900">{new Intl.NumberFormat('vi-VN').format(order.thanhtien)} đ</span>
                 </div>
              </div>
           </div>

           {/* Order Timeline / Actions */}
           <div className="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm text-dark">
              <h3 className="font-bold text-slate-800 mb-6 flex items-center gap-2">
                 <Clock size={20} className="text-slate-400" />
                 Thay đổi trạng thái đơn hàng
              </h3>
              <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                 {['chờ xác nhận', 'đã xác nhận', 'đang giao', 'hoàn thành', 'đã hủy'].map((status) => (
                   <button
                     key={status}
                     onClick={() => updateStatus(status)}
                     className={cn(
                       "flex flex-col items-center justify-center p-4 rounded-2xl border transition-all gap-2 group",
                       order.trangthai === status
                         ? "bg-primary border-primary text-slate-900 shadow-lg shadow-primary/20"
                         : "bg-white border-slate-100 text-slate-500 hover:border-primary/30 hover:bg-slate-50"
                     )}
                   >
                     <p className="text-[9px] font-black uppercase tracking-widest text-center">{status}</p>
                   </button>
                 ))}
              </div>
           </div>
        </div>

        {/* Right Column: Customer & Payment */}
        <div className="space-y-8">
           {/* Customer Information */}
           <div className="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm text-dark relative overflow-hidden">
              <div className="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12" />
              <h3 className="font-bold text-slate-800 mb-6 flex items-center gap-2">
                 <User size={20} className="text-primary" />
                 Thông tin khách hàng
              </h3>
              <div className="space-y-6">
                 <div className="flex items-center gap-4">
                    <div className="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                       <User size={24} />
                    </div>
                    <div>
                       <p className="font-black text-slate-900 text-sm italic">{order.tennguoinhan}</p>
                       <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">{order.user?.hoten || 'Khách vãng lai'}</p>
                    </div>
                 </div>
                 <div className="space-y-4 pt-4 border-t border-slate-50">
                    <div className="flex items-start gap-4">
                       <MapPin className="text-slate-300 mt-1" size={18} />
                       <p className="text-xs font-bold text-slate-600 leading-relaxed">{order.diachi}</p>
                    </div>
                    <div className="flex items-center gap-4 text-slate-600">
                       <Phone className="text-slate-300" size={18} />
                       <p className="text-xs font-bold italic">{order.phone}</p>
                    </div>
                    <div className="flex items-center gap-4 text-slate-600">
                       <Mail className="text-slate-300" size={18} />
                       <p className="text-xs font-bold italic">{order.email}</p>
                    </div>
                 </div>
              </div>
           </div>

           {/* Payment & Shipping */}
           <div className="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm text-dark">
              <h3 className="font-bold text-slate-800 mb-6 flex items-center gap-2">
                 <CreditCard size={20} className="text-emerald-500" />
                 Thanh toán & Vận chuyển
              </h3>
              <div className="space-y-6">
                 <div>
                    <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phương thức thanh toán</span>
                    <div className="flex items-center gap-3 mt-2 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                       <CreditCard size={18} className="text-slate-400" />
                       <span className="text-xs font-black text-slate-700 italic uppercase">{order.thanh_toan?.phuongthucthanhtoan || order.thanhtoan}</span>
                    </div>
                 </div>
                  <div>
                     <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Trạng thái thanh toán</span>
                     <div className={cn(
                       "flex items-center justify-between gap-3 mt-2 p-3 rounded-2xl border font-black text-[10px] uppercase tracking-widest",
                       order.thanh_toan?.trangthai === 'đã thanh toán'
                         ? "bg-emerald-50 text-emerald-600 border-emerald-100"
                         : "bg-red-50 text-red-600 border-red-100"
                     )}>
                       <div className="flex items-center gap-2">
                            {order.thanh_toan?.trangthai === 'đã thanh toán' ? <CheckCircle2 size={16} /> : <AlertCircle size={16} />}
                            {order.thanh_toan?.trangthai || 'Chưa thanh toán'}
                       </div>

                       {order.thanh_toan?.trangthai !== 'đã thanh toán' && (
                           <button
                             onClick={() => updatePaymentStatus('đã thanh toán')}
                             className="px-3 py-1 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors"
                           >
                               Xác nhận
                           </button>
                       )}
                     </div>
                  </div>
                 <div className="pt-4 border-t border-slate-50">
                    <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Vận chuyển</span>
                    <div className="flex items-center gap-3 mt-2 p-3 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                       <Truck size={18} className="text-indigo-400" />
                       <div className="flex flex-col">
                          <span className="text-xs font-black text-indigo-700 italic uppercase">{order.vanchuyen === 'superFast' ? 'Giao hàng hỏa tốc' : 'Giao hàng nhanh'}</span>
                          <span className="text-[9px] font-bold text-indigo-400 tracking-wider">Dự kiến trong 2-3 ngày làm việc</span>
                       </div>
                    </div>
                 </div>
              </div>
           </div>

           {/* Notes */}
           {order.ghichu && (
             <div className="bg-amber-50 rounded-[32px] border border-amber-200/50 p-6 shadow-sm text-dark">
                <div className="flex items-center gap-3 mb-4 text-amber-600">
                   <AlertCircle size={20} />
                   <h3 className="font-bold">Ghi chú từ khách</h3>
                </div>
                <p className="text-xs font-bold text-amber-700 italic leading-relaxed">
                   "{order.ghichu}"
                </p>
             </div>
           )}
        </div>
      </div>
    </AdminLayout>
  );
}
