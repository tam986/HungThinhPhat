"use client";

import { MessageCircle, Phone } from "lucide-react";
import { toast } from "sonner";
import Link from "next/link";
import { useState, useEffect } from "react";
import { fetchGeneralSettings } from "@/services/api";

export function FloatingContact() {
  const [settings, setSettings] = useState<any>(null);

  useEffect(() => {
    fetchGeneralSettings().then(setSettings);
  }, []);

  const phoneNumber = settings?.contact_phone || "0909123456";
  const zaloLink = settings?.zalo_url || `https://zalo.me/${phoneNumber.replace(/[^0-9]/g, "")}`;

  const handleCopyPhone = () => {
    navigator.clipboard.writeText(phoneNumber);
    toast.success("Đã copy số điện thoại: " + phoneNumber, {
      description: "Bạn có thể dán (Paste) để gọi ngay."
    });
  };

  return (
    <div className="fixed bottom-6 right-6 flex flex-col gap-4 z-50">
      <Link 
        href={zaloLink} 
        target="_blank" 
        rel="noopener noreferrer"
        className="w-14 h-14 bg-blue-500 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform relative group"
      >
        <MessageCircle className="w-7 h-7" />
        <span className="absolute right-full mr-4 bg-white text-foreground px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity shadow-sm pointer-events-none">
          Chat Zalo
        </span>
      </Link>

      <button 
        onClick={handleCopyPhone}
        className="w-14 h-14 bg-green-500 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform relative group animate-bounce"
      >
        <Phone className="w-7 h-7" />
        <span className="absolute right-full mr-4 bg-white text-foreground px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity shadow-sm pointer-events-none">
          Gọi: {phoneNumber}
        </span>
      </button>
    </div>
  );
}
