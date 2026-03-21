import React, { useState, useMemo, useEffect } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm, router } from '@inertiajs/react';
import { 
  Package, 
  ArrowLeft, 
  Plus, 
  Edit, 
  Trash2, 
  Image as ImageIcon, 
  Tag, 
  Box, 
  Layers,
  Save,
  X,
  AlertCircle,
  RefreshCcw,
  CheckCircle2,
  ChevronRight,
  Sparkles,
  Zap,
  Star
} from 'lucide-react';
import { toast } from 'sonner';
import { cn } from '@/lib/utils';

interface Variant {
  id: number;
  id_sp: number;
  id_khoiluong: number;
  id_nhanbanh: number | null;
  gia: number;
  giakm: number | null;
  soluong: number;
  hinh: string | null;
  slug: string;
  full_name: string;
  khoiluong: { id: number; khoiluong: string };
  nhanbanh?: { id: number; tenNhanBanh: string } | null;
}

interface Product {
  id: number;
  tensp: string;
  img: string | null;
  mota: string | null;
  anhien: boolean | number;
  is_featured: boolean | number;
  is_new: boolean | number;
  danhmuc: { tendanhmuc: string };
  nhacungcap: { tennhacungcap: string };
  bienthe: Variant[];
}

interface Props {
  product: Product;
  khoiluongs: { id: number; khoiluong: string }[];
  nhanbanhs: { id: number; tenNhanBanh: string }[];
}

export default function Detail({ product, khoiluongs, nhanbanhs }: Props) {
  // --- States for Variant Generation ---
  const [selectedWeights, setSelectedWeights] = useState<number[]>([]);
  const [selectedFillings, setSelectedFillings] = useState<number[]>([]);
  const [generatedItems, setGeneratedItems] = useState<any[]>([]);

  // --- States for UI ---
  const [isProcessing, setIsProcessing] = useState(false);
  const [bulkConfig, setBulkConfig] = useState({ gia: '', giakm: '', soluong: '100' });

  // --- Functions for Generation ---
  const handleToggleWeight = (id: number) => {
    setSelectedWeights(prev => prev.includes(id) ? prev.filter(x => x !== id) : [...prev, id]);
  };
  const handleToggleFilling = (id: number) => {
    setSelectedFillings(prev => prev.includes(id) ? prev.filter(x => x !== id) : [...prev, id]);
  };

  const generateVariants = () => {
    if (selectedWeights.length === 0) {
      alert("Vui lòng chọn ít nhất một Khối lượng!");
      return;
    }

    const newItems: any[] = [];
    const fillings = selectedFillings.length > 0 ? selectedFillings : [null];

    selectedWeights.forEach(wId => {
        const weight = khoiluongs.find(w => w.id === wId);
        fillings.forEach(fId => {
          const filling = fId ? nhanbanhs.find(f => f.id === fId) : null;
          
          // Check if it already exists in product.bienthe
          const exists = product.bienthe.find(v => 
            v.id_khoiluong === wId && 
            v.id_nhanbanh === fId
          );

          if (!exists) {
            const fullName = `${product.tensp}${filling ? ' nhân ' + filling.tenNhanBanh : ''}${weight ? ' ' + weight.khoiluong : ''}`;
            const slug = `${product.tensp}-${filling ? filling.tenNhanBanh : ''}-${weight ? weight.khoiluong : ''}`
              .toLowerCase()
              .normalize("NFD")
              .replace(/[\u0300-\u036f]/g, "")
              .replace(/[đĐ]/g, "d")
              .replace(/([^0-9a-z-\s])/g, "")
              .replace(/(\s+)/g, "-")
              .replace(/-+/g, "-")
              .replace(/^-+|-+$/g, "");

            newItems.push({
              id_khoiluong: wId,
              id_nhanbanh: fId,
              full_name: fullName,
              slug: slug,
              gia: bulkConfig.gia,
              giakm: bulkConfig.giakm,
              soluong: bulkConfig.soluong,
              is_featured: false,
              hinh: null,
              hinh_preview: null,
              tempId: Date.now() + Math.random()
            });
          }
        });
      });

    if (newItems.length === 0) {
      alert("Tất cả các tổ hợp bạn chọn đã tồn tại!");
    } else {
      setGeneratedItems([...generatedItems, ...newItems]);
    }
  };

  const applyBulk = () => {
    setGeneratedItems(prev => prev.map(item => ({
      ...item,
      gia: bulkConfig.gia || item.gia,
      giakm: bulkConfig.giakm || item.giakm,
      soluong: bulkConfig.soluong || item.soluong
    })));
  };

  const removeGenerated = (tempId: number) => {
    setGeneratedItems(prev => prev.filter(i => i.tempId !== tempId));
  };

  const updateItem = (tempId: number, field: string, value: any) => {
    setGeneratedItems(prev => prev.map(item => {
      if (item.tempId === tempId) {
        if (field === 'hinh') {
           return { 
             ...item, 
             hinh: value, 
             hinh_preview: value ? URL.createObjectURL(value) : null 
           };
        }
        return { ...item, [field]: value };
      }
      return item;
    }));
  };

  const saveAll = () => {
     if (generatedItems.length === 0) return;
     setIsProcessing(true);
     router.post(route('sanpham.variants.bulk', product.id), {
       variants: generatedItems
     }, {
       onSuccess: () => {
         setGeneratedItems([]);
         setIsProcessing(false);
         setSelectedWeights([]);
         setSelectedFillings([]);
       },
       onError: () => setIsProcessing(false)
     });
  };

  // --- State for Editing ---
  const [editingVariant, setEditingVariant] = useState<Variant | null>(null);
  const { data, setData, put, processing, reset, errors } = useForm({
    gia: 0,
    giakm: 0 as number | null,
    soluong: 0,
    hinh: null as File | null,
  });

  const openEditModal = (variant: Variant) => {
    setEditingVariant(variant);
    setData({
      gia: variant.gia,
      giakm: variant.giakm,
      soluong: variant.soluong,
      hinh: null
    });
  };

  const handleUpdateVariant = (e: React.FormEvent) => {
    e.preventDefault();
    if (!editingVariant) return;

    // Use router.post with _method=PUT to support file uploads in Laravel
    router.post(route('sanpham.variants.update', editingVariant.id), {
      _method: 'PUT',
      ...data
    }, {
      onSuccess: () => {
        setEditingVariant(null);
        reset();
      }
    });
  };

  const deleteVariant = (id: number) => {
    if (confirm('Bạn có chắc chắn muốn xoá biến thể này không? Thao tác này không thể hoàn tác.')) {
        router.delete(route('sanpham.variant.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Biến thể đã được xoá!');
            },
            onError: () => {
                toast.error('Có lỗi xảy ra khi xoá biến thể.');
            }
        });
    }
  };

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
  };

  return (
    <AdminLayout>
      <Head title={`Quản trị Sản phẩm: ${product.tensp}`} />

      {/* Edit Variant Modal */}
      {editingVariant && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
          <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={() => setEditingVariant(null)} />
          <div className="relative bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
            <div className="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-slate-900 shadow-sm">
                  <Edit size={20} />
                </div>
                <div>
                  <h3 className="text-lg font-black text-slate-900">Sửa biến thể</h3>
                  <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{editingVariant.full_name}</p>
                </div>
              </div>
              <button onClick={() => setEditingVariant(null)} className="p-2 text-slate-400 hover:text-slate-600 transition-all">
                <X size={20} />
              </button>
            </div>
            
            <form onSubmit={handleUpdateVariant} className="p-8 space-y-6">
              <div className="grid grid-cols-2 gap-6">
                <div className="space-y-2">
                  <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Giá bán</label>
                  <input 
                    type="number"
                    value={data.gia}
                    onChange={e => setData('gia', parseInt(e.target.value))}
                    className="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all"
                  />
                  {errors.gia && <p className="text-[10px] text-red-500 font-bold ml-1">{errors.gia}</p>}
                </div>
                <div className="space-y-2">
                  <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Giá khuyến mãi</label>
                  <input 
                    type="number"
                    value={data.giakm || ''}
                    onChange={e => setData('giakm', e.target.value ? parseInt(e.target.value) : null)}
                    className="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all text-emerald-600"
                    placeholder="Không có"
                  />
                </div>
              </div>

              <div className="space-y-2">
                <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Số lượng tồn kho</label>
                <input 
                  type="number"
                  value={data.soluong}
                  onChange={e => setData('soluong', parseInt(e.target.value))}
                  className="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all"
                />
              </div>

              <div className="space-y-2">
                <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Hình ảnh biến thể</label>
                <div className="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 hover:border-primary/50 transition-all relative">
                   <input 
                    type="file" 
                    onChange={e => setData('hinh', e.target.files?.[0] || null)}
                    className="absolute inset-0 opacity-0 cursor-pointer"
                   />
                   <div className="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-slate-400 shadow-sm">
                      <ImageIcon size={24} />
                   </div>
                   <div className="flex-1 min-w-0">
                      <p className="text-[11px] font-bold text-slate-600 truncate">{data.hinh ? data.hinh.name : 'Chọn ảnh mới (nếu muốn thay đổi)'}</p>
                      <p className="text-[9px] text-slate-400 uppercase font-black">PNG, JPG tối đa 10MB</p>
                   </div>
                </div>
              </div>

              <div className="pt-4 flex gap-3">
                 <button 
                  type="button"
                  onClick={() => setEditingVariant(null)}
                  className="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all"
                 >
                   Hủy
                 </button>
                 <button 
                  type="submit"
                  disabled={processing}
                  className="flex-2 px-12 py-4 bg-primary text-slate-900 rounded-2xl font-black text-sm hover:shadow-xl hover:bg-primary/90 transition-all disabled:opacity-50 flex items-center justify-center gap-2"
                 >
                   {processing ? <RefreshCcw size={18} className="animate-spin" /> : <Save size={18} />}
                   Lưu cập nhật
                 </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* Breadcrumb & Navigation */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div className="flex items-center gap-4">
          <Link 
            href={route('sanpham.index')}
            className="p-3 bg-white border border-slate-200 rounded-2xl text-slate-500 hover:text-primary hover:border-primary transition-all shadow-sm"
          >
            <ArrowLeft size={20} />
          </Link>
          <div>
            <nav className="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">
              <Link href={route('sanpham.index')} className="hover:text-primary transition-colors">Sản phẩm</Link>
              <ChevronRight size={12} />
              <span className="text-slate-600 font-black">{product.danhmuc.tendanhmuc}</span>
            </nav>
            <h1 className="text-3xl font-black tracking-tight text-slate-900">{product.tensp}</h1>
          </div>
        </div>
        <div className="flex items-center gap-3">
          <div className="hidden sm:flex flex-col items-end mr-2">
            <span className="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Trạng thái</span>
            <span className={cn(
              "text-xs font-bold flex items-center gap-1.5",
              product.anhien ? "text-emerald-500" : "text-slate-400"
            )}>
              <div className={cn("w-2 h-2 rounded-full", product.anhien ? "bg-emerald-500 animate-pulse" : "bg-slate-300")} />
              {product.anhien ? 'Đang kinh doanh' : 'Đang tạm ẩn'}
            </span>
          </div>
          <Link 
            href={route('sanpham.edit', product.id)}
            className="flex items-center gap-2 px-5 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all shadow-sm"
          >
            <Edit size={16} />
            Sửa thông tin chính
          </Link>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {/* === Sidebar (Cột Trái) === */}
        <div className="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
           {/* Section 1: Selector */}
           <div className="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden p-8 space-y-8">
              <div className="space-y-2">
                <span className="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-black uppercase tracking-tighter">
                  <Sparkles size={12} />
                  Cấu hình thuộc tính
                </span>
                <h3 className="text-xl font-black text-slate-900">Thiết lập biến thể</h3>
                <p className="text-sm text-slate-500 leading-relaxed">Chọn các thuộc tính để hệ thống tự động sinh ra các biến thể sản phẩm.</p>
              </div>

              {/* Khoi Luong */}
              <div className="space-y-4">
                <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                  <div className="w-1.5 h-1.5 bg-primary rounded-full" />
                  Dải khối lượng
                </label>
                <div className="flex flex-wrap gap-2">
                   {khoiluongs.map(w => (
                     <button
                        key={w.id}
                        onClick={() => handleToggleWeight(w.id)}
                        className={cn(
                          "px-4 py-2 rounded-xl text-xs font-bold border-2 transition-all",
                          selectedWeights.includes(w.id) 
                            ? "bg-primary/5 border-primary text-primary shadow-sm"
                            : "bg-slate-50 border-transparent text-slate-400 hover:bg-slate-100"
                        )}
                     >
                       {w.khoiluong}
                     </button>
                   ))}
                </div>
              </div>

              {/* Nhan Banh */}
              <div className="space-y-4">
                <label className="text-[11px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                  <div className="w-1.5 h-1.5 bg-primary rounded-full" />
                  Nhân bánh đi kèm
                </label>
                <div className="flex flex-wrap gap-2">
                   {nhanbanhs.map(f => (
                     <button
                        key={f.id}
                        onClick={() => handleToggleFilling(f.id)}
                        className={cn(
                          "px-4 py-2 rounded-xl text-xs font-bold border-2 transition-all",
                          selectedFillings.includes(f.id) 
                            ? "bg-primary/5 border-primary text-primary shadow-sm"
                            : "bg-slate-50 border-transparent text-slate-400 hover:bg-slate-100"
                        )}
                     >
                       {f.tenNhanBanh}
                     </button>
                   ))}
                </div>
              </div>

              <div className="pt-4 border-t border-slate-100">
                  <button 
                    onClick={generateVariants}
                    disabled={selectedWeights.length === 0}
                    className="w-full flex items-center justify-center gap-2 px-6 py-4 bg-slate-900 text-white rounded-[20px] font-black text-sm hover:bg-slate-800 transition-all shadow-xl disabled:opacity-30 disabled:cursor-not-allowed group"
                  >
                    <Zap size={18} className="text-primary group-hover:animate-bounce" />
                    Tạo Biến Thể (.matrix)
                  </button>
              </div>
           </div>

           {/* Section 2: Quick Pricing */}
           {generatedItems.length > 0 && (
             <div className="bg-slate-900 rounded-[32px] p-8 space-y-6 shadow-2xl animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div className="space-y-1">
                  <h4 className="text-white font-bold text-lg">Thiết lập nhanh hàng loạt</h4>
                  <p className="text-slate-400 text-xs">Áp dụng một cấu hình cho toàn bộ {generatedItems.length} biến thể đang tạo.</p>
                </div>
                <div className="grid grid-cols-2 gap-4">
                   <div className="space-y-2">
                      <label className="text-[10px] font-bold text-slate-500 uppercase">Giá bán</label>
                      <input 
                        type="number"
                        value={bulkConfig.gia}
                        onChange={e => setBulkConfig({...bulkConfig, gia: e.target.value})}
                        className="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-sm outline-none focus:border-primary transition-all"
                        placeholder="0đ"
                      />
                   </div>
                   <div className="space-y-2">
                      <label className="text-[10px] font-bold text-slate-500 uppercase">Giá KM</label>
                      <input 
                        type="number"
                        value={bulkConfig.giakm}
                        onChange={e => setBulkConfig({...bulkConfig, giakm: e.target.value})}
                        className="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-sm outline-none focus:border-primary transition-all"
                        placeholder="KMđ"
                      />
                   </div>
                </div>
                <button 
                  onClick={applyBulk}
                  className="w-full py-3 bg-white text-slate-900 rounded-xl font-bold text-xs hover:bg-primary transition-all shadow-lg"
                >
                  Áp dụng cho tất cả
                </button>
             </div>
           )}
        </div>

        {/* === Main Content (Cột Phải) === */}
        <div className="lg:col-span-8 space-y-8">
           
           {/* Section: New Generated Variants */}
           {generatedItems.length > 0 && (
              <div className="bg-white rounded-[40px] border-2 border-primary/20 shadow-xl shadow-primary/5 overflow-hidden">
                  <div className="p-8 border-b border-slate-100 flex items-center justify-between bg-primary/5">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-slate-900 shadow-md">
                          <Plus size={24} />
                        </div>
                        <div>
                          <h2 className="text-lg font-black text-slate-900">Biến thể mới đang chờ xử lý</h2>
                          <p className="text-xs text-slate-500 font-bold uppercase tracking-widest mt-0.5">{generatedItems.length} dòng được sinh ra tự động</p>
                        </div>
                      </div>
                      <div className="flex items-center gap-3">
                        <button onClick={() => setGeneratedItems([])} className="p-2 text-slate-400 hover:text-red-500 transition-colors">
                          <Trash2 size={20} />
                        </button>
                        <button 
                          onClick={saveAll}
                          disabled={isProcessing}
                          className="flex items-center gap-2 px-8 py-3 bg-primary text-slate-900 rounded-2xl font-black text-sm hover:shadow-lg hover:bg-primary/90 transition-all disabled:opacity-50"
                        >
                          {isProcessing ? <RefreshCcw className="animate-spin" size={18} /> : <Save size={18} />}
                          Lưu tất cả {generatedItems.length} biến thể
                        </button>
                      </div>
                  </div>
                  <div className="p-8 bg-slate-50/50 space-y-4 max-h-[1000px] overflow-y-auto custom-scrollbar">
                      {generatedItems.map((item) => (
                        <div key={item.tempId} className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all group relative">
                           <div className="flex flex-col md:flex-row gap-6">
                              <div 
                                className="w-20 h-20 bg-slate-100 rounded-2xl flex-shrink-0 flex items-center justify-center text-slate-300 border border-slate-100 overflow-hidden relative cursor-pointer hover:border-primary/50 transition-all group/img"
                                onClick={() => document.getElementById(`file-${item.tempId}`)?.click()}
                              >
                                {item.hinh_preview ? (
                                  <img src={item.hinh_preview} className="w-full h-full object-cover" />
                                ) : (
                                  <ImageIcon size={32} />
                                )}
                                <div className="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                  <Plus size={20} className="text-white" />
                                </div>
                                <input 
                                  id={`file-${item.tempId}`} 
                                  type="file" 
                                  className="hidden" 
                                  accept="image/png, image/jpeg, image/webp, image/avif"
                                  onChange={e => updateItem(item.tempId, 'hinh', e.target.files?.[0])}
                                />
                              </div>
                              <div className="flex-1 space-y-4">
                                 <div>
                                    <h4 className="font-black text-slate-800 flex items-center gap-2">
                                      {item.full_name}
                                      <span className="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded uppercase">{item.slug}</span>
                                    </h4>
                                    <div className="flex gap-4 mt-1">
                                       <span className="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                          <Box size={10} /> SP: {product.tensp}
                                       </span>
                                       <span className="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                          <Tag size={10} /> DM: {product.danhmuc.tendanhmuc}
                                       </span>
                                    </div>
                                 </div>
                                 <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div className="space-y-1">
                                       <label className="text-[9px] font-black text-slate-400 uppercase tracking-widest">Giá bán</label>
                                       <input 
                                          type="number" value={item.gia} 
                                          onChange={e => updateItem(item.tempId, 'gia', e.target.value)}
                                          className="w-full bg-slate-50 border-none rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-1 focus:ring-primary outline-none"
                                       />
                                    </div>
                                    <div className="space-y-1">
                                       <label className="text-[9px] font-black text-slate-400 uppercase tracking-widest">Giá KM</label>
                                       <input 
                                          type="number" value={item.giakm} 
                                          onChange={e => updateItem(item.tempId, 'giakm', e.target.value)}
                                          className="w-full bg-slate-50 border-none rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-1 focus:ring-primary outline-none text-emerald-600"
                                       />
                                    </div>
                                    <div className="space-y-1">
                                       <label className="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kho hàng</label>
                                       <input 
                                          type="number" value={item.soluong} 
                                          onChange={e => updateItem(item.tempId, 'soluong', e.target.value)}
                                          className="w-full bg-slate-50 border-none rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-1 focus:ring-primary outline-none"
                                       />
                                    </div>
                                    <div className="flex items-end pb-1.5">
                                       <button 
                                          onClick={() => updateItem(item.tempId, 'is_featured', !item.is_featured)}
                                          className={cn(
                                            "flex items-center gap-1.5 text-[10px] font-black px-3 py-1.5 rounded-lg transition-all",
                                            item.is_featured ? "bg-amber-100 text-amber-600 shadow-sm shadow-amber-200" : "bg-slate-100 text-slate-400 hover:bg-slate-200"
                                          )}
                                       >
                                         <Star size={12} fill={item.is_featured ? "currentColor" : "none"} />
                                         NỔI BẬT
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              <button 
                                onClick={() => removeGenerated(item.tempId)}
                                className="absolute top-4 right-4 p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl md:opacity-0 group-hover:opacity-100 transition-all"
                              >
                                <X size={18} />
                              </button>
                           </div>
                        </div>
                      ))}
                  </div>
              </div>
           )}

           {/* Section: Existing Variants List */}
           <div className="bg-white rounded-[40px] border border-slate-200 shadow-sm overflow-hidden min-h-[500px]">
                <div className="p-8 border-b border-slate-100 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white">
                        <Layers size={22} />
                      </div>
                      <div>
                        <h2 className="text-lg font-black text-slate-900">Danh sách các biến thể hiện có</h2>
                        <p className="text-xs text-slate-500 font-bold uppercase tracking-widest mt-0.5">Sản phẩm có tổng cộng {product.bienthe.length} phân loại</p>
                      </div>
                    </div>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead>
                            <tr className="bg-slate-50/50">
                                <th className="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Hình</th>
                                <th className="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tên Biến Thể & Slug</th>
                                <th className="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tài chính</th>
                                <th className="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tồn kho</th>
                                <th className="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100">
                            {product.bienthe.length === 0 ? (
                                <tr>
                                    <td colSpan={5} className="px-8 py-32 text-center">
                                        <div className="flex flex-col items-center justify-center text-slate-400 scale-110">
                                            <div className="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center mb-4 border border-slate-100">
                                                <Box size={32} className="text-slate-200" />
                                            </div>
                                            <p className="text-sm font-bold text-slate-500">Chưa có biến thể nào được tạo cho sản phẩm này.</p>
                                            <p className="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Dùng cột bên trái để thiết lập nhanh nhé!</p>
                                        </div>
                                    </td>
                                </tr>
                            ) : (
                                product.bienthe.map((v) => (
                                    <tr key={v.id} className="hover:bg-slate-50/50 transition-colors group">
                                        <td className="px-8 py-6">
                                            <div className="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm relative">
                                                {v.hinh ? (
                                                    <img src={`/storage/${v.hinh}`} className="w-full h-full object-cover" />
                                                ) : (
                                                    <div className="w-full h-full flex items-center justify-center text-slate-300">
                                                        <ImageIcon size={20} />
                                                    </div>
                                                )}
                                            </div>
                                        </td>
                                        <td className="px-8 py-6">
                                            <div className="flex flex-col">
                                                <div className="flex items-center gap-2">
                                                  <span className="text-sm font-black text-slate-800">{v.full_name}</span>
                                                  {v.giakm ? <span className="bg-rose-50 text-rose-500 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-tighter shadow-sm shadow-rose-100">Sale</span> : null}
                                                </div>
                                                <span className="text-[10px] text-slate-300 font-mono mt-0.5 opacity-60 flex items-center gap-1">
                                                  <Zap size={10} /> {v.slug}
                                                </span>
                                            </div>
                                        </td>
                                        <td className="px-8 py-6">
                                            <div className="flex flex-col">
                                                <span className="text-sm font-black text-slate-900">{formatCurrency(v.gia)}</span>
                                                {v.giakm && (
                                                    <span className="text-[11px] text-emerald-600 font-black mt-1">
                                                        {formatCurrency(v.giakm)}
                                                        <span className="ml-1 text-[9px] text-slate-400 line-through decoration-slate-300">{formatCurrency(v.gia)}</span>
                                                    </span>
                                                )}
                                            </div>
                                        </td>
                                        <td className="px-8 py-6 text-center">
                                            <span className={cn(
                                                "px-3 py-1.5 rounded-xl text-xs font-black ring-1",
                                                v.soluong > 10 ? "bg-blue-50 text-blue-600 ring-blue-100" : 
                                                v.soluong > 0 ? "bg-amber-50 text-amber-600 ring-amber-100" : 
                                                "bg-red-50 text-red-600 ring-red-100"
                                            )}>
                                                {v.soluong}
                                            </span>
                                        </td>
                                        <td className="px-8 py-6 text-right">
                                            <div className="flex items-center justify-end gap-2 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button 
                                                    onClick={() => openEditModal(v)}
                                                    className="p-2.5 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-xl transition-all"
                                                >
                                                    <Edit size={18} />
                                                </button>
                                                <button 
                                                    onClick={() => deleteVariant(v.id)}
                                                    className="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all"
                                                >
                                                    <Trash2 size={18} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
           </div>

        </div>
      </div>

      <style dangerouslySetInnerHTML={{ __html: `
        .custom-scrollbar::-webkit-scrollbar {
          width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
          background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
          background: #cbd5e1;
          border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
          background: #94a3b8;
        }
      `}} />
    </AdminLayout>
  );
}
