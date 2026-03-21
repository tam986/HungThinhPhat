import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';
import { 
  Package, 
  ShoppingCart,
  AlertCircle,
  DollarSign,
  TrendingUp,
  TrendingDown,
  Users,
  ChevronRight,
  ArrowRight
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface Order {
  id: number;
  tennguoinhan: string;
  phone: string;
  thanhtien: number;
  trangthai: string;
  created_at: string;
}

interface Variant {
  id: number;
  soluong: number;
  sanpham?: { tensp: string };
  loaibanh?: { tenLoaiBanh: string };
  khoiluong?: { khoiluong: string };
  nhanbanh?: { tenNhanBanh: string };
}

interface TopSeller {
  id_bienthe: number;
  total_sold: number;
  bienthe?: {
    sanpham?: { tensp: string };
    loaibanh?: { tenLoaiBanh: string };
  };
}

interface TopSpender {
  id_user: number;
  total_spent: number;
  user: {
    hoten: string;
    email: string;
    sodienthoai: string;
  };
}

interface Props {
  metrics: {
    revenueThisMonth: number;
    revenuePercent: number;
    newOrders24h: number;
    pendingOrders: number;
    totalProducts: number;
  };
  actionables: {
    latestOrders: Order[];
    lowStockVariants: Variant[];
  };
  overview: {
    topSellers: TopSeller[];
    topSpenders: TopSpender[];
  };
}

export default function Dashboard({ metrics, actionables, overview }: Props) {
  const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
  };

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('vi-VN', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  return (
    <AdminLayout>
      <Head title="Bảng Điều Khiển" />

      <div className="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500 pb-12">
        <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 font-display">Bảng điều khiển hệ thống</h1>
            <p className="text-slate-500 text-sm mt-1 font-medium italic">Hung Thinh Food - Phân tích dữ liệu thực chiến</p>
          </div>
          <div className="flex items-center gap-2">
            <span className="flex h-2 w-2 rounded-full bg-green-500 animate-pulse" />
            <span className="text-xs font-semibold text-slate-500 uppercase tracking-wider">Hệ thống trực tuyến</span>
          </div>
        </div>

        {/* Section 1: Key Metrics */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <MetricCard 
            title="Doanh thu tháng này" 
            value={formatCurrency(metrics.revenueThisMonth)} 
            icon={DollarSign} 
            variant="success"
            trend={{
              value: Math.abs(metrics.revenuePercent),
              isUp: metrics.revenuePercent >= 0
            }}
          />
          <MetricCard 
            title="Đơn hàng mới (24h)" 
            value={metrics.newOrders24h} 
            icon={ShoppingCart} 
            variant="primary"
          />
          <MetricCard 
            title="Đơn chờ xử lý" 
            value={metrics.pendingOrders} 
            icon={AlertCircle} 
            variant={metrics.pendingOrders > 0 ? "warning" : "primary"}
          />
          <MetricCard 
            title="Tổng sản phẩm" 
            value={metrics.totalProducts} 
            icon={Package} 
            variant="pink"
          />
        </div>

        {/* Section 2: Actionables */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Latest Orders Table */}
          <div className="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div className="p-6 border-b border-slate-100 flex items-center justify-between">
              <h2 className="text-lg font-bold text-slate-900 tracking-tight">Đơn hàng mới nhất</h2>
              <Link href={route('donhang.index')} className="text-primary text-sm font-semibold hover:underline flex items-center gap-1">
                Xem tất cả <ChevronRight size={16} />
              </Link>
            </div>
            <div className="overflow-x-auto">
              <table className="w-full text-left">
                <thead>
                  <tr className="bg-slate-50/50">
                    <th className="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Mã đơn</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Khách hàng</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng tiền</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-100">
                  {actionables.latestOrders.length > 0 ? (
                    actionables.latestOrders.map((order) => (
                      <tr key={order.id} className="hover:bg-slate-50/50 transition-colors">
                        <td className="px-6 py-4">
                          <span className="text-sm font-bold text-slate-900">#{order.id}</span>
                          <p className="text-[10px] text-slate-400 font-medium">{formatDate(order.created_at)}</p>
                        </td>
                        <td className="px-6 py-4">
                          <p className="text-sm font-semibold text-slate-700">{order.tennguoinhan}</p>
                          <p className="text-xs text-slate-400">{order.phone}</p>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-sm font-bold text-slate-900">{formatCurrency(order.thanhtien)}</span>
                        </td>
                        <td className="px-6 py-4 text-right">
                          <StatusBadge status={order.trangthai} />
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan={4} className="px-6 py-12 text-center text-slate-400 text-sm">Chưa có đơn hàng nào</td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>

          {/* Low Stock Sidebar */}
          <div className="bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col">
            <div className="p-6 border-b border-slate-100">
              <h2 className="text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <AlertCircle className="text-amber-500" size={20} />
                Sắp hết hàng
              </h2>
            </div>
            <div className="p-6 space-y-4 flex-1">
              {actionables.lowStockVariants.length > 0 ? (
                actionables.lowStockVariants.map((item) => (
                  <div key={item.id} className="flex items-center justify-between p-3 rounded-2xl bg-amber-50/50 border border-amber-100 underline-offset-4 decoration-amber-200">
                    <div className="min-w-0 flex-1 mr-3">
                      <p className="text-sm font-bold text-slate-800 truncate">
                        {item.sanpham?.tensp}
                      </p>
                      <p className="text-[11px] text-amber-600 font-medium truncate">
                        {item.loaibanh?.tenLoaiBanh} - {item.khoiluong?.khoiluong}
                      </p>
                    </div>
                    <div className="text-right shrink-0">
                      <span className="text-xs font-bold px-2 py-1 bg-white rounded-lg border border-amber-200 text-amber-700">
                        {item.soluong} còn lại
                      </span>
                    </div>
                  </div>
                ))
              ) : (
                <div className="h-full flex flex-col items-center justify-center p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                   <Package className="text-slate-300 mb-2" size={32} />
                   <p className="text-sm text-slate-400 font-medium">Kho hàng dồi dào</p>
                </div>
              )}
            </div>
            <div className="p-4 border-t border-slate-100 bg-slate-50/50 rounded-b-3xl">
               <Link href={route('sanpham.index')} className="w-full flex items-center justify-center gap-2 py-2 text-xs font-bold text-slate-600 hover:text-primary transition-colors">
                  Kiểm tra toàn bộ kho <ArrowRight size={14} />
               </Link>
            </div>
          </div>
        </div>

        {/* Section 3: Overview & Insights */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {/* Top Sellers */}
            <div className="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 overflow-hidden">
                <div className="flex items-center justify-between mb-6">
                    <h2 className="text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <TrendingUp className="text-green-500" size={20} />
                        Top 5 Bán chạy nhất
                    </h2>
                </div>
                <div className="space-y-4">
                    {overview.topSellers.map((item, index) => (
                        <div key={item.id_bienthe} className="flex items-center gap-4 group">
                            <div className={cn(
                                "w-10 h-10 rounded-xl flex items-center justify-center font-bold shrink-0",
                                index === 0 ? "bg-amber-100 text-amber-600" : "bg-slate-100 text-slate-400"
                            )}>
                                {index + 1}
                            </div>
                            <div className="flex-1 min-w-0">
                                <p className="text-sm font-bold text-slate-800 truncate group-hover:text-primary transition-colors">
                                    {item.bienthe?.sanpham?.tensp}
                                </p>
                                <p className="text-xs text-slate-400">{item.bienthe?.loaibanh?.tenLoaiBanh}</p>
                            </div>
                            <div className="text-right">
                                <p className="text-sm font-bold text-slate-900">{item.total_sold}</p>
                                <p className="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Đã bán</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

           
        </div>

        {/* Optional Stats Chart Area */}
        <div className="h-[300px] w-full bg-slate-50 rounded-[40px] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center p-8">
            <TrendingUp size={48} className="text-slate-200 mb-3" />
            <h3 className="text-lg font-bold text-slate-400 italic">Vùng phân tích xu hướng thị trường</h3>
            <p className="text-xs text-slate-400 max-w-sm mt-1">Dữ liệu biểu đồ đang được tổng hợp dựa trên chu kỳ kinh doanh của Hùng Thịnh Food.</p>
        </div>
      </div>
    </AdminLayout>
  );
}
