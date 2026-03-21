import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Plus, 
  Search, 
  Edit, 
  Trash2, 
  ChevronLeft,
  ChevronRight,
  Database,
  Layers,
  ArrowRight
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import { cn } from '@/lib/utils';

interface CakeType {
  id: number;
  tenLoaiBanh: string;
  bienthe_count: number;
}

interface Props {
  cakeTypes: {
    data: CakeType[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
  filters: {
    search?: string;
  };
}

export default function CakeTypeIndex({ cakeTypes, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('loaibanh.index'), { ...filters, search }, { preserveState: true });
  };

  return (
    <AdminLayout>
      <Head title="Quản lý loại bánh" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Loại bánh</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium italic">
            Phân loại các dòng bánh trong hệ thống sản phẩm.
          </p>
        </div>
        <Link 
          href={route('loaibanh.create')}
          className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <Plus size={18} />
          Thêm loại bánh
        </Link>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mt-8">
        <MetricCard title="Tổng loại bánh" value={cakeTypes.total} icon={Layers} variant="primary" />
        <MetricCard title="Biến thể đang dùng" value={cakeTypes.data.reduce((acc, curr) => acc + curr.bienthe_count, 0)} icon={Database} variant="success" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/10">
          <div className="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
             <Layers size={16} className="text-primary" />
             Danh sách các loại bánh
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm loại bánh..." 
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
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider w-[60%]">Tên loại bánh</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Sử dụng</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Hành động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {cakeTypes.data.map((type) => (
                <tr key={type.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-4 text-center">
                    <span className="font-mono font-bold text-slate-400 text-xs">#{type.id}</span>
                  </td>
                  <td className="px-6 py-4">
                    <span className="font-black text-slate-900 group-hover:text-primary transition-colors text-base">{type.tenLoaiBanh}</span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <div className="flex flex-col items-center">
                       <span className="font-bold text-slate-700">{type.bienthe_count}</span>
                       <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Biến thể</span>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2">
                       <Link 
                        href={route('loaibanh.edit', type.id)}
                        className="p-2 text-slate-400 hover:text-amber-500 hover:bg-slate-100 rounded-xl transition-all"
                       >
                        <Edit size={18} />
                      </Link>
                      <button 
                        onClick={() => {
                          if (confirm('Xóa loại bánh này?')) {
                            router.delete(route('loaibanh.destroy', type.id));
                          }
                        }}
                        className="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-100 rounded-xl transition-all"
                      >
                        <Trash2 size={18} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
              {cakeTypes.data.length === 0 && (
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
            {cakeTypes.total} PHÂN LOẠI BÁNH
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={cakeTypes.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !cakeTypes.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <Link 
              href={cakeTypes.next_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !cakeTypes.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
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
