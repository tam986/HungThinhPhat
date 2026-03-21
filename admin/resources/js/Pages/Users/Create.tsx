import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { 
  UserPlus, 
  ArrowLeft, 
  Save, 
  User as UserIcon,
  Mail,
  Lock,
  Phone,
  MapPin,
  Shield,
  Upload,
  UserCheck
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function CreateUser() {
  const { data, setData, post, processing, errors } = useForm({
    hoten: '',
    email: '',
    password: '',
    sodienthoai: '',
    diachi: '',
    gioitinh: 1,
    quyen: 0,
    hinh: null as File | null,
  });

  const [preview, setPreview] = React.useState<string | null>(null);

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('hinh', file);
      setPreview(URL.createObjectURL(file));
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('user.store'), {
      forceFormData: true,
    });
  };

  return (
    <AdminLayout>
      <Head title="Thêm ngưĐi dĐăng mới" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div className="flex items-center gap-3">
          <Link 
            href={route('user.index')}
            className="p-2 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-primary transition-all shadow-sm"
          >
            <ArrowLeft size={18} />
          </Link>
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Thêm ngưĐi dĐăng mới</h1>
            <p className="text-slate-500 text-sm mt-1">
              Tạo tại khoản mới cho nhận viên hoặc khách hàng.
            </p>
          </div>
        </div>
      </div>

      <div className="mt-8 max-w-5xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Left: Avatar Upload */}
          <div className="lg:col-span-1">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-center sticky top-24">
              <div className="relative inline-block mx-auto">
                <div className="w-40 h-40 rounded-[40px] border-4 border-slate-50 bg-slate-100 overflow-hidden shadow-xl group">
                  {preview ? (
                    <img src={preview} className="w-full h-full object-cover" />
                  ) : (
                    <div className="w-full h-full flex items-center justify-center text-slate-300">
                      <UserIcon size={64} strokeWidth={1.5} />
                    </div>
                  )}
                  <input 
                    type="file" 
                    onChange={handleImageChange}
                    className="absolute inset-0 opacity-0 cursor-pointer"
                    accept="image/png, image/jpeg, image/webp, image/avif"
                  />
                  <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-slate-900 pointer-events-none">
                    <Upload size={24} />
                  </div>
                </div>
                <div className="absolute -bottom-2 -right-2 w-10 h-10 bg-primary text-slate-900 rounded-2xl flex items-center justify-center shadow-lg pointer-events-none ring-4 ring-white">
                  <Upload size={18} />
                </div>
              </div>
              
              <h3 className="mt-6 font-bold text-slate-900">Ảnh đại diện</h3>
              <p className="text-xs text-slate-400 mt-1 px-4 leading-relaxed font-medium">
                Ảnh đẹp sẽ giúp định danh tại khoản tốt hơn.
              </p>
              
              {errors.hinh && <p className="text-red-500 text-xs mt-3 font-bold">{errors.hinh}</p>}
            </div>
          </div>

          {/* Right: User Information */}
          <div className="lg:col-span-2 space-y-6">
            <div className="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm text-dark space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div>
                    <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                       <UserIcon size={16} className="text-primary" />
                       HĐ vĐ? tiền <span className="text-red-500">*</span>
                    </label>
                    <input 
                      type="text"
                      value={data.hoten}
                      onChange={e => setData('hoten', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                        errors.hoten && "border-red-500 ring-red-500/10"
                      )}
                      placeholder="Nguyễn Văn A"
                    />
                    {errors.hoten && <p className="text-red-500 text-xs mt-1">{errors.hoten}</p>}
                 </div>

                 <div>
                    <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                       <Mail size={16} className="text-primary" />
                       Email <span className="text-red-500">*</span>
                    </label>
                    <input 
                      type="email"
                      value={data.email}
                      onChange={e => setData('email', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                        errors.email && "border-red-500 ring-red-500/10"
                      )}
                      placeholder="email@example.com"
                    />
                    {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
                 </div>

                 <div>
                    <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                       <Lock size={16} className="text-primary" />
                       Mật khẩu <span className="text-red-500">*</span>
                    </label>
                    <input 
                      type="password"
                      value={data.password}
                      onChange={e => setData('password', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                        errors.password && "border-red-500 ring-red-500/10"
                      )}
                      placeholder="••••••••"
                    />
                    {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password}</p>}
                 </div>

                 <div>
                    <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                       <Phone size={16} className="text-primary" />
                       Số điện thoại <span className="text-red-500">*</span>
                    </label>
                    <input 
                      type="text"
                      value={data.sodienthoai}
                      onChange={e => setData('sodienthoai', e.target.value)}
                      className={cn(
                        "w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary/20 transition-all outline-none",
                        errors.sodienthoai && "border-red-500 ring-red-500/10"
                      )}
                      placeholder="0123456789"
                    />
                    {errors.sodienthoai && <p className="text-red-500 text-xs mt-1">{errors.sodienthoai}</p>}
                 </div>
              </div>

              <div>
                <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                  <MapPin size={16} className="text-primary" />
                  Địa chỉ
                </label>
                <textarea 
                  value={data.diachi}
                  onChange={e => setData('diachi', e.target.value)}
                  rows={3}
                  className="w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary/20 transition-all outline-none resize-none"
                  placeholder="Nhập địa chỉ của ngưĐi dĐăng..."
                />
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                    <UserCheck size={16} className="text-primary" />
                    Giới tiềnh
                  </label>
                  <select 
                    value={data.gioitinh}
                    onChange={e => setData('gioitinh', parseInt(e.target.value))}
                    className="w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none"
                  >
                    <option value={1}>Nam</option>
                    <option value={0}>Nữ</option>
                    <option value={2}>Khác</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-bold mb-2 text-slate-700 flex items-center gap-2">
                    <Shield size={16} className="text-primary" />
                    Vai trĐ?
                  </label>
                  <select 
                    value={data.quyen}
                    onChange={e => setData('quyen', parseInt(e.target.value))}
                    className="w-full bg-slate-50/50 border border-slate-200 rounded-2xl py-3 px-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none"
                  >
                    <option value={0}>Khách hàng (Customer)</option>
                    <option value={1}>Quản trị viên (Admin)</option>
                  </select>
                </div>
              </div>
            </div>

            <div className="flex items-center justify-end gap-3 pt-4">
              <Link 
                href={route('user.index')}
                className="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all shadow-sm"
              >
                Hủy bĐ
              </Link>
              <button
                type="submit"
                disabled={processing}
                className="flex items-center gap-2 px-10 py-3 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-xl shadow-primary/20 disabled:opacity-50 hover:scale-105 active:scale-95"
              >
                <Save size={18} />
                {processing ? 'Đang xử lĐ?...' : 'Tạo ngưĐi dĐăng'}
              </button>
            </div>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
