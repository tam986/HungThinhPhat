"use client";

import React, { useCallback, useEffect, useState } from "react";
import useEmblaCarousel from "embla-carousel-react";
import Autoplay from "embla-carousel-autoplay";
import Link from "next/link";
import { Post } from "./BlogClient";

interface BlogHeroProps {
  posts: Post[];
}

export function BlogHero({ posts }: BlogHeroProps) {
  const [emblaRef, emblaApi] = useEmblaCarousel({ loop: true, align: "start" }, [
    Autoplay({ delay: 5000, stopOnInteraction: true }),
  ]);
  const [selectedIndex, setSelectedIndex] = useState(0);

  const onSelect = useCallback(() => {
    if (!emblaApi) return;
    setSelectedIndex(emblaApi.selectedScrollSnap());
  }, [emblaApi]);

  useEffect(() => {
    if (!emblaApi) return;
    onSelect();
    emblaApi.on("select", onSelect);
    emblaApi.on("reInit", onSelect);
  }, [emblaApi, onSelect]);

  if (!posts || posts.length === 0) return null;

  const getImageUrl = (path: string | undefined) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `${process.env.NEXT_PUBLIC_API_URL}/storage/${path}`;
  };

  return (
    <div className="relative w-full rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl group group/hero mb-12 bg-neutral-900">
      <div className="overflow-hidden h-[450px] md:h-[600px] lg:h-[650px]" ref={emblaRef}>
        <div className="flex h-full">
          {posts.map((post) => {
            const imageUrl = getImageUrl(post.anhdaidien);
            const categoryName = post.danhmuc?.tendm || post.danhmucbaiviet?.tendm || "Destination";
            const formattedDate = post.created_at
              ? new Date(post.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })
              : "";
            
            // @ts-ignore - Assuming user might exist on post but isn't strictly typed
            const authorName = post.user?.hoten || "Administrator";
            // @ts-ignore
            const authorAvatar = post.user?.avatar ? getImageUrl(post.user.avatar) : null;

            return (
              <div key={post.id} className="relative flex-[0_0_100%] min-w-0 h-full">
                {/* Background Image */}
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img
                  src={imageUrl}
                  alt={post.tieude}
                  className="absolute inset-0 w-full h-full object-cover transition-transform duration-[10000ms] ease-linear group-hover/hero:scale-110"
                />
                
                {/* Dark Gradient Overlay for Readability */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10" />
                
                {/* Content */}
                <div className="absolute inset-x-0 bottom-0 p-6 md:p-12 lg:p-16 flex flex-col items-start justify-end h-full">
                  <div className="w-full max-w-4xl transform transition-all duration-500">
                    
                    {/* Category Pill */}
                     <Link href={`/blog/${post.slug || post.id}`} className="inline-block px-4 py-1.5 mb-5 md:mb-6 text-xs font-bold tracking-wider text-white bg-white/20 backdrop-blur-md rounded-full border border-white/20 hover:bg-white/30 transition shadow-sm">
                        {categoryName}
                     </Link>
                     
                    {/* Title */}
                    <Link href={`/blog/${post.slug || post.id}`} className="block group/link">
                      <h2 className="text-3xl md:text-5xl lg:text-6xl font-bold font-inter text-white mb-4 leading-tight group-hover/link:text-neutral-200 transition-colors drop-shadow-md">
                        {post.tieude}
                      </h2>
                    </Link>
                    
                    {/* Excerpt */}
                    {post.tomtat && (
                      <p className="text-neutral-200 text-sm md:text-lg max-w-2xl mb-8 line-clamp-2 md:line-clamp-3 drop-shadow">
                        {post.tomtat}
                      </p>
                    )}
                    
                    {/* Bottom Meta Bar */}
                    <div className="flex flex-wrap items-center justify-between gap-4 w-full">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-full bg-neutral-200 overflow-hidden border border-white/20 shrink-0">
                           {authorAvatar ? (
                             // eslint-disable-next-line @next/next/no-img-element
                              <img src={authorAvatar} alt={authorName} className="w-full h-full object-cover" />
                           ) : (
                              <div className="w-full h-full flex items-center justify-center bg-white/20 text-white font-bold text-sm uppercase backdrop-blur-md">
                                 {authorName.charAt(0)}
                              </div>
                           )}
                        </div>
                        <div className="text-white">
                          <span className="block text-sm font-bold truncate">
                             {authorName}
                          </span>
                          <div className="flex items-center gap-2 text-white/70 text-xs font-medium">
                            <span>{formattedDate}</span>
                            <span className="text-white/40">•</span>
                            <span>10 mins read</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </div>

      {/* Pagination Dots (Positioned absolute bottom-right on lg, bottom-left on sm) */}
      <div className="absolute bottom-6 left-6 md:left-auto md:right-12 md:bottom-12 flex items-center gap-2 z-10 pt-4 md:pt-0">
        {posts.map((_, index) => (
          <button
            key={index}
            onClick={() => emblaApi?.scrollTo(index)}
            className={`transition-all duration-300 rounded-full shrink-0 ${
              index === selectedIndex
                ? "w-8 h-2.5 bg-white shadow-[0_0_10px_rgba(255,255,255,0.5)]"
                : "w-2.5 h-2.5 bg-white/40 hover:bg-white/70"
            }`}
            aria-label={`Go to slide ${index + 1}`}
          />
        ))}
      </div>
    </div>
  );
}
