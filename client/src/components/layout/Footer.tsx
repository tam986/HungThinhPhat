import { Button } from "@/components/ui/button";

export function Footer() {
  return (
    <footer className="mt-32 pt-20 pb-10 bg-secondary/10">
      <div className="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-12">
        <div className="space-y-4">
          <h2 className="font-merriweather text-xl font-bold text-primary">Mekong</h2>
          <p className="text-muted-foreground">Authentic tastes from the delta, carefully curated for your elegance.</p>
        </div>
        <div className="space-y-4">
          <h3 className="font-bold">Explore</h3>
          <ul className="space-y-2 text-muted-foreground">
            <li>Products</li>
            <li>Our Story</li>
            <li>Journal</li>
          </ul>
        </div>
        <div className="space-y-4">
          <h3 className="font-bold">Assistance</h3>
          <ul className="space-y-2 text-muted-foreground">
            <li>Shipping & Returns</li>
            <li>Contact Us</li>
            <li>FAQ</li>
          </ul>
        </div>
        <div className="space-y-4">
          <h3 className="font-bold">Newsletter</h3>
          <p className="text-sm text-muted-foreground">Sign up to get 10% off your first prestige order.</p>
          <div className="flex bg-white rounded-full overflow-hidden shadow-sm shadow-black/5 p-1 border">
            <input type="email" placeholder="Your essence..." className="flex-1 bg-transparent px-4 py-2 border-none outline-none focus:ring-0 text-sm" />
            <Button className="rounded-full bg-primary hover:bg-primary/90 text-white px-6">Subscribe</Button>
          </div>
        </div>
      </div>
    </footer>
  );
}
