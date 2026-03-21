import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  Layers, 
  AlertCircle
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface CakeType {
  id: number;
  tenLoaiBanh: string;
}

interface Props {
  cakeType: CakeType;
}

export default function EditCakeType({ cakeType }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    tenLoaiBanh: cakeType.tenLoaiBanh,
    _method: 'PUT',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('loaibanh.update', cakeType.id));
  };

  return (
    <AdminLayout>
      <Head title={`Sửa loại bánh: ${cakeType.tenLoaiBanh}`} />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('loaibanh.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Chỉnh sửa loại bánh</h1>
            <p className="text-slate-500 text-sm mt-1 font-medium">
               Cập nhật thông tin loại bánh ID: <span className="text-primary font-black">#{cakeType.id}</span>
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-2xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-8">
           <div className="space-y-4">
              <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                 <Layers size={14} /> Tên loại bánh
              </label>
              <div className="relative">
                <input 
                  type="text"
                  value={data.tenLoaiBanh}
                  onChange={e => setData('tenLoaiBanh', e.target.value)}
                  className={cn(
                    "w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 text-lg font-black focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-slate-300",
                    errors.tenLoaiBanh && "border-red-500 bg-red-50/10"
                  )}
                  autoFocus
                />
                {errors.tenLoaiBanh && (
                  <div className="absolute right-4 top-1/2 -translate-y-1/2 text-red-500">
                    <AlertCircle size={20} />
                  </div>
                )}
              </div>
              {errors.tenLoaiBanh && <p className="text-red-500 text-xs mt-1 italic font-bold ml-2">{errors.tenLoaiBanh}</p>}
           </div>

           <div className="pt-4 border-t border-slate-50 flex items-center gap-3">
              <button
                type="submit"
                disabled={processing}
                className="flex-1 flex items-center justify-center gap-2 py-4 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 active:scale-95 disabled:opacity-50"
              >
                <Save size={18} />
                {processing ? 'Đang lưu...' : 'Cập nhật dữ liệu'}
              </button>
              <Link 
                href={route('loaibanh.index')}
                className="px-8 py-4 bg-slate-50 text-slate-500 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-slate-100 transition-all active:scale-95"
              >
                Quay lại
              </Link>
           </div>
        </form>
      </div>
    </AdminLayout>
  );
}
