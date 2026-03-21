import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  FolderTree, 
  Hash, 
  Eye, 
  EyeOff, 
  AlertCircle
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function CreatePostCategory() {
  const { data, setData, post, processing, errors } = useForm({
    tendm: '',
    thutu: '',
    anhien: 1,
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('danhmuc.store'));
  };

  return (
    <AdminLayout>
      <Head title="Thêm danh mục bài viết mới" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('danhmuc.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thêm danh mục bài viết</h1>
            <p className="text-slate-500 text-sm mt-1 font-medium">
               Tạo phần loại nội dung mới cho blog của bạn.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-3xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="md:col-span-2 space-y-6">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-6">
               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                     <FolderTree size={14} /> Tên danh mục
                  </label>
                  <input 
                    type="text"
                    value={data.tendm}
                    onChange={e => setData('tendm', e.target.value)}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder:text-slate-300",
                      errors.tendm && "border-red-500 bg-red-50/10"
                    )}
                    placeholder="VD: Tin tức nổi bật"
                  />
                  {errors.tendm && <p className="text-red-500 text-[10px] mt-1 italic font-bold">{errors.tendm}</p>}
               </div>

               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                     <Hash size={14} /> Thứ tự hiển thị
                  </label>
                  <input 
                    type="number"
                    value={data.thutu}
                    onChange={e => setData('thutu', e.target.value)}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder:text-slate-300",
                      errors.thutu && "border-red-500 bg-red-50/10"
                    )}
                    placeholder="VD: 1"
                  />
                  {errors.thutu && <p className="text-red-500 text-[10px] mt-1 italic font-bold">{errors.thutu}</p>}
               </div>
            </div>
          </div>

          <div className="md:col-span-1 space-y-6">
            <div className="bg-white p-6 rounded-[28px] border border-slate-200 shadow-sm text-dark sticky top-24">
               <div className="space-y-6">
                  <div>
                    <label className="block text-xs font-bold mb-4 text-slate-500 uppercase tracking-widest">Trạng thái</label>
                    <div className="space-y-3">
                       <label className={cn(
                         "flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer group",
                         data.anhien === 1 ? "bg-emerald-50 border-emerald-500 shadow-sm" : "bg-slate-50/50 border-slate-100 hover:border-emerald-200"
                       )}>
                          <input 
                            type="radio" 
                            name="anhien" 
                            value="1" 
                            className="hidden" 
                            checked={data.anhien === 1}
                            onChange={() => setData('anhien', 1)}
                          />
                          <div className={cn(
                            "w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all",
                            data.anhien === 1 ? "border-emerald-500 bg-emerald-500" : "border-slate-300 bg-white"
                          )}>
                             {data.anhien === 1 && <div className="w-1.5 h-1.5 rounded-full bg-white"></div>}
                          </div>
                          <span className={cn(
                            "text-xs font-black uppercase tracking-widest",
                            data.anhien === 1 ? "text-emerald-700" : "text-slate-400"
                          )}>Cộng khai</span>
                       </label>

                       <label className={cn(
                         "flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer group",
                         data.anhien === 0 ? "bg-slate-100 border-slate-400 shadow-sm" : "bg-slate-50/50 border-slate-100 hover:border-slate-300"
                       )}>
                          <input 
                            type="radio" 
                            name="anhien" 
                            value="0" 
                            className="hidden" 
                            checked={data.anhien === 0}
                            onChange={() => setData('anhien', 0)}
                          />
                          <div className={cn(
                            "w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all",
                            data.anhien === 0 ? "border-slate-400 bg-slate-400" : "border-slate-300 bg-white"
                          )}>
                             {data.anhien === 0 && <div className="w-1.5 h-1.5 rounded-full bg-white"></div>}
                          </div>
                          <span className={cn(
                            "text-xs font-black uppercase tracking-widest",
                            data.anhien === 0 ? "text-slate-700" : "text-slate-400"
                          )}>Tạm ẩn</span>
                       </label>
                    </div>
                  </div>

                  <div className="pt-6 border-t border-slate-50 space-y-3">
                     <button
                        type="submit"
                        disabled={processing}
                        className="w-full flex items-center justify-center gap-2 py-4 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 active:scale-95 disabled:opacity-50"
                     >
                       <Save size={18} />
                       {processing ? 'Đang lưu...' : 'Lưu danh mục'}
                     </button>
                     <Link 
                       href={route('danhmuc.index')}
                       className="w-full flex items-center justify-center py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95"
                     >
                       Hủy bĐã
                     </Link>
                  </div>
               </div>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
