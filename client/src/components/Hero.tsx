import { Button } from "@/components/ui/button";
import { ArrowRight } from "lucide-react";

interface HeroProps {
  onShopNow?: () => void;
}

export function Hero({ onShopNow }: HeroProps) {
  return (
    <div className="relative min-h-[600px] flex items-center justify-center overflow-hidden">
      <div
        className="absolute inset-0 bg-cover bg-center"
        style={{
          backgroundImage: `url(/api/placeholder/1920/1080)`,
        }}
      />
      <div className="absolute inset-0 bg-gradient-to-r from-black/70 to-black/40" />

      <div className="relative z-10 max-w-7xl mx-auto px-4 text-center space-y-6">
        <h1 className="text-5xl md:text-7xl font-bold text-white font-mono" data-testid="text-hero-title">
          Upgrade Your Tech Arsenal
        </h1>
        <p className="text-xl md:text-2xl text-white/90 max-w-2xl mx-auto" data-testid="text-hero-subtitle">
          Discover premium computers, laptops, and components for gaming, work, and everything in between
        </p>
        <div className="flex gap-4 justify-center flex-wrap">
          <Button
            size="lg"
            className="gap-2 bg-primary text-primary-foreground border border-primary-border"
            onClick={onShopNow}
            data-testid="button-shop-now"
          >
            Shop Now
            <ArrowRight className="h-5 w-5" />
          </Button>
          <Button
            size="lg"
            variant="outline"
            className="gap-2 bg-background/10 backdrop-blur-sm border-white/20 text-white hover:bg-background/20"
            data-testid="button-view-deals"
          >
            View Deals
          </Button>
        </div>
      </div>
    </div>
  );
}
