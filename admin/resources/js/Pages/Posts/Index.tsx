import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  FileText, 
  Plus, 
  Search, 
  MoreVertical, 
  Edit, 
  Trash2, 
  Eye,
  ChevronLeft,
  ChevronRight,
  Filter,
  Calendar,
  User as UserIcon,
  Tag,
  ArrowRight
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface Category {
  id: number;
  tendm: string;
}

interface Post {
  id: number;
  tieude: string;
  anhdaidien_url: string | null;
  anhien: number;
  luotxem: number;
  created_at: string;
  user: { hoten: string };
  danhmucbaiviet: { tendm: string };
}

interface Props {
  posts: {
    data: Post[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
  categories: Category[];
  filters: {
    search?: string;
    category?: string;
    status?: string;
    sort?: string;
  };
}

export default function PostIndex({ posts, categories, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('baiviet.index'), { ...filters, search }, { preserveState: true });
  };

  const handleFilterChange = (name: string, value: string) => {
    router.get(route('baiviet.index'), { ...filters, [name]: value }, { preserveState: true });
  };

  return (
    <AdminLayout>
      <Head title="Quản lý bài viết" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark font-display">Tất cả bài viết</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Biên tập, quản lý nội dung blog và tin tức website.
          </p>
        </div>
        <div className="flex items-center gap-3">
          <Link 
            href={route('baiviet.trashed')}
            className="p-3 bg-white border border-slate-200 rounded-2xl text-slate-500 hover:text-red-500 transition-all shadow-sm"
            title="Thùng rác"
          >
            <Trash2 size={20} />
          </Link>
          <Link 
            href={route('baiviet.create')}
            className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
          >
            <Plus size={18} />
            Viết bài mới
          </Link>
        </div>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <MetricCard title="Tổng bài viết" value={posts.total} icon={FileText} variant="primary" />
        <MetricCard title="Đang hiển thị" value={posts.data.filter(p => p.anhien === 1).length} icon={Eye} variant="success" />
        <MetricCard title="Danh mục" value={categories.length} icon={Tag} variant="warning" />
        <Link href={route('danhmuc.index')} className="group">
           <div className="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:border-primary transition-all flex flex-col justify-between h-full group-hover:bg-slate-50/50">
              <div className="flex items-center justify-between">
                 <span className="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Chuyển mục</span>
                 <div className="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-slate-900 transition-all">
                    <ArrowRight size={16} />
                 </div>
              </div>
              <p className="text-sm font-bold text-slate-900 mt-4 italic underline decoration-slate-200 decoration-2 underline-offset-4">Quản lý danh mục bài viết</p>
           </div>
        </Link>
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/30">
          <div className="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.category?.toString() ?? ''}
              onChange={(e) => handleFilterChange('category', e.target.value)}
            >
              <option value="">Tất cả danh mục</option>
              {categories.map(cat => (
                <option key={cat.id} value={cat.id}>{cat.tendm}</option>
              ))}
            </select>

            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.status?.toString() ?? ''}
              onChange={(e) => handleFilterChange('status', e.target.value)}
            >
              <option value="">Trạng thái</option>
              <option value="1">Đang hiện</option>
              <option value="0">Tạm ẩn</option>
            </select>

            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.sort?.toString() ?? ''}
              onChange={(e) => handleFilterChange('sort', e.target.value)}
            >
              <option value="">Sắp xếp</option>
              <option value="latest">Mới nhất</option>
              <option value="az">A-Z</option>
              <option value="za">Z-A</option>
            </select>
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm kiếm bài viết, tác giả..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-2xl py-2.5 px-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
            />
            <button type="submit" className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 p-1.5 hover:text-primary transition-colors">
              <Search size={18} />
            </button>
          </form>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider w-[45%]">Bài viết</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Thông tin</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Trạng thái</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {posts.data.map((post) => (
                <tr key={post.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-4">
                      <div className="w-20 h-14 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                        {post.anhdaidien_url ? (
                          <img src={post.anhdaidien_url} className="w-full h-full object-cover" />
                        ) : (
                          <div className="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                            <FileText size={20} />
                          </div>
                        )}
                      </div>
                      <div className="flex flex-col min-w-0">
                        <span className="font-bold text-slate-900 leading-tight truncate-2-lines italic underline decoration-slate-100 decoration-2 underline-offset-4 group-hover:decoration-primary/30 active:decoration-primary transition-all cursor-default">
                          {post.tieude}
                        </span>
                        <div className="flex items-center gap-3 mt-1.5">
                           <span className="text-[10px] text-slate-400 font-mono font-bold uppercase py-0.5 px-1 bg-slate-100 rounded">ID #{post.id}</span>
                           <span className="text-[10px] text-primary font-bold uppercase bg-primary/5 px-1.5 py-0.5 rounded leading-none">
                              {post.danhmucbaiviet?.tendm}
                           </span>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="space-y-1.5 min-w-[150px]">
                      <div className="flex items-center gap-2 text-slate-600 font-bold text-xs uppercase cursor-default">
                        <UserIcon size={14} className="text-slate-400" />
                        {post.user?.hoten}
                      </div>
                      <div className="flex items-center gap-2 text-slate-500 font-medium text-xs">
                        <Calendar size={14} className="text-slate-400" />
                        {new Date(post.created_at).toLocaleDateString('vi-VN')}
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <div className="flex flex-col items-center gap-1.5 cursor-default">
                      <StatusBadge 
                        status={post.anhien === 1 ? 'active' : 'inactive'} 
                        labels={{ active: 'Hiện', inactive: 'Ẩn' }} 
                      />
                      <span className="text-[10px] text-slate-400 font-bold flex items-center gap-1">
                         <Eye size={10} /> {(post.luotxem || 0).toLocaleString()} lượt xem
                      </span>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2">
                      <Link 
                        href={route('baiviet.show', post.id)}
                        className="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-xl transition-all"
                        title="Xem chi tiết"
                      >
                        <Eye size={18} />
                      </Link>
                      <Link 
                        href={route('baiviet.edit', post.id)}
                        className="p-2 text-slate-400 hover:text-amber-500 hover:bg-slate-100 rounded-xl transition-all"
                        title="Sửa bài viết"
                      >
                        <Edit size={18} />
                      </Link>
                      <Link 
                        href={route('baiviet.softDelete', post.id)}
                        method="delete"
                        as="button"
                        onBefore={() => confirm('Bạn có chắc chắn muốn chuyển bài viết này vào thùng rác?')}
                        className="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-100 rounded-xl transition-all"
                        title="Xóa tạm"
                      >
                        <Trash2 size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {posts.data.length === 0 && (
                <tr>
                  <td colSpan={4} className="px-6 py-20 text-center">
                    <div className="flex flex-col items-center gap-3">
                      <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                        <FileText size={32} />
                      </div>
                      <p className="text-slate-400 font-medium italic">Không tìm thấy bài viết nào.</p>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold">
            HIỂN THỊ <span className="text-primary">{posts.data.length}</span> / {posts.total}
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={posts.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !posts.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <div className="px-4 text-sm font-bold text-slate-700">
              {posts.current_page}
            </div>
            <Link 
              href={posts.next_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !posts.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
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
