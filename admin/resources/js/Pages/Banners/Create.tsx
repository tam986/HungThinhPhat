import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Upload, 
  X,
  FileText,
  Link as LinkIcon,
  Layers,
  Save,
  Image as ImageIcon
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function BannerCreate() {
  const { data, setData, post, processing, errors } = useForm({
    tieude: '',
    duongdan: '',
    thutu: 0,
    anhien: 1,
    hinhanh: null as File | null,
  });

  const [preview, setPreview] = useState<string | null>(null);

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('hinhanh', file);
      const reader = new FileReader();
      reader.onloadend = () => {
        setPreview(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const removeImage = () => {
    setData('hinhanh', null);
    setPreview(null);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('banners.store'));
  };

  return (
    <AdminLayout>
      <Head title="Thêm Banner" />

      <div className="max-w-4xl mx-auto space-y-6">
        {/* Back Link */}
        <div>
          <Link 
            href={route('banners.index')} 
            className="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors"
          >
            <ArrowLeft size={16} />
            Quay lại danh sách
          </Link>
        </div>

        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thêm Banner mới</h1>
            <p className="text-slate-500 text-sm mt-1">Tạo banner quảng cáo mới cho trang chủ.</p>
          </div>
        </div>

        <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8 text-dark">
          {/* Main Info Card */}
          <div className="lg:col-span-2 space-y-6">
            <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
               <div className="space-y-4">
                  <div className="space-y-2">
                    <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                      <FileText size={16} className="text-slate-400" />
                      Tiêu đề Banner
                    </label>
                    <input 
                      type="text" 
                      placeholder="VD: Khuyến mới mãa hủy 2026"
                      className={cn(
                        "w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                        errors.tieude && "border-red-300 focus:ring-red-100"
                      )}
                      value={data.tieude}
                      onChange={e => setData('tieude', e.target.value)}
                    />
                    {errors.tieude && <p className="text-xs text-red-500 mt-1">{errors.tieude}</p>}
                  </div>

                  <div className="space-y-2">
                    <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                      <LinkIcon size={16} className="text-slate-400" />
                      Đường dẫn (URL)
                    </label>
                    <input 
                      type="text" 
                      placeholder="VD: /san-pham-khuyen-mai"
                      className={cn(
                        "w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                        errors.duongdan && "border-red-300 focus:ring-red-100"
                      )}
                      value={data.duongdan}
                      onChange={e => setData('duongdan', e.target.value)}
                    />
                    <p className="text-[10px] text-slate-400">Người dùng sẽ được chuyển tới link này khi bấm vào banner.</p>
                    {errors.duongdan && <p className="text-xs text-red-500 mt-1">{errors.duongdan}</p>}
                  </div>
               </div>
            </div>

            {/* Image Upload Card */}
            <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
               <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                  <ImageIcon size={16} className="text-slate-400" />
                  Hình ảnh Banner
               </label>
               
               <div className={cn(
                 "relative border-2 border-dashed rounded-2xl transition-all duration-300 overflow-hidden flex flex-col items-center justify-center min-h-[240px]",
                 preview ? "border-primary/20 bg-primary/[0.02]" : "border-slate-200 bg-slate-50 hover:bg-slate-100/50 hover:border-slate-300"
               )}>
                  {preview ? (
                    <div className="relative w-full h-full p-2">
                      <img src={preview} alt="Preview" className="max-h-[300px] w-full object-contain rounded-xl" />
                      <button 
                        type="button"
                        onClick={removeImage}
                        className="absolute top-4 right-4 p-2 bg-red-500 text-slate-900 rounded-full shadow-lg hover:bg-red-600 transition-colors"
                      >
                        <X size={16} />
                      </button>
                    </div>
                  ) : (
                    <label className="w-full h-full flex flex-col items-center justify-center p-12 cursor-pointer">
                      <div className="w-16 h-16 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-primary mb-4">
                        <Upload size={28} />
                      </div>
                      <span className="font-semibold text-slate-900">Bấm để tải ảnh lên</span>
                      <span className="text-xs text-slate-500 mt-1">Hỗ trợ JPG, PNG, GIF, WebP, AVIF (Max 5MB)</span>
                      <input 
                        type="file" 
                        className="hidden" 
                        accept="image/png, image/jpeg, image/gif, image/webp, image/avif"
                        onChange={handleImageChange}
                      />
                    </label>
                  )}
               </div>
               {errors.hinhanh && <p className="text-xs text-red-500 mt-1">{errors.hinhanh}</p>}
            </div>
          </div>

          {/* Sidebar Info/Settings */}
          <div className="space-y-6">
            <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
               <div className="space-y-4 text-dark">
                  <div className="space-y-2">
                    <label className="text-sm font-semibold text-slate-700 flex items-center gap-2 text-dark">
                      <Layers size={16} className="text-slate-400" />
                      Thứ tự hiển thị
                    </label>
                    <input 
                      type="number" 
                      className="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all outline-none text-dark"
                      value={data.thutu}
                      onChange={e => setData('thutu', parseInt(e.target.value))}
                    />
                  </div>

                  <div className="space-y-3">
                    <label className="text-sm font-semibold text-slate-700 block">Trạng thái hiển thị</label>
                    <div className="flex bg-slate-50 p-1 rounded-xl border border-slate-200">
                      <button 
                        type="button"
                        onClick={() => setData('anhien', 1)}
                        className={cn(
                          "flex-1 py-1.5 text-xs font-medium rounded-lg transition-all",
                          data.anhien === 1 ? "bg-white text-emerald-600 shadow-sm border border-emerald-100" : "text-slate-500 hover:text-slate-700"
                        )}
                      >
                        Hiển thị
                      </button>
                      <button 
                        type="button"
                        onClick={() => setData('anhien', 0)}
                        className={cn(
                          "flex-1 py-1.5 text-xs font-medium rounded-lg transition-all",
                          data.anhien === 0 ? "bg-white text-slate-600 shadow-sm border border-slate-100" : "text-slate-500 hover:text-slate-700"
                        )}
                      >
                        Đãang ẩn
                      </button>
                    </div>
                  </div>
               </div>

               <div className="pt-6 border-t border-slate-50 space-y-3">
                  <button 
                    disabled={processing}
                    type="submit"
                    className="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-slate-900 bg-primary rounded-xl hover:bg-primary/90 transition-all shadow-md shadow-primary/20 disabled:opacity-50"
                  >
                    <Save size={18} />
                    Lưu Banner
                  </button>
                  <Link 
                    href={route('banners.index')}
                    className="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-all"
                  >
                    Hủy bĐã
                  </Link>
               </div>
            </div>
            
            <div className="bg-amber-50 rounded-2xl border border-amber-100 p-4">
               <h4 className="text-amber-800 font-bold text-xs uppercase tracking-wider mb-2">Lưu Đã về kịch thước</h4>
               <p className="text-[11px] text-amber-700 leading-relaxed">
                  Để cĐã giao diện đẹp nhất, vui lượng sử dụng hình ảnh cĐã tỷ lệ **21:9** (Về dụ: 2100x900px) về dung lượng dưới 2MB để tối ưu tốc độ tải trang.
               </p>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
