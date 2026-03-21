import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  FileText,
  Settings,
  Layers
} from 'lucide-react';

interface Product {
  id: number;
  tensp: string;
  id_danhmuc: number;
  id_nhacungcap: number;
  img: string | null;
  mota: string | null;
  anhien: boolean | number;
  is_featured: boolean | number;
  is_new: boolean | number;
}

interface Props {
  sanpham: Product;
  danhmucs: Array<{ id: number; tendanhmuc: string }>;
  nhacungcaps: Array<{ id: number; tennhacungcap: string }>;
}

export default function Edit({ sanpham, danhmucs, nhacungcaps }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    _method: 'PUT',
    tensp: sanpham.tensp,
    id_danhmuc: sanpham.id_danhmuc.toString(),
    id_nhacungcap: sanpham.id_nhacungcap.toString(),
    mota: sanpham.mota || '',
    anhien: Boolean(sanpham.anhien),
    is_featured: Boolean(sanpham.is_featured),
    is_new: Boolean(sanpham.is_new),
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('sanpham.update', sanpham.id));
  };

  return (
    <AdminLayout>
      <Head title={`Sửa: ${sanpham.tensp}`} />

      <div className="flex items-center justify-between mb-8">
        <div className="flex items-center gap-3">
            <Link 
            href={route('sanpham.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary hover:border-primary transition-all shadow-sm"
            >
            <ArrowLeft size={18} />
            </Link>
            <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900">Sửa sản phẩm</h1>
            <p className="text-slate-500 text-sm mt-1">
                Cập nhật thông tin cơ bản cho <span className="font-semibold">{sanpham.tensp}</span>.
            </p>
            </div>
        </div>
        <Link 
            href={route('sanpham.detail', sanpham.id)}
            className="flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary border border-primary/20 rounded-xl font-bold text-sm hover:bg-primary/20 transition-all"
        >
            <Layers size={16} />
            Quản lý biến thể & Hình ảnh
        </Link>
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
                      {danhmucs.map(dm => <option key={dm.id} value={dm.id}>{dm.tendanhmuc}</option>)}
                    </select>
                  </div>
                  <div>
                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block">Nhà cung cấp</label>
                    <select 
                      value={data.id_nhacungcap}
                      onChange={e => setData('id_nhacungcap', e.target.value)}
                      className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium"
                      required
                    >
                      {nhacungcaps.map(ncc => <option key={ncc.id} value={ncc.id}>{ncc.tennhacungcap}</option>)}
                    </select>
                  </div>
                </div>

                <div>
                  <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 block">Mô tả sản phẩm</label>
                  <textarea 
                    value={data.mota}
                    onChange={e => setData('mota', e.target.value)}
                    rows={6}
                    className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-medium resize-none"
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
              <Save size={24} className="group-hover:scale-110 transition-transform" />
              {processing ? 'Đang cập nhật...' : 'Lưu thay đổi'}
            </button>
          </div>
        </div>
      </form>
    </AdminLayout>
  );
}
