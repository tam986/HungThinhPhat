import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Soup, 
  Plus, 
  Search, 
  Edit, 
  Trash2, 
  ChevronLeft,
  ChevronRight,
  Database,
  AlignJustify
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import { cn } from '@/lib/utils';

interface Filling {
  id: number;
  tenNhanBanh: string;
  bienthe_count: number;
}

interface Props {
  fillings: {
    data: Filling[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
  filters: {
    search?: string;
    sort?: string;
  };
}

export default function FillingIndex({ fillings, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('nhanbanh.index'), { ...filters, search }, { preserveState: true });
  };

  return (
    <AdminLayout>
      <Head title="Quản lý nhân bánh" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Nhân bánh</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Quản lý các loại nhân
          </p>
        </div>
        <Link 
          href={route('nhanbanh.create')}
          className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <Plus size={18} />
          Thêm nhân bánh
        </Link>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mt-8">
        <MetricCard title="Tổng nhân bánh" value={fillings.total} icon={Soup} variant="primary" />
        <MetricCard title="Biến thể áp dạng" value={fillings.data.reduce((acc, curr) => acc + curr.bienthe_count, 0)} icon={Database} variant="success" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/10">
          <div className="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
             <AlignJustify size={16} className="text-primary" />
             Danh sách nhân bánh
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm nhân bánh..." 
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
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider w-20 text-center">ID</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider w-[60%]">Tên nhân bánh</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Số sản phẩm</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Hành động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {fillings.data.map((nb) => (
                <tr key={nb.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-4 text-center">
                    <span className="font-mono font-bold text-slate-400 text-xs">#{nb.id}</span>
                  </td>
                  <td className="px-6 py-4">
                    <span className="font-black text-slate-900 group-hover:text-primary transition-colors text-base">{nb.tenNhanBanh}</span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <div className="flex flex-col items-center">
                       <span className="font-bold text-slate-700">{nb.bienthe_count}</span>
                       <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Biến thể</span>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2">
                       <Link 
                        href={route('nhanbanh.edit', nb.id)}
                        className="p-2 text-slate-400 hover:text-amber-500 hover:bg-slate-100 rounded-xl transition-all"
                       >
                        <Edit size={18} />
                      </Link>
                      <Link 
                        href={route('nhanbanh.destroy', nb.id)}
                        method="delete"
                        as="button"
                        onBefore={() => confirm('Xóa nhận bình này?')}
                        className="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-100 rounded-xl transition-all"
                      >
                        <Trash2 size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {fillings.data.length === 0 && (
                <tr>
                  <td colSpan={4} className="px-6 py-20 text-center text-slate-400 italic font-medium">
                    Không tìm thấy dữ liệu.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold uppercase tracking-widest">
            {fillings.total} LOẠI NHÂN BÁNH
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={fillings.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !fillings.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <Link 
              href={fillings.next_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !fillings.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
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
