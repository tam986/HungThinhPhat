import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  ArrowLeft, 
  Save, 
  User as UserIcon,
  Mail,
  Phone,
  MapPin,
  Shield,
  Upload,
  UserCheck,
  IdCard,
  Camera
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface User {
  id: number;
  hoten: string;
  email: string;
  sodienthoai: string | null;
  diachi: string | null;
  gioitinh: number;
  quyen: number;
  hinh: string | null;
  hinh_url: string | null;
}

interface Props {
  user: User;
}

export default function EditUser({ user }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    hoten: user.hoten,
    email: user.email,
    sodienthoai: user.sodienthoai || '',
    diachi: user.diachi || '',
    gioitinh: user.gioitinh,
    quyen: user.quyen,
    hinh: null as File | null,
    _method: 'PUT',
  });

  const [preview, setPreview] = React.useState<string | null>(user.hinh_url);

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('hinh', file);
      setPreview(URL.createObjectURL(file));
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('user.update', user.id), {
      forceFormData: true,
    });
  };

  return (
    <AdminLayout>
      <Head title={`Sửa: ${user.hoten}`} />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('user.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Chỉnh sửa tại khoản</h1>
            <p className="text-slate-500 text-sm mt-1">
              ID: <span className="font-mono text-primary">#{user.id}</span> • Cập nhật thàng tin định danh ngưĐi dĐăng.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-5xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Left: Avatar */}
          <div className="lg:col-span-1">
             <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-center sticky top-24">
              <div className="relative inline-block mx-auto">
                <div className="w-44 h-44 rounded-[44px] border-4 border-slate-100 bg-white overflow-hidden shadow-2xl group ring-1 ring-slate-100">
                  {preview ? (
                    <img src={preview} className="w-full h-full object-cover" />
                  ) : (
                    <div className="w-full h-full flex items-center justify-center text-slate-200">
                      <UserIcon size={72} strokeWidth={1} />
                    </div>
                  )}
                  <input 
                    type="file" 
                    onChange={handleImageChange}
                    className="absolute inset-0 opacity-0 cursor-pointer"
                    accept="image/png, image/jpeg, image/webp, image/avif"
                  />
                  <div className="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-slate-900 pointer-events-none">
                    <Camera size={32} />
                  </div>
                </div>
                <div className="absolute -bottom-2 -right-2 w-12 h-12 bg-white text-primary rounded-2xl flex items-center justify-center shadow-lg pointer-events-none ring-4 ring-slate-50 border border-slate-100">
                  <Upload size={20} />
                </div>
              </div>
              
              <div className="mt-8 space-y-1">
                <h3 className="font-bold text-slate-900 text-lg leading-tight">{user.hoten}</h3>
                <p className="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{user.quyen === 1 ? 'Administrator' : 'Customer'}</p>
              </div>
              
              {errors.hinh && <p className="text-red-500 text-[11px] mt-4 font-bold bg-red-50 py-1 rounded-lg">{errors.hinh}</p>}
            </div>
          </div>

          {/* Right: Details */}
          <div className="lg:col-span-2 space-y-6">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-8">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                 <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">HĐ vĐ? tiền</label>
                    <div className="relative">
                      <input 
                        type="text"
                        value={data.hoten}
                        onChange={e => setData('hoten', e.target.value)}
                        className={cn(
                          "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 pl-11 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                          errors.hoten && "border-red-500"
                        )}
                      />
                      <UserIcon className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={16} />
                    </div>
                    {errors.hoten && <p className="text-red-500 text-[10px] font-bold mt-1 ml-1">{errors.hoten}</p>}
                 </div>

                 <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Email</label>
                    <div className="relative">
                      <input 
                        type="email"
                        value={data.email}
                        onChange={e => setData('email', e.target.value)}
                        className={cn(
                          "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 pl-11 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                          errors.email && "border-red-500"
                        )}
                      />
                      <Mail className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={16} />
                    </div>
                    {errors.email && <p className="text-red-500 text-[10px] font-bold mt-1 ml-1">{errors.email}</p>}
                 </div>

                 <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Số điện thoại</label>
                    <div className="relative">
                      <input 
                        type="text"
                        value={data.sodienthoai}
                        onChange={e => setData('sodienthoai', e.target.value)}
                        className={cn(
                          "w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 pl-11 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                          errors.sodienthoai && "border-red-500"
                        )}
                      />
                      <Phone className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={16} />
                    </div>
                 </div>

                 <div className="space-y-2">
                    <label className="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Vai trĐ? hệ thống</label>
                    <div className="relative">
                      <select 
                        value={data.quyen}
                        onChange={e => setData('quyen', parseInt(e.target.value))}
                        className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 pl-11 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none appearance-none"
                      >
                        <option value={0}>Khách hàng</option>
                        <option value={1}>Quản trị viên</option>
                      </select>
                      <Shield className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={16} />
                    </div>
                 </div>
              </div>

              <div className="space-y-2">
                <label className="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Địa chỉ thưĐng trĐ?</label>
                <div className="relative">
                  <textarea 
                    value={data.diachi}
                    onChange={e => setData('diachi', e.target.value)}
                    rows={3}
                    className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 pl-11 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none"
                  />
                  <MapPin className="absolute left-4 top-4 text-slate-400" size={16} />
                </div>
              </div>

              <div className="space-y-2 max-w-[200px]">
                <label className="text-[11px] font-bold text-slate-400 uppercase tracking-wider ml-1">Giới tiềnh</label>
                <div className="relative">
                  <select 
                    value={data.gioitinh}
                    onChange={e => setData('gioitinh', parseInt(e.target.value))}
                    className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-4 pl-11 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none appearance-none"
                  >
                    <option value={1}>Nam giới</option>
                    <option value={0}>Nữ giới</option>
                    <option value={2}>Khác</option>
                  </select>
                  <UserCheck className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={16} />
                </div>
              </div>
            </div>

            <div className="flex items-center justify-end gap-3 pt-2">
              <Link 
                href={route('user.index')}
                className="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all"
              >
                Hủy thay đổi
              </Link>
              <button
                type="submit"
                disabled={processing}
                className="flex items-center gap-2 px-10 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 disabled:opacity-50 active:scale-95"
              >
                <Save size={18} />
                {processing ? 'Đang cập nhật...' : 'Cập nhật tại khoản'}
              </button>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
