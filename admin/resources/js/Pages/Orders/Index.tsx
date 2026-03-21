import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  ShoppingBag, 
  DollarSign, 
  Plus, 
  Download, 
  Filter,
  Eye,
  Edit,
  Trash2,
  ChevronRight,
  ChevronLeft,
  X,
  Search,
  Ticket
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface Order {
  id: number;
  user: { hoten: string };
  thanh_toan: { phuongthucthanhtoan: string };
  created_at: string;
  trangthai: string;
  thanhtien: number;
  total_quantity: string | number;
  id_giamgia: number | null;
}

interface Props {
  orders: {
    data: Order[];
    links: any[];
    current_page: number;
    last_page: number;
    total: number;
  };
  stats: {
    total_orders: number;
    total_revenue: number;
  };
  statuses: string[];
  filters: {
    trangthai: string;
    has_discount: string;
    search: string;
  };
}

export default function OrderIndex({ orders, stats, statuses, filters }: Props) {
  const [search, setSearch] = React.useState(filters.search || '');

  const handleFilter = (key: string, value: string | null) => {
    router.get(route('donhang.index'), {
      ...filters,
      [key]: value,
      search: search,
      page: 1 // Reset to page 1 on filter
    }, {
      preserveState: true,
      replace: true
    });
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    handleFilter('search', search);
  };

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
  };

  return (
    <AdminLayout>
      <Head title="Quản lý đơn hàng" />

      {/* Header Section */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900">Quản lý Đơn hàng</h1>
          <p className="text-slate-500 text-sm mt-1">
            Tổng cộng <span className="font-semibold text-slate-900">{orders.total}</span> Đơn hàng trong hệ thống.
          </p>
        </div>
        <div className="flex items-center gap-2">
          <button className="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
            <Download size={18} />
            Xuất Excel
          </button>
          <Link 
            href={route('donhang.create')}
            className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
          >
            <Plus size={18} />
            Đơn hàng mới
          </Link>
        </div>
      </div>

      {/* Metric Cards Row */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <MetricCard 
          title="Tổng Đơn hàng" 
          value={stats.total_orders} 
          icon={ShoppingBag} 
          variant="primary"
        />
        <MetricCard 
          title="Doanh thu (Thực nhận)" 
          value={formatCurrency(stats.total_revenue)} 
          icon={DollarSign} 
          variant="success"
        />
        {/* Placeholder cards to keep layout consistent or could remove to show only 2 */}
        <div className="lg:col-span-2 hidden lg:block" />
      </div>

      {/* Filter & Search Table Section */}
      <div className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-in fade-in zoom-in-95 duration-500 min-h-[500px]">
        <div className="p-4 border-b border-slate-100 bg-slate-50/50 space-y-4">
          <div className="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div className="flex flex-wrap items-center gap-2 w-full lg:w-auto">
              <div className="flex bg-white border border-slate-200 rounded-xl p-1 shadow-sm overflow-x-auto max-w-full">
                <button 
                  onClick={() => handleFilter('trangthai', null)}
                  className={cn(
                    "px-3 py-1.5 text-xs font-semibold rounded-lg shrink-0 transition-all",
                    !filters.trangthai ? "bg-primary text-slate-900" : "text-slate-500 hover:text-slate-900"
                  )}
                >
                  Tất cả
                </button>
                {statuses.map(status => (
                  <button 
                    key={status}
                    onClick={() => handleFilter('trangthai', status)}
                    className={cn(
                      "px-3 py-1.5 text-xs font-semibold rounded-lg shrink-0 transition-all capitalize",
                      filters.trangthai === status ? "bg-primary text-slate-900" : "text-slate-500 hover:text-slate-900"
                    )}
                  >
                    {status}
                  </button>
                ))}
              </div>

              {/* Discount Filter */}
              <div className="flex bg-white border border-slate-200 rounded-xl p-1 shadow-sm shrink-0">
                  <button 
                    onClick={() => handleFilter('has_discount', null)}
                    className={cn(
                      "px-3 py-1.5 text-xs font-semibold rounded-lg transition-all",
                      !filters.has_discount ? "bg-slate-100 text-slate-900" : "text-slate-500 hover:text-slate-900"
                    )}
                  >
                    Mọi đơn
                  </button>
                  <button 
                    onClick={() => handleFilter('has_discount', 'yes')}
                    className={cn(
                      "px-3 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-1 transition-all",
                      filters.has_discount === 'yes' ? "bg-amber-100 text-amber-700" : "text-slate-500 hover:text-slate-900"
                    )}
                  >
                    <Ticket size={12} /> Có KM
                  </button>
                  <button 
                    onClick={() => handleFilter('has_discount', 'no')}
                    className={cn(
                      "px-3 py-1.5 text-xs font-semibold rounded-lg transition-all",
                      filters.has_discount === 'no' ? "bg-slate-200 text-slate-900" : "text-slate-500 hover:text-slate-900"
                    )}
                  >
                    Không KM
                  </button>
              </div>
            </div>

            <form onSubmit={handleSearch} className="relative w-full lg:w-80">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4" />
              <input 
                type="text" 
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder="Tìm ID, Tên, Số điện thoại..." 
                className="w-full bg-white border border-slate-200 rounded-xl py-2 pl-10 pr-10 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none"
              />
              {search && (
                <button 
                  type="button"
                  onClick={() => { setSearch(''); handleFilter('search', null); }}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                >
                  <X size={16} />
                </button>
              )}
            </form>
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider">Mã Đơn</th>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider">Khách hàng</th>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider">Ngày Đặt</th>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider text-center">Số lượng</th>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider text-center">Trạng thái</th>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider text-right">Tổng tiền</th>
                <th className="px-6 py-4 font-bold text-slate-600 uppercase text-[11px] tracking-wider text-center">Hành Động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {orders.data.map((order) => (
                <tr key={order.id} className="hover:bg-slate-50/80 transition-colors group">
                  <td className="px-6 py-4">
                    <div className="font-mono font-bold text-primary bg-primary/5 px-2 py-1 rounded inline-block">
                        #{order.id}
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="font-bold text-slate-900">{order.user?.hoten || 'Khách vãng lai'}</div>
                    <div className="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1.5 uppercase font-medium">
                        {order.thanh_toan?.phuongthucthanhtoan} 
                        {order.id_giamgia && <span className="text-amber-600 flex items-center gap-0.5"><Ticket size={10} /> Đã áp mã</span>}
                    </div>
                  </td>
                  <td className="px-6 py-4 text-slate-500 font-medium">
                    {new Date(order.created_at).toLocaleDateString('vi-VN')}
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-lg text-xs">
                        {order.total_quantity || 0} món
                    </span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <select 
                      value={order.trangthai}
                      onChange={(e) => {
                        if (confirm(`Xác nhận đổi trạng thái đơn hàng sang: ${e.target.value}?`)) {
                          router.put(route('donhang.updateStatus', order.id), { trangthai: e.target.value });
                        }
                      }}
                      className={cn(
                        "text-[10px] font-bold uppercase tracking-wider rounded-full border px-2 py-1 outline-none cursor-pointer transition-all",
                        order.trangthai === 'chờ xác nhận' && "bg-yellow-50 text-yellow-700 border-yellow-100",
                        order.trangthai === 'đã xác nhận' && "bg-blue-50 text-blue-700 border-blue-100",
                        order.trangthai === 'đang giao' && "bg-indigo-50 text-indigo-700 border-indigo-100",
                        order.trangthai === 'hoàn thành' && "bg-green-50 text-green-700 border-green-100",
                        (order.trangthai === 'hủy' || order.trangthai === 'đã hủy') && "bg-red-50 text-red-700 border-red-100"
                      )}
                    >
                      {statuses.map(status => (
                        <option key={status} value={status} className="bg-white text-slate-900 border-none capitalize">
                          {status}
                        </option>
                      ))}
                      <option value="đã hủy" className="bg-white text-slate-900 border-none">Đã hủy</option>
                    </select>
                  </td>
                  <td className="px-6 py-4 text-right font-bold text-slate-900">
                    {formatCurrency(order.thanhtien)}
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                      <Link href={route('donhang.show', order.id)} className="p-2 text-slate-400 hover:text-primary transition-colors hover:bg-white rounded-lg border border-transparent hover:border-slate-100 shadow-sm">
                        <Eye size={18} />
                      </Link>
                      <Link href={route('donhang.edit', order.id)} className="p-2 text-slate-400 hover:text-amber-600 transition-colors hover:bg-white rounded-lg border border-transparent hover:border-slate-100 shadow-sm">
                        <Edit size={18} />
                      </Link>
                      <button className="p-2 text-slate-400 hover:text-red-600 transition-colors hover:bg-white rounded-lg border border-transparent hover:border-slate-100 shadow-sm">
                        <Trash2 size={18} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
              {orders.data.length === 0 && (
                <tr>
                  <td colSpan={7} className="px-6 py-20 text-center text-slate-500 italic">
                    Không tìm thấy đơn hàng nào phù hợp với bộ lọc.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        {/* Pagination Section */}
        <div className="px-6 py-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-medium">
            Hiển thị <span className="text-slate-900 font-bold">{orders.data.length}</span> đơn hàng (Trang {orders.current_page} / {orders.last_page})
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={orders.links[0].url || '#'} 
              className={cn(
                "p-2 border border-slate-200 rounded-xl hover:bg-white text-slate-600 transition-all",
                !orders.links[0].url && "opacity-50 pointer-events-none"
              )}
            >
               <ChevronLeft size={18} />
            </Link>
            <Link 
              href={orders.links[orders.links.length - 1].url || '#'} 
              className={cn(
                "p-2 border border-slate-200 rounded-xl hover:bg-white text-slate-600 transition-all",
                !orders.links[orders.links.length - 1].url && "opacity-50 pointer-events-none"
              )}
            >
               <ChevronRight size={18} />
            </Link>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
