import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  MessageSquare, 
  CheckCircle2, 
  XCircle, 
  Eye, 
  EyeOff, 
  Clock, 
  User, 
  ShoppingBag,
  MoreVertical,
  ChevronLeft,
  ChevronRight,
  Star
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface Comment {
  id: number;
  noidung: string;
  sosao: number;
  trangthai: string;
  anhien: number;
  user: {
    name: string;
  };
  bienthe: {
    sanpham: {
      tensanpham: string;
    }
  };
  created_at: string;
}

interface Props {
  comments: {
    data: Comment[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
}

export default function CommentIndex({ comments }: Props) {
  const handleAction = (method: 'put' | 'post', routeName: string, id: number) => {
    if (method === 'put') {
      router.put(route(routeName, id), {}, { preserveScroll: true });
    } else {
      router.post(route(routeName, id), {}, { preserveScroll: true });
    }
  };

  return (
    <AdminLayout>
      <Head title="Quản lý bình luận" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Bình luận & Đãnh gi?</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
             Theo dưới về kiểm duyệt phản hồi t? khách hàng.
          </p>
        </div>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <MetricCard title="Têng bình luận" value={comments.total} icon={MessageSquare} variant="primary" />
        <MetricCard title="Ch? duyệt" value={comments.data.filter(c => c.trangthai === 'ch? duyệt').length} icon={Clock} variant="warning" />
        <MetricCard title="Đã duyệt" value={comments.data.filter(c => c.trangthai === '?? duyệt').length} icon={CheckCircle2} variant="success" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Khách hàng / Thời gian</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Nội dung / Sản phẩm</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">?ảnh gi?</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Trạng thái</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Cộng khai</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Duyệt</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {comments.data.map((c) => (
                <tr key={c.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-5">
                    <div className="flex items-center gap-3">
                       <div className="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                          <User size={18} />
                       </div>
                       <div className="flex flex-col">
                          <span className="font-bold text-slate-900">{c.user?.name || 'ơn danh'}</span>
                          <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center gap-1.5 mt-0.5">
                             <Clock size={10} /> {new Date(c.created_at).toLocaleDateString('vi-VN')}
                          </span>
                       </div>
                    </div>
                  </td>
                  <td className="px-6 py-5 max-w-xs">
                    <div className="flex flex-col gap-1.5">
                       <p className="text-slate-700 font-medium line-clamp-2 italic">"{c.noidung}"</p>
                       <div className="flex items-center gap-1.5 text-primary">
                          <ShoppingBag size={12} strokeWidth={3} />
                          <span className="text-[10px] font-black uppercase tracking-tight">{c.bienthe?.sanpham?.tensanpham}</span>
                       </div>
                    </div>
                  </td>
                  <td className="px-6 py-5 text-center">
                    <div className="flex items-center justify-center gap-0.5">
                       {[...Array(5)].map((_, i) => (
                         <Star 
                           key={i} 
                           size={12} 
                           className={i < c.sosao ? "fill-amber-400 text-amber-400" : "text-slate-200"} 
                         />
                       ))}
                    </div>
                  </td>
                  <td className="px-6 py-5 text-center">
                    <StatusBadge 
                      status={c.trangthai === '?? duyệt' ? 'success' : c.trangthai === 't? chối' ? 'danger' : 'warning'} 
                      labels={{ success: '?? duyệt', danger: 'T? chối', warning: 'Ch? duyệt' }} 
                    />
                  </td>
                  <td className="px-6 py-5 text-center">
                    <button 
                      onClick={() => handleAction('put', c.anhien === 1 ? 'binhluan.unactive' : 'binhluan.active', c.id)}
                      className={cn(
                        "p-2 rounded-xl transition-all",
                        c.anhien === 1 ? "text-emerald-500 bg-emerald-50 hover:bg-emerald-100" : "text-slate-300 bg-slate-50 hover:bg-slate-100"
                      )}
                      title={c.anhien === 1 ? "Đang hiện - Bấm Đã ơn" : "Đang ơn - Bấm Đã hiện"}
                    >
                      {c.anhien === 1 ? <Eye size={18} /> : <EyeOff size={18} />}
                    </button>
                  </td>
                  <td className="px-6 py-5">
                    <div className="flex items-center justify-center gap-2">
                       <button 
                         onClick={() => handleAction('post', 'binhluan.duyet', c.id)}
                         disabled={c.trangthai === '?? duyệt'}
                         className={cn(
                           "p-2 rounded-xl transition-all shadow-sm border",
                           c.trangthai === '?? duyệt' ? "bg-slate-50 text-slate-300 border-slate-100 cursor-not-allowed" : "bg-white text-emerald-500 border-emerald-100 hover:bg-emerald-50"
                         )}
                         title="Duyệt bình luận"
                       >
                         <CheckCircle2 size={18} />
                       </button>
                       <button 
                         onClick={() => handleAction('put', 'binhluan.an', c.id)}
                         disabled={c.trangthai === 't? chối'}
                         className={cn(
                           "p-2 rounded-xl transition-all shadow-sm border",
                           c.trangthai === 't? chối' ? "bg-slate-50 text-slate-300 border-slate-100 cursor-not-allowed" : "bg-white text-red-500 border-red-100 hover:bg-red-50"
                         )}
                         title="T? chối/ơn"
                       >
                         <XCircle size={18} />
                       </button>
                    </div>
                  </td>
                </tr>
              ))}
              {comments.data.length === 0 && (
                <tr>
                  <td colSpan={6} className="px-6 py-20 text-center text-slate-400 italic font-medium">
                    Không c? bình luận nào Đã hiện th?.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold uppercase tracking-widest">
             {comments.total} PH?N H?I T? KH?CH H?NG
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={comments.prev_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !comments.prev_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <Link 
              href={comments.next_page_url || '#'} 
              className={cn(
                "p-2.5 bg-white border border-slate-200 rounded-2xl text-slate-600 transition-all shadow-sm",
                !comments.next_page_url ? "opacity-30 cursor-not-allowed" : "hover:text-primary hover:border-primary active:scale-90"
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
