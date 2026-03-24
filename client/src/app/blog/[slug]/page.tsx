import { notFound } from "next/navigation";
import { fetchBlogPostDetail, getStorageUrl } from "@/services/api";

export const dynamic = "force-dynamic";
import { BlogCard } from "@/components/blog/BlogCard";
import type { Metadata } from "next";

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  try {
    const data = await fetchBlogPostDetail(slug);
    if (!data?.baiviet) return { title: "Bài viết không tồn tại" };

    return {
      title: `${data.baiviet.tieude} - Hưng Thịnh Phát`,
      description: data.baiviet.tomtat || "Bài viết đặc sắc từ Hưng Thịnh Phát",
      openGraph: {
        title: data.baiviet.tieude,
        description: data.baiviet.tomtat,
        images: [getStorageUrl(data.baiviet.anhdaidien)]
      }
    };
  } catch {
    return { title: "Blog" };
  }
}

export default async function SingleBlogPage({ params }: Props) {
  const { slug } = await params;
  let data;
  try {
    data = await fetchBlogPostDetail(slug);
  } catch (err) {
    notFound();
  }

  if (!data?.baiviet) {
    notFound();
  }

  const { baiviet: post, baivietLienQuan: relatedPosts } = data;

  const getImageUrl = (path: string | undefined) => {
    return getStorageUrl(path || "");
  };

  const formattedDate = post.created_at
    ? new Date(post.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' })
    : "";

  return (
    <article className="min-h-screen pb-0 bg-white">
      {/* Hero Banner Section */}
      <section className="relative w-full h-[60vh] md:h-[70vh] min-h-[400px]">
        {/* eslint-disable-next-line @next/next/no-img-element */}
        <img
          src={getImageUrl(post.anhdaidien)}
          alt={post.tieude}
          className="absolute inset-0 w-full h-full object-cover"
        />
        {/* Dark overlay gradients */}
        <div className="absolute inset-0 bg-black/30" />
        <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20" />
        
        {/* Title Container */}
        <div className="absolute inset-0 flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto z-10 pt-20">
          <h1 className="text-white text-3xl md:text-5xl lg:text-6xl font-merriweather font-black leading-tight mb-6 drop-shadow-lg">
            {post.tieude}
          </h1>
          <div className="flex items-center gap-2 text-white/90 text-sm md:text-base font-medium tracking-wide">
            <span>{post.user?.hoten || "Administrator"}</span>
            <span className="text-white/50">on</span>
            <span>{formattedDate}</span>
          </div>
        </div>
      </section>

      {/* Main Content Section */}
      <div className="max-w-[800px] mx-auto px-6 mt-16 md:mt-24 mb-20">
        {/* Content Box */}
        <div 
          className="blog-content font-inter text-neutral-600 text-lg md:text-[19px] leading-relaxed space-y-8"
          dangerouslySetInnerHTML={{ __html: post.noidung || "" }}
        />
        
        {/* Share Button (UI only) */}
        <div className="mt-16 pt-8 border-t border-neutral-100 flex justify-start">
          <button className="flex items-center gap-2 px-5 py-2.5 border border-primary/20 text-primary rounded-full font-bold text-xs tracking-widest hover:bg-primary hover:text-white transition-all duration-300">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            SHARE
          </button>
        </div>
      </div>

      {/* Related Posts Section */}
      {relatedPosts && relatedPosts.length > 0 && (
        <section className="bg-neutral-50 w-full py-20 px-6">
          <div className="max-w-[1200px] mx-auto">
            <h3 className="font-merriweather text-3xl font-black text-center mb-16 text-neutral-900">Bài viết liên quan</h3>
            <div className="grid md:grid-cols-3 gap-8">
              {relatedPosts.slice(0, 3).map((relatedPost: any) => (
                <BlogCard key={relatedPost.id} post={relatedPost} />
              ))}
            </div>
          </div>
        </section>
      )}
    </article>
  );
}
