import Link from "next/link";
import { AspectRatio } from "@/components/ui/aspect-ratio";

export function BlogSection({ posts }: { posts: any[] }) {
  if (!posts || posts.length === 0) return null;

  const getImageUrl = (path: string) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `${process.env.NEXT_PUBLIC_API_URL}/storage/${path}`;
  };

  return (
    <section className="space-y-8 bg-muted/30 -mx-4 px-4 py-16 md:rounded-[40px] md:mx-0 md:px-12">
      <div className="flex items-center justify-between">
        <h3 className="font-merriweather text-3xl font-bold">Câu Chuyện & Trải Nghiệm</h3>
        <Link href="/blog" className="text-primary hover:text-primary/80 font-medium text-sm">Xem tất cả</Link>
      </div>
      <div className="grid md:grid-cols-3 gap-8">
        {posts.slice(0, 3).map((post: any) => (
          <Link key={post.id} href={`/blog/${post.slug || post.id}`} className="group space-y-4">
            <div className="relative overflow-hidden rounded-2xl">
              <AspectRatio ratio={16/10}>
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img 
                  src={getImageUrl(post.anhdaidien)} 
                  alt={post.tieude} 
                  className="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105" 
                />
              </AspectRatio>
            </div>
            <div>
              <p className="text-xs text-primary font-bold uppercase tracking-wider mb-2">
                {post.danhmuc?.tendm || post.danhmucbaiviet?.tendm || "Tin Tức"}
              </p>
              <h4 className="font-merriweather font-bold text-lg line-clamp-2 group-hover:text-primary transition-colors">
                {post.tieude}
              </h4>
            </div>
          </Link>
        ))}
      </div>
    </section>
  );
}
