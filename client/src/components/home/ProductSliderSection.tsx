import { Button } from "@/components/ui/button";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
import { ProductCard } from "@/components/product/ProductCard";

export function ProductSliderSection({ title, products }: { title: string, products: any[] }) {
  if (!products || products.length === 0) return null;

  return (
    <section className="space-y-8">
      <div className="flex items-center justify-between">
        <h3 className="font-merriweather text-3xl font-bold">{title}</h3>
        <Button variant="link" className="text-primary hover:text-primary/80">Xem tất cả</Button>
      </div>
      <Carousel opts={{ align: "start" }} className="w-full">
        <CarouselContent>
          {products.map((item: any, idx: number) => (
            <CarouselItem key={item.id || idx} className="basis-[80%] md:basis-1/2 lg:basis-1/4 pl-6">
              <ProductCard product={item} />
            </CarouselItem>
          ))}
        </CarouselContent>
        <CarouselPrevious className="hidden md:flex -left-6 bg-white/80 hover:bg-white shadow-md border-transparent text-primary" />
        <CarouselNext className="hidden md:flex -right-6 bg-white/80 hover:bg-white shadow-md border-transparent text-primary" />
      </Carousel>
    </section>
  );
}
