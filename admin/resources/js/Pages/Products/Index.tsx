import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Package, 
  Plus, 
  Search, 
  Filter,
  MoreVertical,
  Eye,
  Edit,
  Trash2,
  ChevronRight,
  ChevronLeft,
  Image as ImageIcon,
  Layers,
  Truck
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import { cn } from '@/lib/utils';

interface Product {
  id: number;
  tensp: string;
  id_danhmuc: number;
  id_nhacungcap: number;
  mota: string;
  luotxem: number;
  anhien: boolean | number;
  is_featured: boolean | number;
  is_new: boolean | number;
  created_at: string;
  variant_count: number;
  total_stock: number;
  min_price: number;
  max_price: number;
  img: string | null;
  bienthe: Array<{ id: number; hinh: string | null }>;
  danhmuc: { tendanhmuc: string };
  nhacungcap: { tennhacungcap: string };
}

interface Props {
  sanphams: {
    data: Product[];
    links: any[];
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
    status?: string;
  };
}

export default function ProductIndex({ sanphams, danhmucs, nhacungcaps, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('sanpham.index'), { ...filters, search }, { preserveState: true });
  };

  const handleFilterChange = (name: string, value: string) => {
    router.get(route('sanpham.index'), { ...filters, [name]: value }, { preserveState: true });
  };

  const handleToggle = (id: number, type: 'featured' | 'new') => {
    const routeName = type === 'featured' ? 'sanpham.toggleFeatured' : 'sanpham.toggleNew';
    router.put(route(routeName, id), {}, {
      preserveScroll: true,
      preserveState: true,
    });
  };

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
  };

  return (
    <AdminLayout>
      <Head title="Sản phẩm" />

      {/* Header Section */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900">Quản lý Sản phẩm</h1>
          <p className="text-slate-500 text-sm mt-1">
            Tổng cộng <span className="font-semibold text-slate-900">{sanphams.total}</span> sản phẩm trong hệ thống.
          </p>
        </div>
        <div className="flex items-center gap-2">
          <Link 
            href={route('sanpham.trashed')}
            className="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm"
          >
            <Trash2 size={18} />
            Thùng rác
          </Link>
          <Link 
            href={route('sanpham.create')}
            className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
          >
            <Plus size={18} />
            Thêm sản phẩm
          </Link>
        </div>
      </div>

      {/* Metric Cards Row */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <MetricCard title="Tổng Sản phẩm" value={sanphams.total} icon={Package} variant="primary" />
        <MetricCard title="Danh mục" value={danhmucs.length} icon={Layers} variant="warning" />
        <MetricCard title="Nhà cung cấp" value={nhacungcaps.length} icon={Truck} variant="success" />
      </div>

      {/* Filter & Search Table Section */}
      <div className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-dark animate-in fade-in zoom-in-95 duration-500">
        <div className="p-4 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/50">
          <div className="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            {/* Category Filter */}
            <select 
              className="bg-white border border-slate-200 rounded-xl py-2 px-3 text-sm outline-none focus:ring-2 focus:ring-primary/20 transition-all"
              value={filters.danhmuc || ''}
              onChange={(e) => handleFilterChange('danhmuc', e.target.value)}
            >
              <option value="">Tất cả danh mục</option>
              {danhmucs.map(dm => (
                <option key={dm.id} value={dm.id}>{dm.tendanhmuc}</option>
              ))}
            </select>

            {/* Supplier Filter */}
            <select 
              className="bg-white border border-slate-200 rounded-xl py-2 px-3 text-sm outline-none focus:ring-2 focus:ring-primary/20 transition-all"
              value={filters.nhacungcap || ''}
              onChange={(e) => handleFilterChange('nhacungcap', e.target.value)}
            >
              <option value="">Tất cả nhà cung cấp</option>
              {nhacungcaps.map(ncc => (
                <option key={ncc.id} value={ncc.id}>{ncc.tennhacungcap}</option>
              ))}
            </select>

            {/* Sort Filter */}
            <select 
              className="bg-white border border-slate-200 rounded-xl py-2 px-3 text-sm outline-none focus:ring-2 focus:ring-primary/20 transition-all"
              value={filters.sort || 'latest'}
              onChange={(e) => handleFilterChange('sort', e.target.value)}
            >
              <option value="latest">Mới nhất</option>
              <option value="name-asc">Tên A-Z</option>
              <option value="name-desc">Tên Z-A</option>
              <option value="stock-asc">Tồn kho thấp</option>
              <option value="stock-desc">Tồn kho cao</option>
            </select>

            {/* Status Filter */}
            <select 
              className="bg-white border border-slate-200 rounded-xl py-2 px-3 text-sm outline-none focus:ring-2 focus:ring-primary/20 transition-all"
              value={filters.status || ''}
              onChange={(e) => handleFilterChange('status', e.target.value)}
            >
              <option value="">Tất cả trạng thái</option>
              <option value="1">Đang hiện</option>
              <option value="0">Đang ẩn</option>
            </select>
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-72">
            <input 
              type="text" 
              placeholder="Tìm tên sản phẩm, ID..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-xl py-2 px-4 pr-10 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none"
            />
            <button type="submit" className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary">
              <Search size={18} />
            </button>
          </form>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-semibold text-slate-600">Sản phẩm</th>
                <th className="px-6 py-4 font-semibold text-slate-600">Danh mục</th>
                <th className="px-6 py-4 font-semibold text-slate-600">Nhà cung cấp</th>
                <th className="px-6 py-4 font-semibold text-slate-600 text-center">Biến thể</th>
                <th className="px-6 py-4 font-semibold text-slate-600 text-center">Tồn kho</th>
                <th className="px-6 py-4 font-semibold text-slate-600 text-center">Trạng thái</th>
                <th className="px-6 py-4 font-semibold text-slate-600 text-center">Hành Động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {sanphams.data.map((product) => (
                <tr key={product.id} className="hover:bg-slate-50/80 transition-colors group">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-4">
                      <div className="w-14 h-14 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400">
                        {product.bienthe?.[0]?.hinh ? (
                          <img 
                            src={`/storage/${product.bienthe[0].hinh}`} 
                            alt={product.tensp} 
                            className="w-full h-full object-cover"
                          />
                        ) : (
                          <ImageIcon size={24} />
                        )}
                      </div>
                      <div className="flex flex-col gap-0.5">
                        <Link 
                    href={route('sanpham.detail', product.id)}
                    className="text-sm font-bold text-slate-900 hover:text-primary transition-colors cursor-pointer"
                  >
                    {product.tensp}
                  </Link>
                        <div className="text-[10px] font-mono text-slate-400 uppercase">#ID: {product.id}</div>
                        <div className="mt-1 text-sm font-semibold text-primary">
                          {formatCurrency(product.min_price)}
                          {product.max_price > product.min_price && (
                            <span className="text-slate-400 font-normal ml-1"> - {formatCurrency(product.max_price)}</span>
                          )}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/50">
                      {product.danhmuc?.tendanhmuc}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-slate-600 font-medium">
                    {product.nhacungcap?.tennhacungcap}
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                      {product.variant_count} biến thể
                    </span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <div className={cn(
                      "inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border",
                      product.total_stock > 10 
                        ? "bg-emerald-50 text-emerald-700 border-emerald-100" 
                        : "bg-red-50 text-red-700 border-red-100"
                    )}>
                      {product.total_stock}
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex flex-col items-center gap-1.5">
                       <span className={cn(
                         "px-2.5 py-0.5 rounded-full text-[10px] font-bold border",
                         product.anhien ? "bg-emerald-50 text-emerald-700 border-emerald-100" : "bg-slate-100 text-slate-500 border-slate-200"
                       )}>
                         {product.anhien ? 'Đang hiện' : 'Đang ẩn'}
                       </span>
                       {product.is_featured ? (
                         <span className="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold border border-amber-200">
                           Nổi bật
                         </span>
                       ) : null}
                       {product.is_new ? (
                         <span className="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold border border-blue-200">
                           Mới
                         </span>
                       ) : null}
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                      <Link 
                        href={route('sanpham.detail', product.id)}
                        className="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all"
                        title="Xem chi tiết & Quản lý biến thể"
                      >
                        <Eye size={18} />
                      </Link>
                      <Link href={route('sanpham.edit', product.id)} className="p-2 text-slate-400 hover:text-amber-600 transition-colors hover:bg-white rounded-lg border border-transparent hover:border-slate-100 shadow-sm">
                        <Edit size={18} />
                      </Link>
                      <Link 
                        href={route('sanpham.softDelete', product.id)} 
                        method="delete"
                        as="button"
                        className="p-2 text-slate-400 hover:text-red-600 transition-colors hover:bg-white rounded-lg border border-transparent hover:border-slate-100 shadow-sm"
                      >
                        <Trash2 size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* Pagination Section */}
        <div className="px-6 py-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-medium">
            Hiển thị <span className="text-slate-900 font-bold">{sanphams.data.length}</span> sản phẩm (Trang {sanphams.current_page} / {sanphams.last_page})
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
