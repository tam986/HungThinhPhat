import React from 'react';
import { LucideIcon } from 'lucide-react';
import { cn } from '@/lib/utils';

interface MetricCardProps {
  title: string;
  value: string | number;
  icon: LucideIcon;
  trend?: {
    value: number;
    isUp: boolean;
  };
  className?: string;
  variant?: 'primary' | 'success' | 'warning' | 'danger' | string;
}

export default function MetricCard({ title, value, icon: Icon, trend, className, variant = 'primary' }: MetricCardProps) {
  const variantStyles: Record<string, string> = {
    primary: "group-hover:bg-primary/10 group-hover:text-primary",
    success: "group-hover:bg-green-100 group-hover:text-green-600",
    warning: "group-hover:bg-amber-100 group-hover:text-amber-600",
    danger: "group-hover:bg-red-100 group-hover:text-red-600",
  };

  const currentVariantStyle = variantStyles[variant] || variantStyles.primary;

  return (
    <div className={cn(
      "bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group",
      className
    )}>
      <div className="flex items-start justify-between">
        <div className="space-y-2">
          <p className="text-sm font-medium text-slate-500 tracking-tight">{title}</p>
          <div className="flex items-baseline gap-2">
            <h3 className="text-2xl font-bold text-slate-900 tracking-tight">{value}</h3>
            {trend && (
              <span className={cn(
                "text-xs font-semibold px-1.5 py-0.5 rounded-md",
                trend.isUp ? "bg-green-50 text-green-600" : "bg-red-50 text-red-600"
              )}>
                {trend.isUp ? '+' : '-'}{trend.value}%
              </span>
            )}
          </div>
        </div>
        <div className={cn("p-3 bg-slate-50 text-slate-400 rounded-xl transition-colors border border-slate-100", currentVariantStyle)}>
          <Icon size={24} />
        </div>
      </div>
    </div>
  );
}
