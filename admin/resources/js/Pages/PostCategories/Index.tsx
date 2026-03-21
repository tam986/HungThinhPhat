import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  FolderTree, 
  Plus, 
  Search, 
  Edit, 
  Trash2, 
  LayoutGrid,
  Type
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface PostCategory {
  id: number;
  tendm: string;
  thutu: number | null;
  anhien: number | null;
}

interface Props {
  danhmucs: PostCategory[];
}

export default function PostCategoryIndex({ danhmucs }: Props) {
  return (
    <AdminLayout>
      <Head title="Quản lý danh mục bài viết" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Danh mục bài viết</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Phân loại nội dung tin tức về blog của bạn.
          </p>
        </div>
        <Link 
          href={route('danhmuc.create')}
          className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <Plus size={18} />
          Thêm danh mục
        </Link>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <MetricCard title="Tổng danh mục" value={danhmucs.length} icon={FolderTree} variant="primary" />
        <MetricCard title="Đang hiện thị" value={danhmucs.filter(d => d.anhien === 1).length} icon={LayoutGrid} variant="success" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/10">
          <div className="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
             <Type size={16} className="text-primary" />
             Phân loại nội dung
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider w-20 text-center">Thứ tự</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Tên danh mục</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center w-32">Trạng thái</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center w-32">Hành động</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {danhmucs.map((dm) => (
                <tr key={dm.id} className="hover:bg-slate-50/80 transition-all group border-b border-slate-50 last:border-0">
                  <td className="px-6 py-5 text-center">
                    <span className="font-mono font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded text-[10px]">{dm.thutu || 0}</span>
                  </td>
                  <td className="px-6 py-5">
                    <div className="flex flex-col">
                       <span className="font-black text-slate-900 group-hover:text-primary transition-colors text-base">{dm.tendm}</span>
                       <span className="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID: #{dm.id}</span>
                    </div>
                  </td>
                  <td className="px-6 py-5 text-center">
                    <StatusBadge 
                      status={dm.anhien === 1 ? 'active' : 'inactive'} 
                      labels={{ active: 'Hiện', inactive: 'Ẩn' }} 
                    />
                  </td>
                  <td className="px-6 py-5">
                    <div className="flex items-center justify-center gap-2">
                       <Link 
                        href={route('danhmuc.edit', dm.id)}
                        className="p-2.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-2xl transition-all shadow-sm bg-white border border-slate-100"
                       >
                        <Edit size={18} />
                      </Link>
                      <Link 
                        href={route('danhmuc.destroy', dm.id)}
                        method="delete"
                        as="button"
                        onBefore={() => confirm('Xóa danh mục này?')}
                        className="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all shadow-sm bg-white border border-slate-100"
                      >
                        <Trash2 size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {danhmucs.length === 0 && (
                <tr>
                  <td colSpan={4} className="px-6 py-20 text-center">
                    <div className="flex flex-col items-center gap-3">
                      <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                        <FolderTree size={32} />
                      </div>
                      <p className="text-slate-400 font-medium italic text-sm">Chưa c? danh mục nào ??ác tạo.</p>
                      <Link 
                        href={route('danhmuc.create')}
                        className="text-primary font-bold text-xs uppercase tracking-widest hover:underline"
                      >
                        Tạo danh mục Đãu tiền
                      </Link>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  );
}
