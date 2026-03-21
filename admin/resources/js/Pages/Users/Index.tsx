import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, router } from '@inertiajs/react';
import { 
  Users, 
  UserPlus, 
  Search, 
  MoreVertical, 
  Edit, 
  Trash2, 
  Eye,
  Shield,
  User as UserIcon,
  ChevronLeft,
  ChevronRight,
  Mail,
  Phone,
  MapPin
} from 'lucide-react';
import MetricCard from '@/Components/MetricCard';
import StatusBadge from '@/Components/StatusBadge';
import { cn } from '@/lib/utils';

interface User {
  id: number;
  hoten: string;
  email: string;
  sodienthoai: string | null;
  quyen: number;
  hinh_url: string | null;
}

interface Props {
  users: {
    data: User[];
    current_page: number;
    last_page: number;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
  };
  filters: {
    search?: string;
    sort?: string;
    role?: string;
  };
}

export default function UserIndex({ users, filters }: Props) {
  const [search, setSearch] = useState(filters.search || '');

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    router.get(route('user.index'), { ...filters, search }, { preserveState: true });
  };

  const handleFilterChange = (name: string, value: string) => {
    router.get(route('user.index'), { ...filters, [name]: value }, { preserveState: true });
  };

  const updateRole = (id: number, quyen: number) => {
    router.put(route('user.updateRole', id), { quyen }, {
      preserveScroll: true,
      onSuccess: () => {},
    });
  };

  return (
    <AdminLayout>
      <Head title="Quản lý người dạng" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark font-display">Tài khoản & Phân quyền</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
            Quản lý thông tin người dạng về quyền truy cấp hệ thống.
          </p>
        </div>
        <Link 
          href={route('user.create')}
          className="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <UserPlus size={18} />
          Thêm người dạng
        </Link>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <MetricCard title="Têng người dạng" value={users.total} icon={Users} variant="primary" />
        <MetricCard title="Quản tr? viễn" value={users.data.filter(u => u.quyen === 1).length} icon={Shield} variant="warning" />
        <MetricCard title="Khách hàng" value={users.data.filter(u => u.quyen === 0).length} icon={UserIcon} variant="success" />
      </div>

      <div className="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-dark mt-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div className="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/30">
          <div className="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.role || ''}
              onChange={(e) => handleFilterChange('role', e.target.value)}
            >
              <option value="">Tất c? vai tr?</option>
              <option value="1">Admin</option>
              <option value="0">Khách hàng</option>
            </select>

            <select 
              className="bg-white border border-slate-200 rounded-2xl py-2 px-3 text-sm font-semibold focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
              value={filters.sort || ''}
              onChange={(e) => handleFilterChange('sort', e.target.value)}
            >
              <option value="">Sắp xếp</option>
              <option value="latest">Mới nhất</option>
              <option value="az">Tên A-Z</option>
              <option value="za">Tên Z-A</option>
            </select>
          </div>

          <form onSubmit={handleSearch} className="relative w-full lg:w-80">
            <input 
              type="text" 
              placeholder="Tìm tơn hoặc email..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full bg-white border border-slate-200 rounded-2xl py-2.5 px-4 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all shadow-sm"
            />
            <button type="submit" className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 p-1.5 hover:text-primary transition-colors">
              <Search size={18} />
            </button>
          </form>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-sm text-left border-collapse">
            <thead className="bg-slate-50/50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Người dạng</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider">Liên h?</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Vai tr?</th>
                <th className="px-6 py-4 font-bold text-slate-800 uppercase text-[11px] tracking-wider text-center">Thao tức</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {users.data.map((user) => (
                <tr key={user.id} className="hover:bg-slate-50/80 transition-all group">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-4">
                      <div className="w-11 h-11 rounded-2xl bg-primary/10 border border-primary/5 p-0.5 shadow-sm group-hover:rotate-6 transition-transform">
                        {user.hinh_url ? (
                          <img src={user.hinh_url} className="w-full h-full object-cover rounded-[14px]" />
                        ) : (
                          <div className="w-full h-full flex items-center justify-center text-primary">
                            <UserIcon size={20} strokeWidth={2.5} />
                          </div>
                        )}
                      </div>
                      <div className="flex flex-col">
                        <span className="font-bold text-slate-900 leading-tight">{user.hoten}</span>
                        <span className="text-[11px] font-mono text-slate-400 mt-0.5">ID: #{user.id}</span>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="space-y-1.5">
                      <div className="flex items-center gap-2 text-slate-600 font-medium">
                        <Mail size={14} className="text-slate-400" />
                        {user.email}
                      </div>
                      {user.sodienthoai && (
                        <div className="flex items-center gap-2 text-slate-600 font-medium text-xs">
                          <Phone size={14} className="text-slate-400" />
                          {user.sodienthoai}
                        </div>
                      )}
                    </div>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <select 
                       value={user.quyen}
                       onChange={(e) => updateRole(user.id, parseInt(e.target.value))}
                       className={cn(
                        "text-xs font-bold px-3 py-1.5 rounded-xl border-none ring-1 transition-all cursor-pointer outline-none",
                        user.quyen === 1 
                          ? "bg-amber-50 text-amber-600 ring-amber-100 focus:ring-amber-300" 
                          : "bg-emerald-50 text-emerald-600 ring-emerald-100 focus:ring-emerald-300"
                       )}
                    >
                      <option value={1}>ADMIN</option>
                      <option value={0}>CUSTOMER</option>
                    </select>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-center gap-1.5 opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                      <Link 
                        href={route('user.detail', user.id)}
                        className="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-xl transition-all"
                        title="Chi tiết"
                      >
                        <Eye size={18} />
                      </Link>
                      <Link 
                        href={route('user.edit', user.id)}
                        className="p-2 text-slate-400 hover:text-amber-500 hover:bg-slate-100 rounded-xl transition-all"
                        title="Chỉnh sửa"
                      >
                        <Edit size={18} />
                      </Link>
                      <Link 
                        href={route('user.destroy', user.id)}
                        method="delete"
                        as="button"
                        onBefore={() => confirm('Bạn c? chắc chọn muốn xóa người dạng này?')}
                        className="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-100 rounded-xl transition-all"
                        title="Xóa"
                      >
                        <Trash2 size={18} />
                      </Link>
                    </div>
                  </td>
                </tr>
              ))}
              {users.data.length === 0 && (
                <tr>
                  <td colSpan={4} className="px-6 py-20 text-center">
                    <div className="flex flex-col items-center gap-3">
                      <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                        <Users size={32} />
                      </div>
                      <p className="text-slate-400 font-medium italic">Không tìm thấy người dạng nào.</p>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        <div className="px-8 py-5 border-t border-slate-100 bg-slate-50/20 flex items-center justify-between">
          <p className="text-xs text-slate-500 font-bold">
            HI?N TH? <span className="text-primary">{users.data.length}</span> / {users.total}
          </p>
          <div className="flex items-center gap-2">
            <Link 
              href={users.prev_page_url || '#'} 
              className={cn(
                "p-2.5 border border-slate-200 rounded-2xl transition-all shadow-sm",
                !users.prev_page_url ? "opacity-30 cursor-not-allowed bg-slate-50" : "bg-white text-slate-600 hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronLeft size={20} />
            </Link>
            <div className="px-4 text-sm font-bold text-slate-700">
              {users.current_page}
            </div>
            <Link 
              href={users.next_page_url || '#'} 
              className={cn(
                "p-2.5 border border-slate-200 rounded-2xl transition-all shadow-sm",
                !users.next_page_url ? "opacity-30 cursor-not-allowed bg-slate-50" : "bg-white text-slate-600 hover:text-primary hover:border-primary active:scale-90"
              )}
            >
               <ChevronRight size={20} />
            </Link>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
