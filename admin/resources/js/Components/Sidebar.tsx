import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { 
  LayoutDashboard, 
  ShoppingBag, 
  Package, 
  Users, 
  Truck, 
  Settings,
  ChevronLeft,
  ChevronRight,
  LogOut,
  Layers,
  Image as ImageIcon,
  FileText,
  MessageSquare,
  Ticket,
  ChevronDown,
  Scale,
  Soup,
  BarChart3
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface NavItem {
  name: string;
  icon: any;
  href?: string;
  children?: { name: string; href: string; icon?: any }[];
}

const navItems: NavItem[] = [
  { name: 'Dashboard', icon: LayoutDashboard, href: '/dashboard' },
  { name: 'Đơn hàng', icon: ShoppingBag, href: '/donhang' },
  { 
    name: 'Sản phẩm', 
    icon: Package, 
    children: [
      { name: 'Danh sách SP', href: '/sanpham', icon: Package },
      { name: 'Danh mục', href: '/danhmuc', icon: Layers },
      { name: 'Nhà cung cấp', href: '/nhacungcap', icon: Truck },
      { name: 'Khối lượng', href: '/khoiluong', icon: Scale },
      { name: 'Nhân bánh', href: '/nhanbanh', icon: Soup },
      { name: 'Loại bánh', href: '/loaibanh', icon: Layers },
    ]
  },
  { name: 'Banner', icon: ImageIcon, href: '/banners' },
  { name: 'Khách hàng', icon: Users, href: '/user' },
  { 
    name: 'Bài viết', 
    icon: FileText, 
    children: [
      { name: 'Danh sách bài', href: '/baiviet', icon: FileText },
      { name: 'Danh mục bài', href: '/dmBaiViet', icon: Layers },
    ]
  },
  { name: 'Bình luận', icon: MessageSquare, href: '/binhluan' },
  { name: 'Mã giảm giá', icon: Ticket, href: '/magiamgia' },
  { name: 'Cấu hình', icon: Settings, href: '/settings' },
];

export default function Sidebar() {
  const { url } = usePage();
  const [collapsed, setCollapsed] = useState(false);
  const [openMenus, setOpenMenus] = useState<string[]>([]);

  // Auto-open menu if child is active
  React.useEffect(() => {
    navItems.forEach(item => {
      if (item.children?.some(child => url.startsWith(child.href))) {
        if (!openMenus.includes(item.name)) {
          setOpenMenus(prev => [...prev, item.name]);
        }
      }
    });
  }, [url]);

  const toggleMenu = (name: string) => {
    if (collapsed) {
      setCollapsed(false);
      setOpenMenus([name]);
      return;
    }
    setOpenMenus(prev => 
      prev.includes(name) ? prev.filter(n => n !== name) : [...prev, name]
    );
  };

  return (
    <aside 
      className={cn(
        "flex flex-col h-screen bg-white border-r border-slate-200 transition-all duration-300 ease-in-out z-50 shadow-sm",
        collapsed ? "w-20" : "w-64"
      )}
    >
      <div className="flex items-center justify-between p-6 h-16 border-b border-slate-100">
        {!collapsed && (
          <span className="text-xl font-bold bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-transparent truncate">
            Hung Thinh Admin
          </span>
        )}
        <button 
          onClick={() => setCollapsed(!collapsed)}
          className="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors"
        >
          {collapsed ? <ChevronRight size={18} /> : <ChevronLeft size={18} />}
        </button>
      </div>

      <nav className="flex-1 overflow-y-auto p-4 space-y-1 custom-scrollbar">
        {navItems.map((item) => {
          const hasChildren = !!item.children;
          const isMenuOpen = openMenus.includes(item.name);
          const isActive = item.href ? url.startsWith(item.href) : item.children?.some(child => url.startsWith(child.href));

          if (hasChildren) {
            return (
              <div key={item.name} className="space-y-1">
                <button
                  onClick={() => toggleMenu(item.name)}
                  className={cn(
                    "flex items-center justify-between w-full gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative",
                    isActive && !isMenuOpen ? "bg-primary/5 text-slate-900" : "text-slate-600 hover:bg-slate-50 hover:text-primary"
                  )}
                >
                  <div className="flex items-center gap-3">
                    <item.icon size={20} className={cn(
                      "min-w-[20px]",
                      isActive ? "text-primary" : "text-slate-400 group-hover:text-primary"
                    )} />
                    {!collapsed && <span className="font-semibold text-sm">{item.name}</span>}
                  </div>
                  {!collapsed && (
                    <ChevronDown 
                      size={16} 
                      className={cn("transition-transform duration-200", isMenuOpen ? "rotate-180" : "")} 
                    />
                  )}
                </button>
                
                {isMenuOpen && !collapsed && (
                  <div className="pl-9 space-y-1 animate-in slide-in-from-top-2 duration-200">
                    {item.children?.map((child) => {
                      const isChildActive = url.startsWith(child.href);
                      return (
                        <Link
                          key={child.name}
                          href={child.href}
                          className={cn(
                            "flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200",
                            isChildActive 
                              ? "text-slate-900 font-bold bg-primary/5" 
                              : "text-slate-500 hover:text-primary hover:bg-slate-50"
                          )}
                        >
                          {child.icon && <child.icon size={14} className={isChildActive ? "text-slate-900" : "text-slate-400"} />}
                          {child.name}
                        </Link>
                      );
                    })}
                  </div>
                )}
              </div>
            );
          }

          return (
            <Link
              key={item.name}
              href={item.href!}
              className={cn(
                "flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative",
                isActive 
                  ? "bg-primary text-slate-900 shadow-md shadow-primary/20" 
                  : "text-slate-600 hover:bg-slate-50 hover:text-primary"
              )}
            >
              <item.icon size={20} className={cn(
                "min-w-[20px]",
                isActive ? "text-slate-900" : "text-slate-400 group-hover:text-primary"
              )} />
              {!collapsed && <span className="font-semibold text-sm">{item.name}</span>}
              {collapsed && (
                <div className="absolute left-full ml-4 px-3 py-1.5 bg-slate-900 text-slate-900 text-xs rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50">
                  {item.name}
                </div>
              )}
            </Link>
          );
        })}
      </nav>

      <div className="p-4 border-t border-slate-100">
        <Link
          href="/logout"
          method="post"
          as="button"
          className="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-slate-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group"
        >
          <LogOut size={20} className="text-slate-400 group-hover:text-red-600" />
          {!collapsed && <span className="font-semibold text-sm">Đăng xuất</span>}
        </Link>
      </div>
    </aside>
  );
}
