import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  Scale, 
  AlertCircle
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function CreateWeight() {
  const { data, setData, post, processing, errors } = useForm({
    khoiluong: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('khoiluong.store'));
  };

  return (
    <AdminLayout>
      <Head title="Thêm khôi lượng mới" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('khoiluong.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thêm khối lượng</h1>
            <p className="text-slate-500 text-sm mt-1 font-medium">
               Thiết lập thông số khối lượng mới cho sản phẩm.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-2xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-8">
           <div className="space-y-4">
              <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                 <Scale size={14} /> Giá trị khối lượng
              </label>
              <div className="relative">
                <input 
                  type="text"
                  value={data.khoiluong}
                  onChange={e => setData('khoiluong', e.target.value)}
                  className={cn(
                    "w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 text-lg font-black focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-slate-300",
                    errors.khoiluong && "border-red-500 bg-red-50/10"
                  )}
                  placeholder="VD: 500g, 1kg, 20cm..."
                  autoFocus
                />
                {errors.khoiluong && (
                  <div className="absolute right-4 top-1/2 -translate-y-1/2 text-red-500">
                    <AlertCircle size={20} />
                  </div>
                )}
              </div>
              {errors.khoiluong && <p className="text-red-500 text-xs mt-1 italic font-bold ml-2">{errors.khoiluong}</p>}
           </div>

           <div className="pt-4 border-t border-slate-50 flex items-center gap-3">
              <button
                type="submit"
                disabled={processing}
                className="flex-1 flex items-center justify-center gap-2 py-4 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 active:scale-95 disabled:opacity-50"
              >
                <Save size={18} />
                {processing ? 'Đang lưu...' : 'Lưu thống số'}
              </button>
              <Link 
                href={route('khoiluong.index')}
                className="px-8 py-4 bg-slate-50 text-slate-500 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-slate-100 transition-all active:scale-95"
              >
                Hủy
              </Link>
           </div>
        </form>
      </div>
    </AdminLayout>
  );
}
