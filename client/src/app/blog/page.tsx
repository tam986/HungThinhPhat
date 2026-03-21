import type { Metadata } from "next";
import { BlogClient } from "@/components/blog/BlogClient";

export const metadata: Metadata = {
  title: "Blog – Hưng Thịnh Phát",
  description: "Những câu chuyện, công thức nấu ăn và hướng dẫn du lịch đồng bằng sông Cửu Long.",
  openGraph: {
    title: "Blog Miền Tây – Hưng Thịnh Phát",
    description: "Câu chuyện đặc sản, văn hóa, và ẩm thực miền sông nước.",
    type: "website",
  },
};

async function getBlogData() {
  try {
    const res = await fetch("http://127.0.0.1:8000/api/baiviet", { next: { revalidate: 300 } });
    if (!res.ok) return null;
    return res.json();
  } catch (error) {
    console.error("Failed to fetch blog data:", error);
    return null;
  }
}

export default async function BlogPage() {
  const data = await getBlogData();
  const posts = data?.baivietMoi || [];
  const categories = data?.danhmuc || [];

  return <BlogClient initialPosts={posts} categories={categories} />;
}
