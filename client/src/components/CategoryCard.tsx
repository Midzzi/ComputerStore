import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { ArrowRight } from "lucide-react";

interface CategoryCardProps {
  title: string;
  image: string;
  productCount?: number;
  onClick?: () => void;
}

export function CategoryCard({ title, image, productCount, onClick }: CategoryCardProps) {
  return (
    <Card className="group overflow-hidden hover-elevate cursor-pointer" onClick={onClick} data-testid={`card-category-${title}`}>
      <div className="aspect-[4/3] overflow-hidden bg-muted">
        <img
          src={image}
          alt={title}
          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          data-testid={`img-category-${title}`}
        />
      </div>
      <div className="p-6 space-y-3">
        <h3 className="text-2xl font-bold font-mono" data-testid={`text-category-title-${title}`}>
          {title}
        </h3>
        {productCount && (
          <p className="text-sm text-muted-foreground" data-testid={`text-category-count-${title}`}>
            {productCount} Sản Phẩm
          </p>
        )}
        <Button variant="outline" className="gap-2 group" data-testid={`button-shop-${title}`}>
          Mua Ngay
          <ArrowRight className="h-4 w-4 group-hover:translate-x-1 transition-transform" />
        </Button>
      </div>
    </Card>
  );
}
