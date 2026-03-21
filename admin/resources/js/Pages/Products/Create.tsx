import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  FileText,
  Settings,
  CheckCircle2
} from 'lucide-react';

interface Props {
  danhmucs: Array<{ id: number; tendanhmuc: string }>;
  nhacungcaps: Array<{ id: number; tennhacungcap: string }>;
}

export default function Create({ danhmucs, nhacungcaps }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    tensp: '',
    id_danhmuc: '',
    id_nhacungcap: '',
    mota: '',
    anhien: true,
    is_featured: false,
    is_new: true,
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('sanpham.store'));
  };

  return (
    <AdminLayout>
      <Head title="Thêm sản phẩm mới" />

      <div className="flex items-center gap-3 mb-8">
        <Link 
          href={route('sanpham.index')}
          className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary hover:border-primary transition-all shadow-sm"
        >
          <ArrowLeft size={18} />
        </Link>
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900">Thêm sản phẩm mới</h1>
          <p className="text-slate-500 text-sm mt-1">
            Bước 1: Điền thông tin cơ bản. Hình ảnh sẽ được thêm cho từng biến thể ở bước tiếp theo.
          </p>
        </div>
      </div>

      <form onSubmit={handleSubmit} className="max-w-4xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          {/* Left: Main Form */}
          <div className="md:col-span-2 space-y-6">
            <div className="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
              <h2 className="text-lg font-bold flex items-center gap-2 mb-2 text-slate-800">
                <FileText size={20} className="text-primary" />
                Thông tin cơ bản
              </h2>
              
              <div className="space-y-4">
                <div>
                  <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block">Tên sản phẩm</label>
                  <input 
                    type="text"
                    value={data.tensp}
                    onChange={e => setData('tensp', e.target.value)}
                    className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium"
                    placeholder="VD: Bánh pía sầu riêng truyền thống"
                    required
                  />
                  {errors.tensp && <p className="text-red-500 text-[10px] mt-1 font-bold">{errors.tensp}</p>}
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block">Danh mục</label>
                    <select 
                      value={data.id_danhmuc}
                      onChange={e => setData('id_danhmuc', e.target.value)}
                      className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium"
                      required
                    >
                      <option value="">Chọn danh mục</option>
                      {danhmucs.map(dm => <option key={dm.id} value={dm.id}>{dm.tendanhmuc}</option>)}
                    </select>
                    {errors.id_danhmuc && <p className="text-red-500 text-[10px] mt-1 font-bold">{errors.id_danhmuc}</p>}
                  </div>
                  <div>
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block">Nhà cung cấp</label>
                    <select 
                      value={data.id_nhacungcap}
                      onChange={e => setData('id_nhacungcap', e.target.value)}
                      className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium"
                      required
                    >
                      <option value="">Chọn nhà cung cấp</option>
                      {nhacungcaps.map(ncc => <option key={ncc.id} value={ncc.id}>{ncc.tennhacungcap}</option>)}
                    </select>
                    {errors.id_nhacungcap && <p className="text-red-500 text-[10px] mt-1 font-bold">{errors.id_nhacungcap}</p>}
                  </div>
                </div>

                <div>
                  <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block">Mô tả sản phẩm</label>
                  <textarea 
                    value={data.mota}
                    onChange={e => setData('mota', e.target.value)}
                    rows={6}
                    className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium resize-none"
                    placeholder="Mô tả tóm tắt về sản phẩm..."
                  />
                </div>
              </div>
            </div>
          </div>

          {/* Right: Settings */}
          <div className="space-y-6">
            <div className="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
              <h2 className="text-lg font-bold flex items-center gap-2 mb-2 text-slate-800">
                <Settings size={20} className="text-primary" />
                Cài đặt hiển thị
              </h2>
              
              <div className="space-y-4">
                <label className="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 cursor-pointer group hover:bg-white hover:border-primary/20 transition-all">
                  <div className="flex flex-col">
                    <span className="text-xs font-bold text-slate-700">Hiển thị sản phẩm</span>
                    <span className="text-[10px] text-slate-400">Cho phép người dùng thấy sản phẩm</span>
                  </div>
                  <input 
                    type="checkbox"
                    checked={data.anhien}
                    onChange={e => setData('anhien', e.target.checked)}
                    className="w-5 h-5 rounded-md border-slate-300 text-primary focus:ring-primary/20"
                  />
                </label>

                <label className="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 cursor-pointer group hover:bg-white hover:border-primary/20 transition-all">
                  <div className="flex flex-col">
                    <span className="text-xs font-bold text-slate-700">Sản phẩm nổi bật</span>
                    <span className="text-[10px] text-slate-400">Hiện tại trang chủ</span>
                  </div>
                  <input 
                    type="checkbox"
                    checked={data.is_featured}
                    onChange={e => setData('is_featured', e.target.checked)}
                    className="w-5 h-5 rounded-md border-slate-300 text-primary focus:ring-primary/20"
                  />
                </label>

                <label className="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 cursor-pointer group hover:bg-white hover:border-primary/20 transition-all">
                  <div className="flex flex-col">
                    <span className="text-xs font-bold text-slate-700">Gắn nhãn "Mới"</span>
                    <span className="text-[10px] text-slate-400">Sản phẩm vừa cập bến</span>
                  </div>
                  <input 
                    type="checkbox"
                    checked={data.is_new}
                    onChange={e => setData('is_new', e.target.checked)}
                    className="w-5 h-5 rounded-md border-slate-300 text-primary focus:ring-primary/20"
                  />
                </label>
              </div>
            </div>

            <button
              type="submit"
              disabled={processing}
              className="w-full flex items-center justify-center gap-2 py-4 bg-primary text-slate-900 rounded-3xl font-bold text-base hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 disabled:opacity-50 group mt-4"
            >
              <CheckCircle2 size={24} className="group-hover:scale-110 transition-transform" />
              {processing ? 'Đang khởi tạo...' : 'Tiếp tục bước 2'}
            </button>
          </div>
        </div>
      </form>
    </AdminLayout>
  );
}
