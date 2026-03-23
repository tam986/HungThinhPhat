import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Plus, 
  Trash2, 
  Edit, 
  Eye, 
  EyeOff,
  Image as ImageIcon,
  ExternalLink,
  GripVertical
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import { cn } from '@/lib/utils';

interface Banner {
  id: number;
  tieude: string | null;
  duongdan: string | null;
  thutu: number;
  anhien: number;
  hinhanh: string | null;
}

interface Props {
  banners: Banner[];
}

export default function BannerIndex({ banners }: Props) {
  return (
    <AdminLayout>
      <Head title="Banner" />

      {/* Header Section */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Quản lý Banner</h1>
          <p className="text-slate-500 text-sm mt-1">
            Quản lý các banner quảng cáo về khuyến mới trên website.
          </p>
        </div>
        <div className="flex items-center gap-2">
          <Link 
            href={route('banners.create')}
            className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
          >
            <Plus size={18} />
            Thêm Banner
          </Link>
        </div>
      </div>

      {/* Metric Cards Row */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <MetricCard title="Tổng số Banner" value={banners.length} icon={ImageIcon} />
        <MetricCard title="Đang hiển thị" value={banners.filter(b => b.anhien === 1).length} icon={Eye} />
        <MetricCard title="Đang ẩn" value={banners.filter(b => b.anhien === 0).length} icon={EyeOff} />
      </div>

      {/* Banner Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 animate-in fade-in zoom-in-95 duration-500">
        {banners.map((banner) => (
          <div key={banner.id} className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:border-primary/30 transition-all duration-300">
            <div className="relative aspect-[21/9] bg-slate-100 overflow-hidden">
               {banner.hinhanh ? (
                 <img 
                    src={banner.hinhanh} 
                    alt={banner.tieude || 'Banner'} 
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 />
               ) : (
                 <div className="w-full h-full flex items-center justify-center text-slate-300">
                   <ImageIcon size={48} />
                 </div>
               )}
               <div className="absolute top-3 right-3 flex gap-2">
                  <span className={cn(
                    "px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider backdrop-blur-md border",
                    banner.anhien === 1 
                      ? "bg-emerald-500/10 text-emerald-600 border-emerald-500/20" 
                      : "bg-slate-500/10 text-slate-500 border-slate-500/20"
                  )}>
                    {banner.anhien === 1 ? 'Hiện thị' : 'Đang ẩn'}
                  </span>
                  <span className="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider backdrop-blur-md bg-white/70 text-slate-700 border border-white/20">
                    Sắp xếp: {banner.thutu}
                  </span>
               </div>
            </div>
            
            <div className="p-5">
              <div className="flex items-start justify-between gap-4">
                <div className="flex-1 min-w-0">
                  <h3 className="font-semibold text-slate-900 truncate text-dark">
                    {banner.tieude || "Không có tiêu đề"}
                  </h3>
                  {banner.duongdan && (
                    <div className="flex items-center gap-1.5 mt-1 text-slate-500">
                      <ExternalLink size={14} className="flex-shrink-0" />
                      <span className="text-xs truncate">{banner.duongdan}</span>
                    </div>
                  )}
                </div>
              </div>

              <div className="flex items-center justify-between mt-6 pt-4 border-t border-slate-50">
                <div className="flex gap-2">
                   <Link 
                     href={banner.anhien === 1 ? route('banners.unactive', banner.id) : route('banners.active', banner.id)}
                     method="get"
                     className={cn(
                       "p-2 rounded-lg border border-slate-100 hover:bg-slate-50 transition-colors",
                       banner.anhien === 1 ? "text-slate-400 hover:text-slate-600" : "text-slate-400 hover:text-emerald-500"
                     )}
                   >
                     {banner.anhien === 1 ? <EyeOff size={18} /> : <Eye size={18} />}
                   </Link>
                   <Link 
                     href={route('banners.edit', banner.id)}
                     className="p-2 text-slate-400 hover:text-amber-600 hover:bg-slate-50 rounded-lg border border-slate-100 transition-colors"
                   >
                     <Edit size={18} />
                   </Link>
                </div>
                <Link 
                  href={route('banners.destroy', banner.id)} 
                  method="delete"
                  as="button"
                  onBefore={() => confirm('Bạn có chắc chắn muốn xóa banner này?')}
                  className="p-2 text-slate-400 hover:text-red-600 hover:bg-slate-50 rounded-lg border border-slate-100 transition-colors"
                >
                  <Trash2 size={18} />
                </Link>
              </div>
            </div>
          </div>
        ))}

        {banners.length === 0 && (
          <div className="col-span-full py-12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
             <ImageIcon size={48} className="mb-4 opacity-20" />
             <p className="font-medium">Chưa có banner nào</p>
             <Link href={route('banners.create')} className="text-primary hover:underline text-sm mt-1">Bấm để thêm ngay</Link>
          </div>
        )}
      </div>
    </AdminLayout>
  );
}
