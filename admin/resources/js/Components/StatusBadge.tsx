import React from 'react';
import { cn } from '@/lib/utils';

export type StatusType = string;

const statusMap: Record<string, { label: string; className: string }> = {
  // Orders
  'chờ xác nhận': { label: 'Chờ xác nhận', className: 'bg-yellow-50 text-yellow-700 border-yellow-100' },
  'đã xác nhận': { label: 'Đã xác nhận', className: 'bg-blue-50 text-blue-700 border-blue-100' },
  'đang giao': { label: 'Đang giao', className: 'bg-indigo-50 text-indigo-700 border-indigo-100' },
  'hoàn thành': { label: 'Hoàn Thành', className: 'bg-green-50 text-green-700 border-green-100' },
  'hủy': { label: 'Đã hủy', className: 'bg-red-50 text-red-700 border-red-100' },
  
  // Generic / Visibility
  'active': { label: 'Hoạt động', className: 'bg-emerald-50 text-emerald-700 border-emerald-100' },
  'inactive': { label: 'Tạm ẩn', className: 'bg-slate-50 text-slate-500 border-slate-200' },
  'đang hiện': { label: 'Đang hiện', className: 'bg-emerald-50 text-emerald-700 border-emerald-100' },
  'đang ẩn': { label: 'Đang ẩn', className: 'bg-slate-50 text-slate-500 border-slate-200' },
  
  // Coupons
  'chưa diễn ra': { label: 'Sắp diễn ra', className: 'bg-amber-50 text-amber-700 border-amber-100' },
  'đang diễn ra': { label: 'Đang diễn ra', className: 'bg-emerald-50 text-emerald-700 border-emerald-100' },
  'kết thúc': { label: 'Đã kết thúc', className: 'bg-slate-50 text-slate-500 border-slate-200' },

  // English fallbacks
  'pending': { label: 'Chờ xác nhận', className: 'bg-yellow-50 text-yellow-700 border-yellow-100' },
  'paid': { label: 'Đã thanh toán', className: 'bg-green-50 text-green-700 border-green-100' },
  'canceled': { label: 'Đã hủy', className: 'bg-red-50 text-red-700 border-red-100' },
};

interface StatusBadgeProps {
  status: string;
  labels?: {
    active?: string;
    warning?: string;
    inactive?: string;
    pending?: string;
    [key: string]: string | undefined;
  };
}

export default function StatusBadge({ status, labels }: StatusBadgeProps) {
  const normalizedStatus = status.toLowerCase().trim();
  const config = statusMap[normalizedStatus] || { label: status, className: 'bg-slate-50 text-slate-700 border-slate-100' };

  // If labels are provided, try to override the default label
  let displayLabel = config.label;
  if (labels) {
    if (normalizedStatus === 'active' || normalizedStatus === 'đang hiện' || normalizedStatus === 'đang diễn ra') displayLabel = labels.active || displayLabel;
    if (normalizedStatus === 'inactive' || normalizedStatus === 'đang ẩn' || normalizedStatus === 'kết thúc') displayLabel = labels.inactive || displayLabel;
    if (normalizedStatus === 'warning' || normalizedStatus === 'chưa diễn ra') displayLabel = labels.warning || displayLabel;
    
    // Fallback search in labels object if the status key exists directly
    if (labels[normalizedStatus]) displayLabel = labels[normalizedStatus]!;
  }

  return (
    <span className={cn(
      "px-2.5 py-1 rounded-full text-[10px] font-bold border transition-all uppercase tracking-wider",
      config.className
    )}>
      {displayLabel}
    </span>
  );
}
