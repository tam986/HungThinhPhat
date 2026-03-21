import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  Ticket, 
  Coins, 
  Layers, 
  Calendar, 
  Clock, 
  AlertCircle,
  Hash,
  Activity
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface Props {
  now: string;
}

export default function CreateCoupon({ now }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    magiamgia: '',
    hesogiamgia: '',
    sotientoithieu: '',
    soluong: '',
    thoidiembatdau: now,
    thoidiemketthuc: '',
    trangthai: 0, // 0: Active, 1: Inactive/Expired based on legacy logic
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('magiamgia.store'));
  };

  return (
    <AdminLayout>
      <Head title="Tạo mã giảm giá mới" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('magiamgia.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thêm mã giảm giá mới</h1>
            <p className="text-slate-500 text-sm mt-1">
               Thiết lập các điều kiện về giá trị ưu đãi cho khách hàng.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-4xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="md:col-span-2 space-y-6">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-6">
               <div className="space-y-4 border-b border-slate-50 pb-6">
                  <h3 className="font-bold text-slate-900 flex items-center gap-2">
                     <Ticket size={20} className="text-primary" />
                     Định danh mã
                  </h3>
                  <div className="relative group">
                    <input 
                      type="text"
                      value={data.magiamgia}
                      onChange={e => setData('magiamgia', e.target.value.toUpperCase())}
                      className={cn(
                        "w-full bg-slate-50 border border-slate-100 rounded-3xl py-4 px-6 text-2xl font-black text-center tracking-[0.2em] focus:ring-4 focus:ring-primary/10 transition-all outline-none italic placeholder:font-medium placeholder:tracking-normal placeholder:text-slate-300",
                        errors.magiamgia && "border-red-500"
                      )}
                      placeholder="VD: GIAMGIA50"
                    />
                    <div className="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none group-focus-within:text-primary transition-colors">
                       <Hash size={24} />
                    </div>
                    {errors.magiamgia && <p className="text-red-500 text-[10px] mt-2 italic font-bold text-center">{errors.magiamgia}</p>}
                  </div>
               </div>

               <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                       <Coins size={14} /> Hệ số giảm (%)
                    </label>
                    <input 
                      type="number"
                      value={data.hesogiamgia}
                      onChange={e => setData('hesogiamgia', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none",
                        errors.hesogiamgia && "border-red-500"
                      )}
                      placeholder="VD: 10"
                    />
                  </div>
                  <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                       <Activity size={14} /> Số lượng mã
                    </label>
                    <input 
                      type="number"
                      value={data.soluong}
                      onChange={e => setData('soluong', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none",
                        errors.soluong && "border-red-500"
                      )}
                      placeholder="VD: 100"
                    />
                  </div>
               </div>

               <div className="space-y-2">
                  <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                     <Layers size={14} /> Đơn hàng tối thiểu (VNĐ)
                  </label>
                  <input 
                    type="number"
                    value={data.sotientoithieu}
                    onChange={e => setData('sotientoithieu', e.target.value)}
                    className={cn(
                      "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none",
                      errors.sotientoithieu && "border-red-500"
                    )}
                    placeholder="VD: 200000"
                  />
               </div>
            </div>

            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-6">
               <h3 className="font-bold text-slate-900 flex items-center gap-2 border-b border-slate-50 pb-4">
                  <Calendar size={20} className="text-primary" />
                  Thời gian áp dụng
               </h3>
               
               <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                       Bắt đầu
                    </label>
                    <input 
                      type="datetime-local"
                      value={data.thoidiembatdau}
                      min={now}
                      onChange={e => setData('thoidiembatdau', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none",
                        errors.thoidiembatdau && "border-red-500"
                      )}
                    />
                  </div>
                  <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                       Kết thúc
                    </label>
                    <input 
                      type="datetime-local"
                      value={data.thoidiemketthuc}
                      min={data.thoidiembatdau}
                      onChange={e => setData('thoidiemketthuc', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none",
                        errors.thoidiemketthuc && "border-red-500"
                      )}
                    />
                  </div>
               </div>
               {errors.thoidiemketthuc && <p className="text-red-500 text-[10px] mt-1 italic font-bold">{errors.thoidiemketthuc}</p>}
            </div>
          </div>

          <div className="md:col-span-1 space-y-6">
            <div className="bg-white p-6 rounded-[28px] border border-slate-200 shadow-sm text-dark sticky top-24">
               <div className="space-y-6">
                  <div>
                    <label className="block text-xs font-bold mb-4 text-slate-500 uppercase tracking-widest">Trạng thái mã</label>
                    <div className="space-y-3">
                       <label className={cn(
                         "flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer group",
                         data.trangthai === 0 ? "bg-emerald-50 border-emerald-500" : "bg-slate-50/50 border-slate-100 hover:border-emerald-200"
                       )}>
                          <input 
                            type="radio" 
                            name="trangthai" 
                            value="0" 
                            className="hidden" 
                            checked={data.trangthai === 0}
                            onChange={() => setData('trangthai', 0)}
                          />
                          <div className={cn(
                            "w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all",
                            data.trangthai === 0 ? "border-emerald-500 bg-emerald-500" : "border-slate-300 bg-white"
                          )}>
                             {data.trangthai === 0 && <div className="w-1.5 h-1.5 rounded-full bg-white"></div>}
                          </div>
                          <span className={cn(
                            "text-xs font-black uppercase tracking-widest",
                            data.trangthai === 0 ? "text-emerald-700" : "text-slate-400"
                          )}>Kích hoạt</span>
                       </label>

                       <label className={cn(
                         "flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer group",
                         data.trangthai === 1 ? "bg-red-50 border-red-500" : "bg-slate-50/50 border-slate-100 hover:border-red-200"
                       )}>
                          <input 
                            type="radio" 
                            name="trangthai" 
                            value="1" 
                            className="hidden" 
                            checked={data.trangthai === 1}
                            onChange={() => setData('trangthai', 1)}
                          />
                          <div className={cn(
                            "w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all",
                            data.trangthai === 1 ? "border-red-500 bg-red-500" : "border-slate-300 bg-white"
                          )}>
                             {data.trangthai === 1 && <div className="w-1.5 h-1.5 rounded-full bg-white"></div>}
                          </div>
                          <span className={cn(
                            "text-xs font-black uppercase tracking-widest",
                            data.trangthai === 1 ? "text-red-700" : "text-slate-400"
                          )}>Vô hiệu hóa</span>
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
                       {processing ? 'Đang lưu...' : 'Lưu mã giảm giá'}
                     </button>
                     <Link 
                       href={route('magiamgia.index')}
                       className="w-full flex items-center justify-center py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95"
                     >
                       Hủy bỏ
                     </Link>
                  </div>
               </div>

               <div className="mt-8 p-5 bg-primary/5 rounded-[22px] border border-primary/10 flex items-start gap-3">
                  <AlertCircle size={18} className="text-primary mt-0.5 shrink-0" />
                    Mã sẽ được tự động kích hoạt vào thời điểm bắt đầu bạn đã thiết lập.
               </div>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
