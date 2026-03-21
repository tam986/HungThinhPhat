import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  Truck, 
  Hash, 
  ImageIcon, 
  AlertCircle,
  X,
  UploadCloud
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface Supplier {
  id: number;
  tennhacungcap: string;
  thutu: number;
  anhien: number;
  img: string | null;
  hinhanh_url: string | null;
}

interface Props {
  nhacungcap: Supplier;
}

export default function EditSupplier({ nhacungcap }: Props) {
  const [preview, setPreview] = useState<string | null>(nhacungcap.hinhanh_url);

  const { data, setData, post, processing, errors } = useForm({
    tennhacungcap: nhacungcap.tennhacungcap,
    thutu: nhacungcap.thutu,
    anhien: nhacungcap.anhien,
    img: null as File | null,
    _method: 'PUT',
  });

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('img', file);
      setPreview(URL.createObjectURL(file));
    }
  };

  const removeImage = () => {
    setData('img', null);
    setPreview(null);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('nhacungcap.update', nhacungcap.id));
  };

  return (
    <AdminLayout>
      <Head title={`Sửa Đại lý: ${nhacungcap.tennhacungcap}`} />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('nhacungcap.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Chỉnh sửa Đại lý</h1>
            <p className="text-slate-500 text-sm mt-1 font-medium">
               Cập nhật thống tin đối tác ID: <span className="text-primary font-black">#{nhacungcap.id}</span>
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-4xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="md:col-span-2 space-y-6">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-6">
               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                     <Truck size={14} /> Tên Đại lý
                  </label>
                  <input 
                    type="text"
                    value={data.tennhacungcap}
                    onChange={e => setData('tennhacungcap', e.target.value)}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all",
                      errors.tennhacungcap && "border-red-500"
                    )}
                  />
                  {errors.tennhacungcap && <p className="text-red-500 text-[10px] mt-1 italic font-bold">{errors.tennhacungcap}</p>}
               </div>

               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                     <Hash size={14} /> Thứ tự ưu tiên
                  </label>
                  <input 
                    type="number"
                    value={data.thutu}
                    onChange={e => setData('thutu', parseInt(e.target.value) || 0)}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all",
                      errors.thutu && "border-red-500"
                    )}
                  />
                  {errors.thutu && <p className="text-red-500 text-[10px] mt-1 italic font-bold">{errors.thutu}</p>}
               </div>

               <div className="space-y-4">
                  <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                     <ImageIcon size={14} /> Logo Đại lý
                  </label>
                  
                  {preview ? (
                    <div className="relative w-40 h-40 rounded-3xl overflow-hidden border-2 border-primary/20 shadow-lg group">
                       <img src={preview} alt="Preview" className="w-full h-full object-contain bg-slate-50" />
                       <button 
                         type="button"
                         onClick={removeImage}
                         className="absolute top-2 right-2 p-1.5 bg-red-500 text-slate-900 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-lg"
                       >
                         <X size={14} />
                       </button>
                    </div>
                  ) : (
                    <div 
                      onClick={() => document.getElementById('img')?.click()}
                      className="w-full h-40 border-2 border-dashed border-slate-200 rounded-3xl flex flex-col items-center justify-center gap-2 hover:border-primary/40 hover:bg-slate-50/50 transition-all cursor-pointer group"
                    >
                       <div className="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                          <UploadCloud size={24} />
                       </div>
                       <p className="text-xs font-bold text-slate-400 uppercase tracking-wider">Thay đổi ảnh logo</p>
                    </div>
                  )}
                  <input 
                    id="img"
                    type="file" 
                    className="hidden" 
                    accept="image/png, image/jpeg, image/webp, image/avif"
                    onChange={handleImageChange}
                  />
                  {errors.img && <p className="text-red-500 text-[10px] italic font-bold">{errors.img}</p>}
               </div>
            </div>
          </div>

          <div className="md:col-span-1 space-y-6">
            <div className="bg-white p-6 rounded-[28px] border border-slate-200 shadow-sm text-dark sticky top-24">
               <div className="space-y-6">
                  <div>
                    <label className="block text-xs font-bold mb-4 text-slate-500 uppercase tracking-widest">Hợp tác</label>
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
                          )}>Đang hiện</span>
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
                       {processing ? 'Đang cập nhật...' : 'Cập nhật đối tác'}
                     </button>
                     <Link 
                       href={route('nhacungcap.index')}
                       className="w-full flex items-center justify-center py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95"
                     >
                       Quay lại
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
