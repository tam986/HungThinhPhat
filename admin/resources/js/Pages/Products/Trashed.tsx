import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Trash2, 
  RotateCcw, 
  Search, 
  ArrowLeft,
  ChevronLeft,
  ChevronRight,
  Image as ImageIcon,
  ShieldAlert
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import { cn } from '@/lib/utils';

interface Product {
  id: number;
  tensp: string;
  total_soluong: number;
  danhmuc: { tendanhmuc: string };
  nhacungcap: { tennhacungcap: string };
  bienthe: Array<{ hinh: string | null }>;
}

interface Props {
  sanphams: {
    data: Product[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
  danhmucs: Array<{ id: number; tendanhmuc: string }>;
  nhacungcaps: Array<{ id: number; tennhacungcap: string }>;
  filters: {
    search?: string;
    sort?: string;
    danhmuc?: string;
    nhacungcap?: string;
  };
}

export default function ProductTrashed({ sanphams, danhmucs, nhacungcaps, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('sanpham.trashed'), { ...filters, search }, { preserveState: true });
  };

  const handleFilterChange = (name: string, value: string) => {
    router.get(route('sanpham.trashed'), { ...filters, [name]: value }, { preserveState: true });
  };

  return (
    <AdminLayout>
      <Head title="Thống rác sản phẩm" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('sanpham.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={20} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thống rác Sản phẩm</h1>
            <p className="text-slate-500 text-sm mt-1">
              Danh sách sản phẩm Đã xóa tìm thái.
            </p>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <MetricCard title="Têng sản phẩm Đã xóa" value={sanphams.total} icon={Trash2} variant="warning" />
      </div>

      <div className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in zoom-in-95 duration-500">
        <div className="p-4 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/50">
          <div className="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <select 
              className="bg-white border border-slate-200 rounded-xl py-2 px-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"
              value={filters.danhmuc || ''}
              onChange={(e) => handleFilterChange('danhmuc', e.target.value)}
            >
              <option value="">Danh mục</option>
              {danhmucs.map(dm => (
                <option key={dm.id} value={dm.id}>{dm.tendanhmuc}</option>
              ))}
            </select>

            <select 
              className="bg-white border border-slate-200 rounded-xl py-2 px-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"
              value={filters.nhacungcap || ''}
              onChange={(e) => handleFilterChange('nhacungcap', e.target.value)}
            >
              <option value="">Nh? cung cấp</option>
              {nhacungcaps.map(ncc => (
                <option key={ncc.id} value={ncc.id}>{ncc.tennhacungcap}</option>
              ))}
            </select>
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-72">
            <input 
              type="text" 
              placeholder="Tìm sản phẩm Đã xóa..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-xl py-2 px-4 pr-10 text-sm focus:ring-2 focus:ring-primary/20 outline-none"
            />
            <button type="submit" className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
              <Search size={18} />
            </button>
          </form>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-semibold text-slate-600">ID</th>
                <th className="px-6 py-4 font-semibold text-slate-600">Sản phẩm</th>
                <th className="px-6 py-4 font-semibold text-slate-600">Danh mục</th>
                <th className="px-6 py-4 font-semibold text-slate-600">Nh? cung cấp</th>
                <th className="px-6 py-4 font-semibold text-slate-600 text-center">Tên kho</th>
                <th className="px-6 py-4 font-semibold text-slate-600 text-center">Thao tức</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {sanphams.data.map((product) => (
                <tr key={product.id} className="hover:bg-slate-50/80 transition-colors group">
                  <td className="px-6 py-4 text-slate-400">#{product.id}</td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                       <div className="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex-shrink-0 overflow-hidden text-slate-400 flex items-center justify-center">
                        {product.bienthe[0]?.hinh ? (
                          <img src={`/storage/${product.bienthe[0].hinh}`} className="w-full h-full object-cover grayscale opacity-60" />
                        ) : (
                          <ImageIcon size={16} />
                        )}
                      </div>
                      <span className="font-medium text-slate-900 grayscale opacity-70">{product.tensp}</span>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-slate-500">{product.danhmuc?.tendanhmuc}</td>
                  <td className="px-6 py-4 text-slate-500">{product.nhacungcap?.tennhacungcap}</td>
                  <td className="px-6 py-4 text-center text-slate-400">{product.total_soluong}</td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                      <Link 
                        href={route('sanpham.restore', product.id)} 
                        method="post"
                        as="button"
                        className="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all"
                        onBefore={() => confirm('Bạn muốn khôi phục sản phẩm này?')}
                      >
                        <RotateCcw size={18} />
                      </Link>
                      <Link 
                        href={route('sanpham.destroy', product.id)} 
                        method="delete"
                        as="button"
                        className="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all"
                        onBefore={() => confirm('L?U ?: Sản phẩm này s? b? xóa vĩnh viễn về không th? khôi phục. Bạn c? chắc chọn?')}
                      >
                        <ShieldAlert size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {sanphams.data.length === 0 && (
                <tr>
                  <td colSpan={6} className="px-6 py-12 text-center text-slate-400 italic">
                    Thống rác trống.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-6 py-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-medium">
            Trang <span className="text-slate-900">{sanphams.current_page}</span> / {sanphams.last_page}
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={sanphams.prev_page_url || '#'} 
              className={cn(
                "p-2 border border-slate-200 rounded-xl transition-all",
                !sanphams.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:bg-white text-slate-400 hover:text-slate-900 shadow-sm"
              )}
            >
               <ChevronLeft size={18} />
            </Link>
            <Link 
              href={sanphams.next_page_url || '#'} 
              className={cn(
                "p-2 border border-slate-200 rounded-xl transition-all",
                !sanphams.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:bg-white text-slate-400 hover:text-slate-900 shadow-sm"
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
