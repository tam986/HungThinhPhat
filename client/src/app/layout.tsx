import type { Metadata } from "next";
import { Merriweather, DM_Sans } from "next/font/google";
import { Toaster } from "@/components/ui/sonner";
import { Navbar } from "@/components/layout/Navbar";
import { Footer } from "@/components/layout/Footer";
import { FloatingContact } from "@/components/layout/FloatingContact";
import { fetchNavTree } from "@/services/api";
import "./globals.css";

const merriweather = Merriweather({
  weight: ["300", "400", "700", "900"],
  subsets: ["latin"],
  variable: "--font-merriweather",
});

const dmSans = DM_Sans({
  subsets: ["latin"],
  variable: "--font-dm-sans",
});

export const metadata: Metadata = {
  title: {
    default: "Hưng Thịnh Phát – Đặc Sản Miền Tây",
    template: "%s | Hưng Thịnh Phát",
  },
  description: "Khám phá đặc sản Miền Tây Nam Bộ chính gốc: bánh, mứt, khô, trái cây sấy. Giao hàng toàn quốc.",
  keywords: ["đặc sản miền tây", "hưng thịnh phát", "bánh kẹo miền tây", "khô cá", "mứt dừa"],
  openGraph: {
    type: "website",
    locale: "vi_VN",
    siteName: "Hưng Thịnh Phát",
    title: "Hưng Thịnh Phát – Đặc Sản Miền Tây",
    description: "Đặc sản chính gốc Miền Tây Nam Bộ – chất lượng cao, giá tốt, giao hàng toàn quốc.",
  },
  robots: {
    index: true,
    follow: true,
  },
};

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const navTreeRes = await fetchNavTree();
  const navTree = Array.isArray(navTreeRes) ? navTreeRes : (navTreeRes?.data || []);

  return (
    <html lang="vi">
      <body
        className={`${merriweather.variable} ${dmSans.variable} font-sans antialiased bg-background text-foreground`}
      >
        <Navbar initialNavTree={navTree} />
        {children}
        <Footer />
        <Toaster position="top-center" richColors />
        <FloatingContact />
      </body>
    </html>
  );
}
