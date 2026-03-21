"use client";

import React, { useState, useMemo } from "react";
import { BlogCard } from "@/components/blog/BlogCard";
import { Search } from "lucide-react";

export interface Category {
  id: number;
  tendm: string;
  slug?: string;
}

export interface Post {
  id: number;
  tieude: string;
  anhdaidien?: string;
  hinhanh?: string;
  img?: string;
  hinh?: string;
  slug?: string;
  danhmuc?: Category;
  danhmucbaiviet?: Category;
  tomtat?: string;
  noidung?: string;
  created_at?: string;
}

import { BlogHero } from "@/components/blog/BlogHero";

export interface BlogClientProps {
  initialPosts: Post[];
  categories: Category[];
}

export function BlogClient({ initialPosts, categories }: BlogClientProps) {
  const [searchQuery, setSearchQuery] = useState("");
  const [activeCategory, setActiveCategory] = useState("All");

  const featuredPosts = initialPosts.slice(0, 4); // Lấy 4 bài mới nhất cho hero banner

  const filteredPosts = useMemo(() => {
    return initialPosts.filter((post) => {
      // Logic Lọc theo Category
      const postCategory = post.danhmucbaiviet?.tendm || post.danhmuc?.tendm || "STORY";
      const matchesCategory = activeCategory === "All" || postCategory === activeCategory;

      // Logic Lọc theo Search Query
      const searchLower = searchQuery.toLowerCase();
      const matchesSearch =
        post.tieude.toLowerCase().includes(searchLower) ||
        (post.tomtat || "").toLowerCase().includes(searchLower) ||
        (post.noidung || "").toLowerCase().includes(searchLower);

      return matchesCategory && matchesSearch;
    });
  }, [initialPosts, activeCategory, searchQuery]);

  return (
    <div className="min-h-screen pb-20 bg-[#F9F9F9]">
      <main className="max-w-[1200px] mx-auto px-4 pt-16 md:pt-24 space-y-12">
        
        {/* Full-width Hero Banner with latest posts */}
        {featuredPosts.length > 0 && <BlogHero posts={featuredPosts} />}

        {/* Header Section from Figure 2 */}
        <div className="space-y-4">
          <h1 className="text-4xl md:text-5xl font-bold font-inter tracking-tight text-neutral-900">
            Blog
          </h1>
          <p className="text-neutral-500 text-lg max-w-2xl font-inter">
            Here, we share travel tips, destination guides, and stories that inspire your next adventure.
          </p>
        </div>

        {/* Filters and Search Bar */}
        <div className="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 pb-4 border-b border-neutral-200">
          
          {/* Categories Pill List */}
          <div className="flex flex-wrap items-center gap-2">
            <button
              onClick={() => setActiveCategory("All")}
              className={`px-5 py-2.5 rounded-full text-sm font-semibold transition-all ${
                activeCategory === "All"
                  ? "bg-neutral-900 text-white shadow-xl"
                  : "bg-white text-neutral-600 hover:bg-neutral-100 border border-neutral-200"
              }`}
            >
              All
            </button>
            {categories.map((cat) => (
              <button
                key={cat.id}
                onClick={() => setActiveCategory(cat.tendm)}
                className={`px-5 py-2.5 rounded-full text-sm font-semibold transition-all ${
                  activeCategory === cat.tendm
                    ? "bg-neutral-900 text-white shadow-xl"
                    : "bg-white text-neutral-600 hover:bg-neutral-100 border border-neutral-200"
                }`}
              >
                {cat.tendm}
              </button>
            ))}
          </div>

          {/* Search Box */}
          <div className="relative w-full lg:w-72">
            <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <Search className="h-5 w-5 text-neutral-400" />
            </div>
            <input
              type="text"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              placeholder="Tìm kiếm bài viết..."
              className="pl-11 pr-4 py-3 w-full bg-white border border-neutral-200 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-neutral-900 transition-all shadow-sm"
            />
          </div>
        </div>

        {/* Blog Post Grid */}
        {filteredPosts.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filteredPosts.map((post) => (
              <BlogCard key={post.id} post={post} />
            ))}
          </div>
        ) : (
          <div className="py-20 text-center flex flex-col items-center">
             <div className="w-20 h-20 bg-neutral-100 rounded-full flex items-center justify-center mb-6">
                <Search className="h-8 w-8 text-neutral-400" />
             </div>
            <h3 className="text-xl font-bold text-neutral-900 mb-2">Không tìm thấy bài viết nào</h3>
            <p className="text-neutral-500">
              Rất tiếc, không có bài viết nào khớp với tìm kiếm "{searchQuery}".
            </p>
          </div>
        )}
      </main>
    </div>
  );
}
