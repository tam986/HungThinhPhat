import Link from "next/link";

interface BlogCardProps {
  post: any;
}

export function BlogCard({ post }: BlogCardProps) {
  const getImageUrl = (path: string | undefined) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `${process.env.NEXT_PUBLIC_API_URL}/storage/${path}`;
  };

  const plainTextContent = (post.noidung || "").replace(/<[^>]*>?/gm, "");
  const excerpt = post.tomtat || plainTextContent.substring(0, 110) + "...";
  const formattedDate = post.created_at 
    ? new Date(post.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) // ex: 30 Jan 2024
    : "";

  return (
    <Link
      href={`/blog/${post.slug || post.id}`}
      className="group block bg-white rounded-[20px] overflow-hidden transition-all duration-300 hover:shadow-xl border border-neutral-100 hover:border-neutral-200"
    >
      {/* Top Image Section */}
      <div className="relative w-full aspect-[4/3] bg-neutral-100 overflow-hidden">
        {/* eslint-disable-next-line @next/next/no-img-element */}
        <img
          src={getImageUrl(post.anhdaidien)}
          alt={post.tieude}
          className="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105"
        />
        
        {/* Category Pill Inside Image */}
        <div className="absolute top-4 left-4 z-10">
          <span className="bg-black/50 backdrop-blur-md text-white px-3 py-1.5 text-[11px] font-semibold rounded-full border border-white/10">
             {post.danhmuc?.tendm || post.danhmucbaiviet?.tendm || "Destination"}
          </span>
        </div>
      </div>

      {/* Content Section */}
      <div className="p-6 md:p-8 space-y-4 flex flex-col justify-between">
        <div className="space-y-4">
           {/* Date and Read Time */}
           <div className="flex items-center gap-2 text-neutral-500 text-sm font-medium">
             <span>{formattedDate}</span>
             <span className="text-neutral-300">•</span>
             <span>10 mins read</span>
           </div>
           
           {/* Title & Excerpt */}
           <div className="space-y-3">
             <h3 className="font-inter text-neutral-900 text-xl md:text-[22px] font-bold leading-snug group-hover:text-primary transition-colors line-clamp-2">
               {post.tieude}
             </h3>
             <p className="text-neutral-500 text-sm md:text-base leading-relaxed line-clamp-2">
               {excerpt}
             </p>
           </div>
        </div>

        {/* Author Section */}
        <div className="pt-2 flex items-center gap-3">
          <div className="w-8 h-8 rounded-full bg-neutral-200 overflow-hidden border border-neutral-100 shrink-0">
             {post.user?.avatar ? (
                <img src={getImageUrl(post.user.avatar)} className="w-full h-full object-cover" />
             ) : (
                <div className="w-full h-full flex items-center justify-center bg-primary/10 text-primary font-bold text-xs uppercase">
                   {post.user?.hoten?.charAt(0) || "A"}
                </div>
             )}
          </div>
          <span className="text-sm font-bold text-neutral-700 truncate">
             {post.user?.hoten || "Administrator"}
          </span>
        </div>
      </div>
    </Link>
  );
}
