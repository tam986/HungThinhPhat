"use client";

import React, { useRef } from "react";
import Link from "next/link";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "@/components/ui/carousel";
import Autoplay from "embla-carousel-autoplay";

interface Banner {
  id: number;
  tieude: string;
  hinhanh: string;
  duongdan: string | null;
}

interface BannerCarouselProps {
  banners: Banner[];
}

export function BannerCarousel({ banners }: BannerCarouselProps) {
  const plugin = useRef(
    Autoplay({ delay: 5000, stopOnInteraction: true })
  );

  const getImageUrl = (path: string) => {
    if (!path) return "/placeholder.jpg";
    if (path.startsWith("http")) return path;
    return `${process.env.NEXT_PUBLIC_API_URL}/storage/${path}`;
  };

  if (!banners || banners.length === 0) {
    return (
      <div className="bg-muted rounded-md overflow-hidden shadow-sm flex items-center justify-center h-full w-full">
        <span className="text-muted-foreground">Banner Slider</span>
      </div>
    );
  }

  return (
    <Carousel
      className="w-full h-full rounded-md shadow-sm"
      opts={{ loop: true }}
      plugins={[plugin.current]}
      onMouseEnter={plugin.current.stop}
      onMouseLeave={plugin.current.reset}
    >
      <CarouselContent className="h-full">
        {banners.map((banner, index) => (
          <CarouselItem key={index} className="h-full">
            <div className="relative group rounded-md overflow-hidden h-full w-full">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img
                src={getImageUrl(banner.hinhanh)}
                alt={banner.tieude || "Banner"}
                className="object-cover w-full h-full"
              />
              {banner.duongdan && (
                <Link href={banner.duongdan} className="absolute inset-0 z-10" />
              )}
            </div>
          </CarouselItem>
        ))}
      </CarouselContent>
      <div className="absolute bottom-4 right-16 z-20 hidden md:flex gap-2">
        <CarouselPrevious className="static translate-y-0 h-10 w-10 bg-black/20 hover:bg-white text-white hover:text-primary border-none backdrop-blur-md rounded-md" />
        <CarouselNext className="static translate-y-0 h-10 w-10 bg-black/20 hover:bg-white text-white hover:text-primary border-none backdrop-blur-md rounded-md" />
      </div>
    </Carousel>
  );
}
