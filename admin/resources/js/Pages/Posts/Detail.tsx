import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Edit, 
  User as UserIcon,
  Calendar,
  Tag,
  Eye,
  EyeOff
} from 'lucide-react';
import StatusBadge from '@/Components/StatusBadge';

interface Post {
  id: number;
  tieude: string;
  slug: string;
  seotieude: string;
  motangan: string | null;
  noidung: string;
  id_danhmuc: number;
  anhien: number;
  luotxem: number;
  anhdaidien_url: string | null;
  created_at: string;
  user: { hoten: string };
  danhmucbaiviet: { tendanhmuc: string };
}

interface Props {
  post: Post;
}

export default function DetailPost({ post }: Props) {
  return (
    <AdminLayout>
      <Head title={`Xem trước: ${post.tieude}`} />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div className="flex items-center gap-3">
          <Link 
            href={route('baiviet.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Xem trước bài viết</h1>
            <p className="text-slate-500 text-sm mt-1">
               ID: <span className="font-mono font-bold text-primary">#{post.id}</span>
            </p>
          </div>
        </div>
        <div className="flex items-center gap-3">
          <Link 
            href={route('baiviet.edit', post.id)}
            className="flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-slate-900 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
          >
            <Edit size={18} />
            Chỉnh sửa bài viết
          </Link>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {/* Main Content Preview */}
        <div className="lg:col-span-3 space-y-6">
          <div className="bg-white rounded-[32px] overflow-hidden border border-slate-200 shadow-sm animate-in fade-in slide-in-from-bottom-4 duration-500">
             {post.anhdaidien_url && (
               <div className="w-full h-[400px] bg-slate-100 relative">
                  <img 
                    src={post.anhdaidien_url} 
                    alt={post.tieude} 
                    className="w-full h-full object-cover"
                  />
               </div>
             )}
             
             <div className="p-8 md:p-12">
                <div className="mb-8 border-b border-slate-100 pb-8 space-y-4 text-center">
                   <h1 className="text-3xl md:text-5xl font-merriweather font-black text-slate-900 leading-tight">
                     {post.tieude}
                   </h1>
                   <div className="flex flex-wrap items-center justify-center gap-4 text-slate-500 font-medium text-sm pt-2 uppercase tracking-wide">
                      <span className="flex items-center gap-1.5 font-bold text-primary"><Tag size={16}/> {post.danhmucbaiviet?.tendanhmuc}</span>
                      <span className="flex items-center gap-1.5"><UserIcon size={16}/> {post.user?.hoten}</span>
                      <span className="flex items-center gap-1.5"><Calendar size={16}/> {new Date(post.created_at).toLocaleDateString('vi-VN')}</span>
                   </div>
                </div>

                {post.motangan && (
                  <div className="mb-10 text-lg text-slate-600 font-medium italic border-l-4 border-slate-200 pl-6 py-2">
                    {post.motangan}
                  </div>
                )}

                {/* Content Renderer */}
                <div 
                  className="prose prose-slate max-w-none prose-img:rounded-2xl prose-img:shadow-sm prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-primary"
                  dangerouslySetInnerHTML={{ __html: post.noidung || '' }}
                />
             </div>
          </div>
        </div>

        {/* Sidebar Info */}
        <div className="lg:col-span-1 space-y-6">
          <div className="bg-white p-6 rounded-[28px] border border-slate-200 shadow-sm sticky top-24">
             <h3 className="font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-50 pb-4 uppercase tracking-wider text-xs">
                Thông tin bài viết
             </h3>
             
             <div className="space-y-5">
                <div>
                   <span className="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Trạng thái</span>
                   <StatusBadge 
                     status={post.anhien === 1 ? 'active' : 'inactive'} 
                     labels={{ active: 'ĐANG HIỂN THỊ', inactive: 'ĐANG ẨN' }} 
                   />
                </div>

                <div>
                   <span className="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Lượt xem</span>
                   <div className="flex items-center gap-2 text-slate-700 font-bold text-lg">
                      <Eye size={18} className="text-slate-400" />
                      {(post.luotxem || 0).toLocaleString()}
                   </div>
                </div>

                <div>
                   <span className="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Slug (Đường dẫn)</span>
                   <p className="text-sm font-mono text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 break-all">
                     {post.slug}
                   </p>
                </div>

                {post.seotieude && (
                  <div>
                     <span className="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">SEO Title</span>
                     <p className="text-sm text-slate-700 font-bold italic">
                       {post.seotieude}
                     </p>
                  </div>
                )}
             </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
