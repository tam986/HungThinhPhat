import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Ticket, 
  Plus, 
  Search, 
  Trash2, 
  Edit, 
  Clock, 
  Coins, 
  Users,
  AlertCircle,
  CheckCircle2,
  Calendar,
  MoreVertical,
  ChevronLeft,
  ChevronRight,
  Zap
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface Coupon {
  id: number;
  magiamgia: string;
  hesogiamgia: number;
  sotientoithieu: number;
  soluong: number;
  thoidiembatdau: string;
  thoidiemketthuc: string;
  trangthai: number;
}

interface Props {
  coupons: {
    data: Coupon[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
}

export default function CouponIndex({ coupons }: Props) {
  const [search, setSearch] = useState('');

  const getStatus = (coupon: Coupon) => {
    const now = new Date();
    const start = new Date(coupon.thoidiembatdau);
    const end = new Date(coupon.thoidiemketthuc);

    if (now < start) return { label: 'Chưa diễn ra', variant: 'Chưa diễn ra' as const };
    if (now > end || coupon.soluong === 0) return { label: 'Kết thúc', variant: 'Kết thúc' as const };
    return { label: 'Đang diễn ra', variant: 'Đang diễn ra' as const };
  };

  return (
    <AdminLayout>
      <Head title="Quản lý mã giảm giá" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark font-display">Mã giảm giá & Khuyến mãi</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Tạo các chiến dịch giảm giá để thu hút khách hàng.
          </p>
        </div>
        <Link 
          href={route('magiamgia.create')}
          className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <Plus size={18} />
          Tạo mã mới
        </Link>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <MetricCard title="Tổng mã đã tạo" value={coupons.total} icon={Ticket} variant="primary" />
        <MetricCard title="Mã đang diễn ra" value={coupons.data.filter(c => getStatus(c).label === 'Đang diễn ra').length} icon={Zap} variant="success" />
        <MetricCard title="Sắp diễn ra" value={coupons.data.filter(c => getStatus(c).label === 'Chưa diễn ra').length} icon={Clock} variant="warning" />
        <MetricCard title="Đã kết thúc" value={coupons.data.filter(c => getStatus(c).label === 'Kết thúc').length} icon={AlertCircle} variant="danger" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/10">
          <div className="text-xs font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
             <AlertCircle size={16} className="text-primary" />
             Lưu ý: Hệ thống tự động ẩn mã khi hết hạn hoặc hết số lượng.
          </div>
          <div className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm theo mã..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-2xl py-2.5 px-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
            />
            <Search size={18} className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400" />
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Thông tin mã</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Giá trị</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Số lượng</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Thời gian</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Trạng thái</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Hành Động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {coupons.data.map((coupon) => {
                const status = getStatus(coupon);
                return (
                  <tr key={coupon.id} className="hover:bg-slate-50/80 transition-all group">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-black shadow-inner">
                           {coupon.magiamgia.substring(0, 2).toUpperCase()}
                        </div>
                        <div className="flex flex-col">
                           <span className="font-black text-slate-900 tracking-tighter text-base">{coupon.magiamgia}</span>
                           <span className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">MIN: {new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(coupon.sotientoithieu)}</span>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4 text-center">
                       <span className="font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">-{coupon.hesogiamgia}%</span>
                    </td>
                    <td className="px-6 py-4 text-center">
                       <span className={cn(
                        "font-bold",
                        coupon.soluong > 0 ? "text-slate-700" : "text-red-400"
                       )}>
                        {coupon.soluong}
                       </span>
                    </td>
                    <td className="px-6 py-4">
                       <div className="flex flex-col items-center gap-1">
                          <div className="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                             <Calendar size={10} /> {new Date(coupon.thoidiembatdau).toLocaleDateString('vi-VN')}
                          </div>
                          <div className="w-0.5 h-2 bg-slate-200"></div>
                          <div className="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                             <Clock size={10} /> {new Date(coupon.thoidiemketthuc).toLocaleDateString('vi-VN')}
                          </div>
                       </div>
                    </td>
                    <td className="px-6 py-4 text-center">
                       <StatusBadge 
                        status={status.variant} 
                        labels={{ active: 'Đang chạy', warning: 'Sắp diễn ra', inactive: 'Đã kết thúc' }} 
                       />
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-all">
                        <Link 
                          href={route('magiamgia.edit', coupon.id)}
                          className="p-2 text-slate-400 hover:text-amber-500 hover:bg-slate-100 rounded-xl transition-all"
                        >
                          <Edit size={18} />
                        </Link>
                        <Link 
                          href={route('magiamgia.destroy', coupon.id)}
                          method="delete"
                          as="button"
                          onBefore={() => confirm('Xác nhận xóa mã giảm giá này?')}
                          className="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-100 rounded-xl transition-all"
                        >
                          <Trash2 size={18} />
                        </Link>
                      </div>
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold uppercase tracking-widest">
            {coupons.total} CHƯƠNG TRÌNH KHUYẾN MÃI
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={coupons.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !coupons.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <div className="px-4 text-sm font-bold text-slate-700">
              {coupons.current_page}
            </div>
            <Link 
              href={coupons.next_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !coupons.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronRight size={20} />
            </Link>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
