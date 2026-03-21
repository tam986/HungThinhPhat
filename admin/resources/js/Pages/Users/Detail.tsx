import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Edit, 
  Mail, 
  Phone, 
  MapPin, 
  Shield, 
  User as UserIcon,
  Calendar,
  UserCheck,
  IdCard,
  Hash
} from 'lucide-react';
import { cn } from '@/lib/utils';
import MetricCard from '@/Components/MetricCard';

interface User {
  id: number;
  hoten: string;
  email: string;
  sodienthoai: string | null;
  diachi: string | null;
  gioitinh: number;
  quyen: number;
  hinh_url: string | null;
  created_at: string;
}

interface Props {
  user: User;
}

export default function UserDetail({ user }: Props) {
  return (
    <AdminLayout>
      <Head title={`Chi tiết: ${user.hoten}`} />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('user.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={20} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Hồ sơ ngưĐi dĐăng</h1>
            <p className="text-slate-500 text-sm mt-1">
              Thàng tin chi tiết vĐ? phần quyĐn tại khoản ngưĐi dĐăng.
            </p>
          </div>
        </div>
        <Link 
          href={route('user.edit', user.id)}
          className="flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-500 text-slate-900 rounded-xl font-bold text-sm hover:bg-amber-600 transition-all shadow-lg shadow-amber-200"
        >
          <Edit size={18} />
          Chỉnh sửa tại khoản
        </Link>
      </div>

      <div className="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        {/* Left: Identity Card */}
        <div className="lg:col-span-1 space-y-6">
          <div className="bg-white p-8 rounded-[36px] border border-slate-200 shadow-sm text-center">
            <div className="relative inline-block">
              <div className="w-32 h-32 rounded-[32px] border-4 border-slate-50 bg-slate-100 overflow-hidden shadow-xl mx-auto">
                {user.hinh_url ? (
                  <img src={user.hinh_url} className="w-full h-full object-cover" />
                ) : (
                  <div className="w-full h-full flex items-center justify-center text-slate-300">
                    <UserIcon size={48} strokeWidth={1.5} />
                  </div>
                )}
              </div>
              <div className={cn(
                "absolute -bottom-1 -right-1 w-9 h-9 rounded-2xl flex items-center justify-center shadow-lg ring-4 ring-white",
                user.quyen === 1 ? "bg-amber-500 text-slate-900" : "bg-emerald-500 text-slate-900"
              )}>
                <Shield size={18} />
              </div>
            </div>

            <div className="mt-6 space-y-1">
              <h2 className="text-2xl font-bold text-slate-900 uppercase tracking-tight">{user.hoten}</h2>
              <div className="flex items-center justify-center gap-2">
                 <span className={cn(
                    "text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider",
                    user.quyen === 1 ? "bg-amber-50 text-amber-600" : "bg-emerald-50 text-emerald-600"
                 )}>
                   {user.quyen === 1 ? 'ADMIN' : 'CUSTOMER'}
                 </span>
                 <span className="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 uppercase tracking-wider font-mono">
                   ID #{user.id}
                 </span>
              </div>
            </div>

            <div className="mt-8 pt-8 border-t border-slate-50 flex items-center justify-center gap-8">
               <div className="text-center">
                  <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Giới tiềnh</p>
                  <p className="font-bold text-slate-700">{user.gioitinh === 1 ? 'Nam' : user.gioitinh === 0 ? 'Nữ' : 'Khác'}</p>
               </div>
               <div className="w-px h-8 bg-slate-100"></div>
               <div className="text-center">
                  <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ngày tham gia</p>
                  <p className="font-bold text-slate-700">{new Date(user.created_at).toLocaleDateString('vi-VN')}</p>
               </div>
            </div>
          </div>

          <div className="bg-slate-900 p-8 rounded-[36px] text-slate-900 shadow-xl shadow-slate-200">
             <div className="flex items-center gap-3 mb-6">
                <div className="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                   <IdCard size={20} className="text-primary" />
                </div>
                <h3 className="font-bold text-lg">Thàng tin định danh</h3>
             </div>
             <div className="space-y-4">
                <div className="flex flex-col gap-1">
                   <span className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Email đăng nhập</span>
                   <span className="font-semibold text-sm truncate">{user.email}</span>
                </div>
                <div className="flex flex-col gap-1">
                   <span className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Số điện thoại</span>
                   <span className="font-semibold text-sm">{user.sodienthoai || 'Chưa cập nhật'}</span>
                </div>
             </div>
          </div>
        </div>

        {/* Right: Detailed Table/Info */}
        <div className="lg:col-span-2 space-y-6">
          <div className="bg-white p-8 rounded-[36px] border border-slate-200 shadow-sm text-dark h-full">
            <h2 className="text-xl font-bold flex items-center gap-2 mb-8 border-b border-slate-50 pb-4">
              <Hash size={24} className="text-primary" />
              Chi tiết tại khoản
            </h2>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
               <div className="space-y-6">
                  <div className="flex items-start gap-4 p-4 rounded-2xl border border-slate-50 bg-slate-50/30">
                     <div className="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary flex-shrink-0">
                        <Mail size={18} />
                     </div>
                     <div>
                        <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hộp thư điện tử</p>
                        <p className="font-bold text-slate-900 mt-0.5">{user.email}</p>
                     </div>
                  </div>

                  <div className="flex items-start gap-4 p-4 rounded-2xl border border-slate-50 bg-slate-50/30">
                     <div className="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary flex-shrink-0">
                        <Phone size={18} />
                     </div>
                     <div>
                        <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hotline cĐ? nhận</p>
                        <p className="font-bold text-slate-900 mt-0.5">{user.sodienthoai || '---'}</p>
                     </div>
                  </div>
               </div>

               <div className="space-y-6">
                  <div className="flex items-start gap-4 p-4 rounded-2xl border border-slate-50 bg-slate-50/30">
                     <div className="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary flex-shrink-0">
                        <MapPin size={18} />
                     </div>
                     <div>
                        <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Địa chỉ đăng kĐ?</p>
                        <p className="font-bold text-slate-900 mt-0.5 leading-relaxed">{user.diachi || 'Trống'}</p>
                     </div>
                  </div>

                  <div className="flex items-start gap-4 p-4 rounded-2xl border border-slate-50 bg-slate-50/30">
                     <div className="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary flex-shrink-0">
                        <UserCheck size={18} />
                     </div>
                     <div>
                        <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tênh trạng xác thực</p>
                        <p className="font-bold text-emerald-500 mt-0.5">???? kịch hoạt</p>
                     </div>
                  </div>
               </div>
            </div>

            <div className="mt-12 p-8 rounded-[28px] bg-indigo-50/50 border border-indigo-100 border-dashed">
               <h4 className="font-bold text-indigo-900 flex items-center gap-2 mb-4">
                  <Calendar size={18} />
                  Nhật kĐ? tham gia hệ thống
               </h4>
               <div className="text-sm text-indigo-700/80 font-medium leading-relaxed italic">
                  NgưĐi dĐăng này đĐ? trở thình một phần của hệ thống HungThinhFood từ ngày {new Date(user.created_at).toLocaleDateString('vi-VN')}.
                  Hiện đang nắm giữ vai trĐ? <span className="font-bold text-indigo-900 underline">{user.quyen === 1 ? 'Quản trị viên' : 'Khách hàng'}</span>.
               </div>
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
