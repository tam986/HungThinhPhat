import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import { 
  Settings, 
  Save, 
  Globe, 
  Phone, 
  Mail, 
  MapPin, 
  CreditCard,
  Facebook,
  Youtube,
  Share2,
  QrCode,
  Image as ImageIcon,
  CheckCircle2
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface Props {
  settings: Record<string, any>;
}

export default function SettingsIndex({ settings }: Props) {
  const [activeTab, setActiveTab] = useState<'general' | 'contact' | 'payment' | 'social'>('general');
  
  const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
    site_name: settings.site_name || '',
    contact_email: settings.contact_email || '',
    contact_phone: settings.contact_phone || '',
    address: settings.address || '',
    bank_name: settings.bank_name || '',
    bank_account_number: settings.bank_account_number || '',
    bank_account_name: settings.bank_account_name || '',
    bank_qr_code: null,
    facebook_url: settings.facebook_url || '',
    youtube_url: settings.youtube_url || '',
    tiktok_url: settings.tiktok_url || '',
    zalo_url: settings.zalo_url || '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('settings.update'), {
      onSuccess: () => {
        // Handle success if needed
      }
    });
  };

  const tabs = [
    { id: 'general', label: 'Của bạn', icon: Globe },
    { id: 'contact', label: 'Liên hệ', icon: Phone },
    { id: 'social', label: 'Mạng xã hội', icon: Share2 },
    { id: 'payment', label: 'Thanh toán', icon: CreditCard },
  ];

  return (
    <AdminLayout>
      <Head title="Cấu hình hệ thống" />

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900 text-dark">Cấu hình hệ thống</h1>
          <p className="text-slate-500 text-sm mt-1 font-medium">
             Quản lý thông tin website and cấu hình toán các.
          </p>
        </div>
        {recentlySuccessful && (
          <div className="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold animate-in fade-in slide-in-from-right-4">
             <CheckCircle2 size={16} />
             Đã lưu thay Đổi
          </div>
        )}
      </div>

      <div className="mt-8 flex flex-col lg:flex-row gap-8">
        {/* Sidebar Tabs */}
        <div className="lg:w-64 flex-shrink-0">
           <div className="bg-white rounded-3xl border border-slate-200 p-2 shadow-sm space-y-1">
              {tabs.map((tab) => (
                <button
                  key={tab.id}
                  onClick={() => setActiveTab(tab.id as any)}
                  className={cn(
                    "w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all",
                    activeTab === tab.id 
                      ? "bg-primary text-slate-900 shadow-lg shadow-primary/20" 
                      : "text-slate-500 hover:bg-slate-50 hover:text-slate-900"
                  )}
                >
                  <tab.icon size={18} />
                  {tab.label}
                </button>
              ))}
           </div>
        </div>

        {/* Content Area */}
        <div className="flex-1 max-w-4xl">
           <form onSubmit={handleSubmit} className="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden text-dark animate-in fade-in slide-in-from-bottom-4">
              <div className="p-8 space-y-8">
                 {activeTab === 'general' && (
                   <div className="space-y-6">
                      <div className="flex items-center gap-3 pb-2 border-b border-slate-50">
                        <div className="p-2 bg-blue-50 text-blue-500 rounded-lg">
                           <Globe size={20} />
                        </div>
                        <h2 className="font-bold text-slate-800">Thông tin của bạn</h2>
                      </div>
                      <div className="grid grid-cols-1 gap-6">
                         <div className="space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tên website</label>
                            <input 
                              type="text"
                              value={data.site_name}
                              onChange={e => setData('site_name', e.target.value)}
                              className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                            />
                         </div>
                      </div>
                   </div>
                 )}

                 {activeTab === 'contact' && (
                   <div className="space-y-6">
                      <div className="flex items-center gap-3 pb-2 border-b border-slate-50">
                        <div className="p-2 bg-emerald-50 text-emerald-500 rounded-lg">
                           <Phone size={20} />
                        </div>
                        <h2 className="font-bold text-slate-800">Thông tin liên hệ</h2>
                      </div>
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div className="space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Email liên hệ</label>
                            <div className="relative">
                               <Mail className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300" size={18} />
                               <input 
                                type="email"
                                value={data.contact_email}
                                onChange={e => setData('contact_email', e.target.value)}
                                className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 pl-12 pr-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                              />
                            </div>
                         </div>
                         <div className="space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Số điện thoại</label>
                            <div className="relative">
                               <Phone className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300" size={18} />
                               <input 
                                type="text"
                                value={data.contact_phone}
                                onChange={e => setData('contact_phone', e.target.value)}
                                className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 pl-12 pr-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                              />
                            </div>
                         </div>
                         <div className="md:col-span-2 space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Địa chỉ văn phòng</label>
                            <div className="relative">
                               <MapPin className="absolute left-4 top-4 text-slate-300" size={18} />
                               <textarea 
                                value={data.address}
                                rows={3}
                                onChange={e => setData('address', e.target.value)}
                                className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 pl-12 pr-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"
                              />
                            </div>
                         </div>
                      </div>
                   </div>
                 )}

                 {activeTab === 'social' && (
                   <div className="space-y-6">
                      <div className="flex items-center gap-3 pb-2 border-b border-slate-50">
                        <div className="p-2 bg-purple-50 text-purple-500 rounded-lg">
                           <Share2 size={20} />
                        </div>
                        <h2 className="font-bold text-slate-800">Mạng xã hội</h2>
                      </div>
                      <div className="space-y-4">
                         <div className="flex items-center gap-4 bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                            <div className="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                               <Facebook size={20} />
                            </div>
                            <input 
                              type="text"
                              placeholder="Facebook URL"
                              value={data.facebook_url}
                              onChange={e => setData('facebook_url', e.target.value)}
                              className="flex-1 bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-700"
                            />
                         </div>
                         <div className="flex items-center gap-4 bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                            <div className="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                               <Youtube size={20} />
                            </div>
                            <input 
                              type="text"
                              placeholder="Youtube URL"
                              value={data.youtube_url}
                              onChange={e => setData('youtube_url', e.target.value)}
                              className="flex-1 bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-700"
                            />
                         </div>
                         <div className="flex items-center gap-4 bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                            <div className="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 font-black text-xs">
                               ZALO
                            </div>
                            <input 
                              type="text"
                              placeholder="Zalo URL (e.g. https://zalo.me/0909123456)"
                              value={data.zalo_url}
                              onChange={e => setData('zalo_url', e.target.value)}
                              className="flex-1 bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-700"
                            />
                         </div>
                      </div>
                   </div>
                 )}

                 {activeTab === 'payment' && (
                   <div className="space-y-6">
                      <div className="flex items-center gap-3 pb-2 border-b border-slate-50">
                        <div className="p-2 bg-amber-50 text-amber-500 rounded-lg">
                           <CreditCard size={20} />
                        </div>
                        <h2 className="font-bold text-slate-800">Cấu hình thanh toán (Bank)</h2>
                      </div>
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div className="space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tên ngân hàng</label>
                            <input 
                              type="text"
                              value={data.bank_name}
                              onChange={e => setData('bank_name', e.target.value)}
                              className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                              placeholder="VD: Vietcombank"
                            />
                         </div>
                         <div className="space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Số tài khoản</label>
                            <input 
                              type="text"
                              value={data.bank_account_number}
                              onChange={e => setData('bank_account_number', e.target.value)}
                              className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                            />
                         </div>
                         <div className="space-y-2">
                            <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tên chủ tài khoản</label>
                            <input 
                               type="text"
                               value={data.bank_account_name}
                               onChange={e => setData('bank_account_name', e.target.value)}
                               className="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 px-5 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all uppercase"
                            />
                         </div>
                         <div className="space-y-4">
                            <label className="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Mã QR Thanh toán</label>
                            <div className="flex items-center gap-6">
                               {settings.bank_qr_code_url ? (
                                 <div className="w-24 h-24 rounded-2xl border-2 border-slate-100 overflow-hidden bg-slate-50 shadow-sm flex-shrink-0">
                                    <img src={settings.bank_qr_code_url} className="w-full h-full object-contain p-2" alt="QR" />
                                 </div>
                               ) : (
                                 <div className="w-24 h-24 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-300 gap-1 flex-shrink-0">
                                    <QrCode size={24} />
                                    <span className="text-[8px] font-bold">CHƯA CÓ</span>
                                 </div>
                               )}
                               <input 
                                 type="file"
                                 onChange={e => setData('bank_qr_code', (e.target.files as any)[0])}
                                 className="text-xs font-bold text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"
                                 accept="image/png, image/jpeg, image/webp, image/avif"
                               />
                            </div>
                         </div>
                      </div>
                   </div>
                 )}
              </div>

              <div className="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3">
                 <button
                    type="submit"
                    disabled={processing}
                    className="flex items-center gap-2 px-8 py-3.5 bg-primary text-slate-900 rounded-2xl font-bold text-sm hover:bg-primary/91 transition-all shadow-xl shadow-primary/20 active:scale-95 disabled:opacity-50"
                 >
                   <Save size={18} />
                   {processing ? 'Đang lưu...' : 'Lưu cấu hình'}
                 </button>
              </div>
           </form>
        </div>
      </div>
    </AdminLayout>
  );
}
