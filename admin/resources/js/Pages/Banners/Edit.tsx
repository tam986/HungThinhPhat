import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  Image as ImageIcon, 
  ArrowLeft, 
  Save, 
  X,
  Upload,
  ExternalLink,
  Hash,
  Type,
  Eye,
  EyeOff
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface Banner {
  id: number;
  tieude: string | null;
  duongdan: string | null;
  thutu: number;
  anhien: number;
  hinhanh: string | null;
  hinhanh_url: string | null;
}

interface Props {
  banner: Banner;
}

export default function EditBanner({ banner }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    tieude: banner.tieude || '',
    duongdan: banner.duongdan || '',
    thutu: banner.thutu,
    anhien: banner.anhien,
    hinhanh: null as File | null,
    _method: 'PUT', // For multipart/form-data with PUT
  });

  const [preview, setPreview] = React.useState<string | null>(banner.hinhanh_url);

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('hinhanh', file);
      setPreview(URL.createObjectURL(file));
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('banners.update', banner.id), {
      forceFormData: true,
    });
  };

  return (
    <AdminLayout>
      <Head title={`Sửa Banner: ${banner.tieude || banner.id}`} />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('banners.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Chỉnh sửa Banner</h1>
            <p className="text-slate-500 text-sm mt-1">
              Cập nhật thống tin về hình ảnh cho banner hiện tại.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-4xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Form Fields */}
          <div className="lg:col-span-2 space-y-6">
            <div className="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-dark space-y-5">
              <div>
                <label className="block text-sm font-semibold mb-1.5 text-slate-700 flex items-center gap-2">
                  <Type size={16} className="text-slate-400" />
                  Tiêu đề banner
                </label>
                <input 
                  type="text"
                  value={data.tieude}
                  onChange={e => setData('tieude', e.target.value)}
                  className={cn(
                    "w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                    errors.tieude && "border-red-500 ring-red-500/10"
                  )}
                  placeholder="Nhập tiêu đề banner..."
                />
                {errors.tieude && <p className="text-red-500 text-xs mt-1">{errors.tieude}</p>}
              </div>

              <div>
                <label className="block text-sm font-semibold mb-1.5 text-slate-700 flex items-center gap-2">
                  <ExternalLink size={16} className="text-slate-400" />
                  Đường dẫn (URL)
                </label>
                <input 
                  type="text"
                  value={data.duongdan}
                  onChange={e => setData('duongdan', e.target.value)}
                  className={cn(
                    "w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                    errors.duongdan && "border-red-500 ring-red-500/10"
                  )}
                  placeholder="Ví dụ: /san-pham-khuyen-mai"
                />
                {errors.duongdan && <p className="text-red-500 text-xs mt-1">{errors.duongdan}</p>}
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-semibold mb-1.5 text-slate-700 flex items-center gap-2">
                    <Hash size={16} className="text-slate-400" />
                    Thứ tự hiển thị
                  </label>
                  <input 
                    type="number"
                    value={data.thutu}
                    onChange={e => setData('thutu', parseInt(e.target.value))}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                      errors.thutu && "border-red-500 ring-red-500/10"
                    )}
                  />
                  {errors.thutu && <p className="text-red-500 text-xs mt-1">{errors.thutu}</p>}
                </div>

                <div>
                  <label className="block text-sm font-semibold mb-1.5 text-slate-700 flex items-center gap-2">
                    {data.anhien === 1 ? <Eye size={16} className="text-emerald-500" /> : <EyeOff size={16} className="text-slate-400" />}
                    Trạng thái
                  </label>
                  <select 
                    value={data.anhien}
                    onChange={e => setData('anhien', parseInt(e.target.value))}
                    className="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                  >
                    <option value={1}>Đang hiển thị</option>
                    <option value={0}>Đang ẩn</option>
                  </select>
                </div>
              </div>
            </div>

            <div className="flex items-center justify-end gap-3">
              <Link 
                href={route('banners.index')}
                className="px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all"
              >
                Hủy bỏ
              </Link>
              <button
                type="submit"
                disabled={processing}
                className="flex items-center gap-2 px-8 py-2.5 bg-primary text-slate-900 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 active:scale-95 disabled:opacity-50"
              >
                <Save size={18} />
                {processing ? 'Đang lưu...' : 'Lưu thay đổi'}
              </button>
            </div>
          </div>

          {/* Image Preview */}
          <div className="lg:col-span-1">
            <div className="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-dark sticky top-24">
              <h2 className="text-lg font-bold flex items-center gap-2 mb-4">
                <ImageIcon size={20} className="text-primary" />
                Hình ảnh
              </h2>

              <div className="relative group">
                <div className={cn(
                  "w-full aspect-[16/9] rounded-xl border-2 border-dashed flex flex-col items-center justify-center overflow-hidden transition-all",
                  preview ? "border-solid border-slate-200" : "border-slate-300 bg-slate-50 hover:bg-slate-100 hover:border-primary"
                )}>
                  {preview ? (
                    <img src={preview} alt="Banner Preview" className="w-full h-full object-cover" />
                  ) : (
                    <div className="flex flex-col items-center text-slate-400">
                      <Upload size={32} className="mb-2" />
                      <p className="text-xs font-medium">Chọn ảnh/Kéo thả</p>
                    </div>
                  )}
                  
                  <input 
                    type="file" 
                    onChange={handleImageChange}
                    className="absolute inset-0 opacity-0 cursor-pointer"
                    accept="image/png, image/jpeg, image/gif, image/webp, image/avif"
                  />
                </div>

                {preview && (
                  <div className="mt-4 flex items-center justify-between text-xs font-medium text-slate-500">
                    <span>Banner hiện tại</span>
                    <button 
                      type="button" 
                      onClick={() => { setPreview(null); setData('hinhanh', null); }}
                      className="text-red-500 hover:underline"
                    >
                      Xóa ảnh
                    </button>
                  </div>
                )}
              </div>
              
              <div className="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-100">
                 <p className="text-[10px] text-amber-700 leading-relaxed font-medium">
                   Mẹo: Ảnh banner nên có tỉ lệ 16:9 hoặc theo kích thước chuẩn của website để hiển thị đẹp nhất.
                 </p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
