import type { Metadata } from "next";
import { BlogClient } from "@/components/blog/BlogClient";
import { fetchBlogPosts } from "@/services/api";

export const dynamic = "force-dynamic";

export const metadata: Metadata = {
  title: "Blog – Hưng Thịnh Phát",
  description: "Những câu chuyện, công thức nấu ăn và hướng dẫn du lịch đồng bằng sông Cửu Long.",
  openGraph: {
    title: "Blog Miền Tây – Hưng Thịnh Phát",
    description: "Câu chuyện đặc sản, văn hóa, và ẩm thực miền sông nước.",
    type: "website",
  },
};

// Note: We use fetchBlogPosts which already includes normalization and error handling

export default async function BlogPage() {
  const data = await fetchBlogPosts();
  const posts = data?.baivietMoi || [];
  const categories = data?.danhmuc || [];

  return <BlogClient initialPosts={posts} categories={categories} />;
}
