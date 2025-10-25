import { Search, ShoppingCart, Menu } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import { ThemeToggle } from "./ThemeToggle";
import { Link } from "wouter";

interface HeaderProps {
  cartItemCount?: number;
  onCartClick?: () => void;
  onMenuClick?: () => void;
  onSearch?: (query: string) => void;
}

export function Header({ cartItemCount = 0, onCartClick, onMenuClick, onSearch }: HeaderProps) {
  return (
    <header className="sticky top-0 z-50 bg-background border-b">
      <div className="max-w-7xl mx-auto px-4">
        <div className="flex items-center justify-between gap-4 h-16">
          <div className="flex items-center gap-4">
            <Button
              variant="ghost"
              size="icon"
              onClick={onMenuClick}
              className="md:hidden"
              data-testid="button-menu"
            >
              <Menu className="h-5 w-5" />
            </Button>
            <Link href="/">
              <h1 className="text-2xl font-bold font-mono cursor-pointer" data-testid="link-home">
                TechStore
              </h1>
            </Link>
          </div>

          <div className="hidden md:flex items-center flex-1 max-w-2xl">
            <div className="relative w-full">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                type="search"
                placeholder="Search products..."
                className="pl-10"
                onChange={(e) => onSearch?.(e.target.value)}
                data-testid="input-search"
              />
            </div>
          </div>

          <div className="flex items-center gap-2">
            <ThemeToggle />
            <Button
              variant="ghost"
              size="icon"
              className="relative"
              onClick={onCartClick}
              data-testid="button-cart"
            >
              <ShoppingCart className="h-5 w-5" />
              {cartItemCount > 0 && (
                <Badge
                  variant="destructive"
                  className="absolute -top-1 -right-1 h-5 w-5 rounded-full p-0 flex items-center justify-center text-xs"
                  data-testid="badge-cart-count"
                >
                  {cartItemCount}
                </Badge>
              )}
            </Button>
          </div>
        </div>

        <div className="md:hidden pb-3">
          <div className="relative">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            <Input
              type="search"
              placeholder="Search products..."
              className="pl-10"
              onChange={(e) => onSearch?.(e.target.value)}
              data-testid="input-search-mobile"
            />
          </div>
        </div>
      </div>

      <div className="border-t hidden md:block">
        <div className="max-w-7xl mx-auto px-4">
          <nav className="flex items-center gap-6 h-12 text-sm">
            <Link href="/category/desktop">
              <span className="hover-elevate px-3 py-2 rounded-md cursor-pointer" data-testid="link-desktop">
                Desktop Computers
              </span>
            </Link>
            <Link href="/category/laptop">
              <span className="hover-elevate px-3 py-2 rounded-md cursor-pointer" data-testid="link-laptop">
                Laptops
              </span>
            </Link>
            <Link href="/category/components">
              <span className="hover-elevate px-3 py-2 rounded-md cursor-pointer" data-testid="link-components">
                Components
              </span>
            </Link>
            <Link href="/category/peripherals">
              <span className="hover-elevate px-3 py-2 rounded-md cursor-pointer" data-testid="link-peripherals">
                Peripherals
              </span>
            </Link>
          </nav>
        </div>
      </div>
    </header>
  );
}
