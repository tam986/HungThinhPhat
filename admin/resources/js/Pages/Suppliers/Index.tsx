import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Truck, 
  Plus, 
  Search, 
  MoreVertical, 
  Edit, 
  Trash2, 
  Eye,
  EyeOff,
  ChevronLeft,
  ChevronRight,
  Package,
  History,
  Image as ImageIcon
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface Supplier {
  id: number;
  tennhacungcap: string;
  thutu: number;
  anhien: number;
  hinhanh: string | null;
  hinhanh_url: string | null;
  sanpham_count: number;
}

interface Props {
  nhacungcaps: {
    data: Supplier[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
  filters: {
    search?: string;
    sort?: string;
    anhien?: string;
  };
}

export default function SupplierIndex({ nhacungcaps, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('nhacungcap.index'), { ...filters, search }, { preserveState: true });
  };

  const handleFilterChange = (name: string, value: string) => {
    router.get(route('nhacungcap.index'), { ...filters, [name]: value }, { preserveState: true });
  };

  return (
    <AdminLayout>
      <Head title="Quản lý nhà cung cấp" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Nhà cung cấp</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Quản lý các Đại lý về Đơn vị cung ứng hàng hóa.
          </p>
        </div>
        <Link 
          href={route('nhacungcap.create')}
          className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <Plus size={18} />
          Thêm nhà cung cấp
        </Link>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <MetricCard title="Tổng nhà cung cấp" value={nhacungcaps.total} icon={Truck} variant="primary" />
        <MetricCard title="Đang hợp tác" value={nhacungcaps.data.filter(d => d.anhien === 1).length} icon={Eye} variant="success" />
        <MetricCard title="Tổng sản phẩm" value={nhacungcaps.data.reduce((acc, curr) => acc + curr.sanpham_count, 0)} icon={Package} variant="warning" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/10">
          <div className="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.anhien || ''}
              onChange={(e) => handleFilterChange('anhien', e.target.value)}
            >
              <option value="">Trạng thái</option>
              <option value="1">Đang hợp tác</option>
              <option value="0">Đang ẩn</option>
            </select>

            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.sort || ''}
              onChange={(e) => handleFilterChange('sort', e.target.value)}
            >
              <option value="">Sắp xếp</option>
              <option value="latest">Mới nhất</option>
              <option value="thutu-asc">Thứ tự tăng dần</option>
              <option value="thutu-desc">Thứ tự giảm dần</option>
            </select>
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm tên Đại lý..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-2xl py-2.5 px-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
            />
            <Search size={18} className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400" />
          </form>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center w-16">#STT</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Đại lý</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Sản phẩm</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Trạng thái</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Hành động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {nhacungcaps.data.map((ncc) => (
                <tr key={ncc.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-4 text-center">
                    <span className="font-mono font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded text-xs">{ncc.thutu}</span>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                       <div className="w-12 h-12 rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200 shadow-inner group-hover:border-primary/20 transition-all">
                          {ncc.hinhanh_url ? (
                            <img src={ncc.hinhanh_url} alt={ncc.tennhacungcap} className="w-full h-full object-cover" />
                          ) : (
                            <ImageIcon size={20} className="text-slate-300" />
                          )}
                       </div>
                       <div className="flex flex-col">
                          <span className="font-bold text-slate-900 group-hover:text-primary transition-colors">{ncc.tennhacungcap}</span>
                          <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID: #{ncc.id}</span>
                       </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <div className="flex flex-col items-center gap-1">
                       <span className="font-bold text-slate-700">{ncc.sanpham_count}</span>
                       <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Mật hàng</span>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <button 
                      onClick={() => router.patch(route('nhacungcap.toggleStatus', ncc.id), {}, { preserveScroll: true })}
                      className="hover:scale-105 active:scale-95 transition-all cursor-pointer"
                      title="Nhấp để đổi trạng thái"
                    >
                      <StatusBadge 
                        status={ncc.anhien === 1 ? 'Đang hợp tác' : 'Ngừng hợp tác'} 
                      />
                    </button>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2">
                       <Link 
                        href={route('nhacungcap.edit', ncc.id)}
                        className="p-2 text-slate-400 hover:text-amber-500 hover:bg-slate-100 rounded-xl transition-all"
                       >
                        <Edit size={18} />
                      </Link>
                      <Link 
                        href={route('nhacungcap.destroy', ncc.id)}
                        method="delete"
                        as="button"
                        onBefore={() => confirm('Xóa nh? cung cấp này?')}
                        className="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-100 rounded-xl transition-all"
                      >
                        <Trash2 size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {nhacungcaps.data.length === 0 && (
                <tr>
                  <td colSpan={5} className="px-6 py-20 text-center">
                    <div className="flex flex-col items-center gap-3">
                      <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                        <Truck size={32} />
                      </div>
                      <p className="text-slate-400 font-medium italic">Không tìm thấy nh? cung cấp nào.</p>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold">
            TRANG {nhacungcaps.current_page} / {nhacungcaps.last_page}
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={nhacungcaps.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !nhacungcaps.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <Link 
              href={nhacungcaps.next_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !nhacungcaps.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
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
