import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { X, Minus, Plus, Trash2, ShoppingBag } from "lucide-react";
import { Card } from "@/components/ui/card";

interface CartItem {
  id: string;
  name: string;
  price: number;
  quantity: number;
  image: string;
}

interface CartDrawerProps {
  isOpen: boolean;
  items: CartItem[];
  onClose: () => void;
  onUpdateQuantity?: (id: string, quantity: number) => void;
  onRemoveItem?: (id: string) => void;
  onCheckout?: () => void;
}

export function CartDrawer({
  isOpen,
  items,
  onClose,
  onUpdateQuantity,
  onRemoveItem,
  onCheckout,
}: CartDrawerProps) {
  const subtotal = items.reduce((sum, item) => sum + item.price * item.quantity, 0);

  if (!isOpen) return null;

  return (
    <>
      <div
        className="fixed inset-0 bg-black/50 z-40"
        onClick={onClose}
        data-testid="overlay-cart"
      />
      <div
        className="fixed right-0 top-0 h-full w-full md:w-96 bg-background border-l z-50 flex flex-col shadow-xl"
        data-testid="drawer-cart"
      >
        <div className="flex items-center justify-between p-4 border-b">
          <h2 className="text-lg font-bold">Giỏ Hàng</h2>
          <Button variant="ghost" size="icon" onClick={onClose} data-testid="button-close-cart">
            <X className="h-5 w-5" />
          </Button>
        </div>

        <div className="flex-1 overflow-y-auto p-4">
          {items.length === 0 ? (
            <div className="flex flex-col items-center justify-center h-full text-center space-y-4">
              <ShoppingBag className="h-16 w-16 text-muted-foreground" />
              <div className="space-y-2">
                <p className="font-semibold" data-testid="text-empty-cart">Giỏ hàng trống</p>
                <p className="text-sm text-muted-foreground">Thêm sản phẩm để bắt đầu</p>
              </div>
            </div>
          ) : (
            <div className="space-y-4">
              {items.map((item) => (
                <Card key={item.id} className="p-4" data-testid={`cart-item-${item.id}`}>
                  <div className="flex gap-4">
                    <img
                      src={item.image}
                      alt={item.name}
                      className="w-20 h-20 object-cover rounded-md bg-muted"
                      data-testid={`img-cart-${item.id}`}
                    />
                    <div className="flex-1 space-y-2">
                      <h3 className="font-semibold text-sm line-clamp-2" data-testid={`text-cart-name-${item.id}`}>
                        {item.name}
                      </h3>
                      <p className="text-lg font-bold font-mono" data-testid={`text-cart-price-${item.id}`}>
                        ${item.price.toFixed(2)}
                      </p>
                      <div className="flex items-center justify-between gap-2">
                        <div className="flex items-center gap-2">
                          <Button
                            size="icon"
                            variant="outline"
                            className="h-8 w-8"
                            onClick={() => onUpdateQuantity?.(item.id, Math.max(1, item.quantity - 1))}
                            data-testid={`button-decrease-${item.id}`}
                          >
                            <Minus className="h-3 w-3" />
                          </Button>
                          <Badge variant="secondary" data-testid={`text-quantity-${item.id}`}>
                            {item.quantity}
                          </Badge>
                          <Button
                            size="icon"
                            variant="outline"
                            className="h-8 w-8"
                            onClick={() => onUpdateQuantity?.(item.id, item.quantity + 1)}
                            data-testid={`button-increase-${item.id}`}
                          >
                            <Plus className="h-3 w-3" />
                          </Button>
                        </div>
                        <Button
                          size="icon"
                          variant="ghost"
                          className="h-8 w-8 text-destructive"
                          onClick={() => onRemoveItem?.(item.id)}
                          data-testid={`button-remove-${item.id}`}
                        >
                          <Trash2 className="h-4 w-4" />
                        </Button>
                      </div>
                    </div>
                  </div>
                </Card>
              ))}
            </div>
          )}
        </div>

        {items.length > 0 && (
          <div className="border-t p-4 space-y-4">
            <div className="flex items-center justify-between text-lg">
              <span className="font-semibold">Tạm Tính:</span>
              <span className="font-bold font-mono" data-testid="text-subtotal">
                ${subtotal.toFixed(2)}
              </span>
            </div>
            <Button className="w-full" size="lg" onClick={onCheckout} data-testid="button-checkout">
              Thanh Toán
            </Button>
          </div>
        )}
      </div>
    </>
  );
}
