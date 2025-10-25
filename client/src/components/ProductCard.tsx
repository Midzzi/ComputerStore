import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Star, ShoppingCart } from "lucide-react";

interface ProductCardProps {
  id: string;
  name: string;
  price: number;
  salePrice?: number;
  image: string;
  rating?: number;
  reviewCount?: number;
  stock: number;
  specs?: string[];
  onAddToCart?: (id: string) => void;
  onClick?: (id: string) => void;
}

export function ProductCard({
  id,
  name,
  price,
  salePrice,
  image,
  rating = 0,
  reviewCount = 0,
  stock,
  specs = [],
  onAddToCart,
  onClick,
}: ProductCardProps) {
  const isOnSale = salePrice && salePrice < price;
  const displayPrice = isOnSale ? salePrice : price;

  return (
    <Card
      className="group overflow-hidden hover-elevate cursor-pointer"
      onClick={() => onClick?.(id)}
      data-testid={`card-product-${id}`}
    >
      <div className="aspect-square overflow-hidden bg-muted">
        <img
          src={image}
          alt={name}
          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          data-testid={`img-product-${id}`}
        />
      </div>

      <div className="p-4 space-y-3">
        <div className="space-y-1">
          <h3 className="font-semibold line-clamp-2 min-h-[3rem]" data-testid={`text-name-${id}`}>
            {name}
          </h3>

          {specs.length > 0 && (
            <div className="flex flex-wrap gap-1">
              {specs.slice(0, 3).map((spec, i) => (
                <Badge key={i} variant="secondary" className="text-xs" data-testid={`badge-spec-${id}-${i}`}>
                  {spec}
                </Badge>
              ))}
            </div>
          )}
        </div>

        <div className="flex items-center gap-2">
          {rating > 0 && (
            <>
              <div className="flex items-center gap-1">
                <Star className="h-4 w-4 fill-primary text-primary" />
                <span className="text-sm font-medium" data-testid={`text-rating-${id}`}>
                  {rating}
                </span>
              </div>
              <span className="text-xs text-muted-foreground" data-testid={`text-reviews-${id}`}>
                ({reviewCount})
              </span>
            </>
          )}
        </div>

        <div className="space-y-2">
          <div className="flex items-baseline gap-2">
            <span className="text-2xl font-bold font-mono" data-testid={`text-price-${id}`}>
              ${displayPrice.toFixed(2)}
            </span>
            {isOnSale && (
              <span className="text-sm text-muted-foreground line-through" data-testid={`text-original-price-${id}`}>
                ${price.toFixed(2)}
              </span>
            )}
          </div>

          {stock > 0 ? (
            <Badge variant={stock < 10 ? "destructive" : "default"} className="text-xs" data-testid={`badge-stock-${id}`}>
              {stock < 10 ? `Only ${stock} left` : "In Stock"}
            </Badge>
          ) : (
            <Badge variant="secondary" className="text-xs" data-testid={`badge-out-stock-${id}`}>
              Out of Stock
            </Badge>
          )}
        </div>

        <Button
          className="w-full gap-2"
          disabled={stock === 0}
          onClick={(e) => {
            e.stopPropagation();
            onAddToCart?.(id);
          }}
          data-testid={`button-add-cart-${id}`}
        >
          <ShoppingCart className="h-4 w-4" />
          Add to Cart
        </Button>
      </div>
    </Card>
  );
}
