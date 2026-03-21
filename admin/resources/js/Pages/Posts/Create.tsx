import React, { useEffect } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm, router } from '@inertiajs/react';
import { 
  FileText, 
  ArrowLeft, 
  Save, 
  Upload, 
  Type, 
  Link as LinkIcon, 
  Layers, 
  Eye, 
  EyeOff, 
  Search,
  BookOpen,
  Image as ImageIcon,
  RefreshCw
} from 'lucide-react';
import { cn, toSlug } from '@/lib/utils';
import RichTextEditor from '@/Components/RichTextEditor';

interface Category {
  id: number;
  tendm: string;
}

interface Props {
  categories: Category[];
}

export default function CreatePost({ categories }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    tieude: '',
    slug: '',
    seotieude: '',
    motangan: '',
    noidung: '',
    id_danhmuc: '',
    anhien: 1,
    anhdaidien: null as File | null,
  });

  const [preview, setPreview] = React.useState<string | null>(null);
  const [isAutoSlug, setIsAutoSlug] = React.useState(true);

  useEffect(() => {
    if (data.tieude && isAutoSlug) {
        setData('slug', toSlug(data.tieude));
    }
    if (data.tieude && !data.seotieude) {
        setData('seotieude', data.tieude);
    }
  }, [data.tieude, isAutoSlug]);

  const handleManualSlugChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setIsAutoSlug(false);
    setData('slug', e.target.value);
  };

  const refreshSlug = () => {
    setIsAutoSlug(true);
    setData('slug', toSlug(data.tieude));
  };

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('anhdaidien', file);
      setPreview(URL.createObjectURL(file));
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('baiviet.store'), {
      forceFormData: true,
      onSuccess: () => {
        router.visit(route('baiviet.index'));
      }
    });
  };

  return (
    <AdminLayout>
      <Head title="Viết bài mới" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('baiviet.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900">Viết bài mới</h1>
            <p className="text-slate-500 text-sm mt-1 font-medium">
               Sống tạo nội dung chất lượng cho website của bạn.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-6xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-4 gap-8">
          {/* Main Content */}
          <div className="lg:col-span-3 space-y-6">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm space-y-6">
               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Tiêu đề bài viết</label>
                  <input 
                    type="text"
                    value={data.tieude}
                    onChange={e => setData('tieude', e.target.value)}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-lg font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none italic",
                      errors.tieude && "border-red-500"
                    )}
                    placeholder="Nhập tiêu đề hấp dẫn..."
                  />
                  {errors.tieude && <p className="text-red-500 text-xs mt-1 italic">{errors.tieude}</p>}
               </div>

               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Mô tả ngắn (Sapo)</label>
                  <textarea 
                    value={data.motangan}
                    onChange={e => setData('motangan', e.target.value)}
                    rows={3}
                    className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none"
                    placeholder="Tóm tắt nội dung chính bài viết..."
                  />
               </div>

               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Nội dung bài viết</label>
                  <RichTextEditor
                    value={data.noidung}
                    onChange={(content) => setData('noidung', content)}
                    className={errors.noidung ? "border-red-500 ring-2 ring-red-500/20" : ""}
                  />
                  {errors.noidung && <p className="text-red-500 text-xs mt-1 italic">{errors.noidung}</p>}
               </div>
            </div>

            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm space-y-6">
               <h3 className="font-bold text-slate-900 flex items-center gap-2 border-b border-slate-50 pb-4">
                  <Search size={20} className="text-primary" />
                  Tối ưu tìm kiếm (SEO)
               </h3>
               
               <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">SEO Title</label>
                    <input 
                      type="text"
                      value={data.seotieude}
                      onChange={e => setData('seotieude', e.target.value)}
                      className="w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 px-4 text-xs font-bold focus:ring-2 focus:ring-primary/20 outline-none"
                    />
                  </div>
                  <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">SEO Slug (URL)</label>
                    <div className="flex items-center gap-2">
                      <input 
                        type="text"
                        value={data.slug}
                        onChange={handleManualSlugChange}
                        className="flex-1 w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 px-4 text-xs font-mono font-bold focus:ring-2 focus:ring-primary/20 outline-none"
                      />
                      <button
                        type="button"
                        onClick={refreshSlug}
                        className="p-2.5 bg-slate-100 text-slate-500 hover:text-primary hover:bg-slate-200 rounded-xl transition-all"
                        title="Tạo lại slug từ tiêu đề"
                      >
                        <RefreshCw size={16} />
                      </button>
                    </div>
                  </div>
               </div>
            </div>
          </div>

          {/* Sidebar */}
          <div className="lg:col-span-1 space-y-6">
            <div className="bg-white p-6 rounded-[28px] border border-slate-200 shadow-sm sticky top-24">
               <div className="space-y-6">
                  <div>
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Danh mục</label>
                    <select 
                      value={data.id_danhmuc}
                      onChange={e => setData('id_danhmuc', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium",
                        errors.id_danhmuc && "border-red-500"
                      )}
                      style={{ color: '#000', backgroundColor: '#fff' }}
                    >
                      <option value="" style={{ color: '#000', backgroundColor: '#fff' }}>Chọn danh mục</option>
                      {categories.map(cat => (
                        <option key={cat.id} value={cat.id} style={{ color: '#000', backgroundColor: '#fff' }}>{cat.tendm}</option>
                      ))}
                    </select>
                    {errors.id_danhmuc && <p className="text-red-500 text-[10px] mt-1 italic font-bold">{errors.id_danhmuc}</p>}
                  </div>

                  <div>
                    <label className="block text-xs font-bold mb-3 text-slate-500 uppercase tracking-widest">Trạng thái</label>
                    <div className="flex items-center gap-2 p-1.5 bg-slate-100 rounded-2xl">
                       <button 
                        type="button"
                        onClick={() => setData('anhien', 1)}
                        className={cn(
                          "flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-xl transition-all font-bold text-[10px] uppercase tracking-widest",
                          data.anhien === 1 ? "bg-white text-emerald-600 shadow-sm" : "text-slate-400 hover:text-slate-600"
                        )}
                       >
                         <Eye size={14} /> Hiện
                       </button>
                       <button 
                        type="button"
                        onClick={() => setData('anhien', 0)}
                        className={cn(
                          "flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-xl transition-all font-bold text-[10px] uppercase tracking-widest",
                          data.anhien === 0 ? "bg-white text-red-500 shadow-sm" : "text-slate-400 hover:text-slate-600"
                        )}
                       >
                         <EyeOff size={14} /> Ẩn
                       </button>
                    </div>
                  </div>

                  <div className="pt-2">
                    <label className="block text-xs font-bold mb-3 text-slate-500 uppercase tracking-widest">Ảnh đại diện</label>
                    <div className="relative group">
                       <div className={cn(
                         "w-full aspect-video rounded-2xl border-2 border-dashed flex flex-col items-center justify-center overflow-hidden transition-all",
                         preview ? "border-solid border-slate-200" : "border-slate-200 bg-slate-50 group-hover:bg-slate-100 group-hover:border-primary/30"
                       )}>
                          {preview ? (
                            <img src={preview} className="w-full h-full object-cover" />
                          ) : (
                            <div className="flex flex-col items-center text-slate-400">
                               <Upload size={24} className="mb-2" />
                               <span className="text-[10px] font-bold uppercase tracking-wider">Chọn ảnh</span>
                            </div>
                          )}
                          <input 
                            type="file"
                            onChange={handleImageChange}
                            className="absolute inset-0 opacity-0 cursor-pointer"
                            accept="image/png, image/jpeg, image/webp, image/avif"
                          />
                       </div>
                    </div>
                  </div>
               </div>

               <div className="mt-8 flex flex-col gap-3 pt-6 border-t border-slate-50">
                  <button
                    type="submit"
                    disabled={processing}
                    className="w-full flex items-center justify-center gap-2 py-3.5 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 active:scale-95 disabled:opacity-50"
                  >
                    <Save size={18} />
                    {processing ? 'Đang lưu...' : 'Đăng bài viết'}
                  </button>
                  <Link 
                    href={route('baiviet.index')}
                    className="w-full flex items-center justify-center py-3.5 bg-white border border-slate-200 text-slate-500 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all active:scale-95"
                  >
                    Hủy bỏ
                  </Link>
               </div>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
