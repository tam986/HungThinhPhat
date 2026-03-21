import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Trash2, 
  ArrowLeft, 
  Search, 
  RotateCcw, 
  AlertCircle, 
  FileText,
  ChevronLeft,
  ChevronRight,
  ShieldX
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface Post {
  id: number;
  tieude: string;
  anhdaidien_url: string | null;
  deleted_at: string;
  user: { hoten: string };
  danhmucbaiviet: { tendanhmuc: string };
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
  filters: {
    search?: string;
  };
}

export default function PostTrashed({ posts, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('baiviet.trashed'), { search }, { preserveState: true });
  };

  return (
    <AdminLayout>
      <Head title="Thống rác bài viết" />

      <div className="flex items-center gap-3">
        <Link 
          href={route('baiviet.index')}
          className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
        >
          <ArrowLeft size={20} />
        </Link>
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thống rác bài viết</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Phục hồi bài viết đã xóa hoặc dẫn dẹp bộ nhớ vĩnh viễn.
          </p>
        </div>
      </div>

      <div className="mt-8 bg-amber-50 border border-amber-100 p-4 rounded-2xl flex items-start gap-3 animate-in fade-in slide-in-from-top-2 duration-500">
        <AlertCircle className="text-amber-500 mt-0.5" size={20} />
        <div>
          <p className="text-sm font-bold text-amber-800 italic">Lưu Đã dẫn dẹp</p>
          <p className="text-xs text-amber-600 mt-0.5 leading-relaxed font-medium capitalize">Các bài viết khi xóa vĩnh viễn sẽ không thể phục hồi về hình ảnh đi kiếm cũng sẽ bị gỡ b??.</p>
        </div>
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/10">
          <form onSubmit={handleSearch} className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm tiền bài viết đã xóa..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-2xl py-2.5 px-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
            />
            <button type="submit" className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 p-1.5 hover:text-primary transition-colors">
              <Search size={18} />
            </button>
          </form>
          <div className="text-xs font-bold text-slate-400 uppercase tracking-widest italic group hover:text-slate-600 transition-all cursor-default flex items-center gap-2">
             <ShieldX size={16} /> 
             {posts.total} bài viết đang chờ xử là
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider w-[50%]">Bài viết</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Người biến tập</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Hình động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50 text-dark">
              {posts.data.map((post) => (
                <tr key={post.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-4">
                      <div className="w-16 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden grayscale opacity-70">
                        {post.anhdaidien_url ? (
                          <img src={post.anhdaidien_url} className="w-full h-full object-cover" />
                        ) : (
                          <div className="w-full h-full flex items-center justify-center text-slate-300">
                            <FileText size={20} />
                          </div>
                        )}
                      </div>
                      <div className="flex flex-col min-w-0">
                        <span className="font-bold text-slate-400 line-through truncate leading-tight italic">{post.tieude}</span>
                        <span className="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-widest">{post.danhmucbaiviet?.tendanhmuc}</span>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="font-bold text-slate-500 italic text-xs uppercase">{post.user?.hoten}</span>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-2">
                      <Link 
                        href={route('baiviet.restore', post.id)}
                        method="post"
                        as="button"
                        className="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-emerald-600 hover:text-slate-900 transition-all shadow-sm"
                      >
                        <RotateCcw size={14} />
                        Khối phục
                      </Link>
                      <Link 
                        href={route('baiviet.forceDelete', post.id)}
                        method="delete"
                        as="button"
                        onBefore={() => confirm('CẢNH BỏO: Thao tác này sẽ xóa vĩnh viễn bài viết về hình ảnh! Tiếp tục?')}
                        className="flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-500 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-slate-900 transition-all shadow-sm"
                      >
                        <Trash2 size={14} />
                        Xóa hẳn
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {posts.data.length === 0 && (
                <tr>
                  <td colSpan={3} className="px-6 py-20 text-center">
                    <div className="flex flex-col items-center gap-3">
                      <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                        <Trash2 size={32} />
                      </div>
                      <p className="text-slate-400 font-bold italic tracking-wide uppercase text-[10px]">Thống rác hiện đang trống rỗng.</p>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold">
            TRONG THÊMNG RácC: <span className="text-red-500">{posts.data.length}</span> / {posts.total}
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={posts.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-400 transition-all shadow-sm",
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
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-400 transition-all shadow-sm",
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
