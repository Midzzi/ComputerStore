import { Header } from "@/components/Header";
import { ProductCard } from "@/components/ProductCard";
import { FilterSidebar } from "@/components/FilterSidebar";
import { Footer } from "@/components/Footer";
import { CartDrawer } from "@/components/CartDrawer";
import { useState } from "react";
import { Button } from "@/components/ui/button";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

import gamingPc from "@assets/generated_images/Gaming_PC_product_photo_98041800.png";
import laptop from "@assets/generated_images/Premium_laptop_product_photo_a37bb832.png";
import components from "@assets/generated_images/Computer_components_collection_photo_2986d14b.png";

// todo: remove mock functionality
const mockProducts = [
  {
    id: "1",
    name: "PC Gaming RTX 4090",
    price: 62499750, // ~2500 USD
    salePrice: 57499750, // ~2300 USD
    image: gamingPc,
    rating: 4.8,
    reviewCount: 156,
    stock: 8,
    specs: ["RTX 4090", "32GB RAM", "2TB SSD"],
    brand: "ASUS",
  },
  {
    id: "2",
    name: "Laptop Cao Cấp Doanh Nghiệp",
    price: 47499750, // ~1900 USD
    image: laptop,
    rating: 4.6,
    reviewCount: 89,
    stock: 15,
    specs: ["i7-13700H", "16GB RAM", "1TB SSD"],
    brand: "Dell",
  },
  {
    id: "3",
    name: "Bộ Linh Kiện Lắp Ráp",
    price: 32499750, // ~1300 USD
    salePrice: 29999750, // ~1200 USD
    image: components,
    rating: 4.9,
    reviewCount: 234,
    stock: 25,
    specs: ["RTX 4070", "DDR5 RAM", "NVMe SSD"],
    brand: "MSI",
  },
  {
    id: "4",
    name: "Máy Trạm Chuyên Nghiệp",
    price: 82499750, // ~3300 USD
    image: gamingPc,
    rating: 4.7,
    reviewCount: 67,
    stock: 5,
    specs: ["Xeon CPU", "64GB RAM", "4TB SSD"],
    brand: "HP",
  },
  {
    id: "5",
    name: "Laptop Gaming Giá Rẻ",
    price: 22499750, // ~900 USD
    image: laptop,
    rating: 4.3,
    reviewCount: 145,
    stock: 30,
    specs: ["RTX 3060", "16GB RAM", "512GB SSD"],
    brand: "Acer",
  },
  {
    id: "6",
    name: "Combo Linh Kiện Cao Cấp",
    price: 44999750, // ~1800 USD
    image: components,
    rating: 4.8,
    reviewCount: 98,
    stock: 12,
    specs: ["RTX 4080", "32GB RAM", "2TB NVMe"],
    brand: "ASUS",
  },
];

export default function Products() {
  const [cartOpen, setCartOpen] = useState(false);
  const [cartItems, setCartItems] = useState<any[]>([]);
  const [priceRange, setPriceRange] = useState<[number, number]>([0, 125000000]); // 0 - ~5000 USD in VND
  const [selectedBrands, setSelectedBrands] = useState<string[]>([]);
  const [sortBy, setSortBy] = useState("best-match");

  const brands = Array.from(new Set(mockProducts.map((p) => p.brand))).sort();

  const filteredProducts = mockProducts
    .filter((product) => {
      const price = product.salePrice || product.price;
      if (price < priceRange[0] || price > priceRange[1]) return false;
      if (
        selectedBrands.length > 0 &&
        !selectedBrands.includes(product.brand)
      )
        return false;
      return true;
    })
    .sort((a, b) => {
      if (sortBy === "price-low") return (a.salePrice || a.price) - (b.salePrice || b.price);
      if (sortBy === "price-high") return (b.salePrice || b.price) - (a.salePrice || a.price);
      if (sortBy === "rating") return (b.rating || 0) - (a.rating || 0);
      return 0;
    });

  const handleAddToCart = (productId: string) => {
    const product = mockProducts.find((p) => p.id === productId);
    if (!product) return;

    const existingItem = cartItems.find((item) => item.id === productId);
    if (existingItem) {
      setCartItems(
        cartItems.map((item) =>
          item.id === productId
            ? { ...item, quantity: item.quantity + 1 }
            : item
        )
      );
    } else {
      setCartItems([
        ...cartItems,
        {
          id: product.id,
          name: product.name,
          price: product.salePrice || product.price,
          quantity: 1,
          image: product.image,
        },
      ]);
    }
  };

  return (
    <div className="min-h-screen flex flex-col">
      <Header
        cartItemCount={cartItems.reduce((sum, item) => sum + item.quantity, 0)}
        onCartClick={() => setCartOpen(true)}
        onMenuClick={() => console.log("Menu clicked")}
        onSearch={(query) => console.log("Search:", query)}
      />

      <main className="flex-1">
        <div className="max-w-7xl mx-auto px-4 py-8">
          <div className="mb-6">
            <h1 className="text-3xl font-bold font-mono mb-2">Tất Cả Sản Phẩm</h1>
            <p className="text-muted-foreground">
              Tìm thấy {filteredProducts.length} sản phẩm
            </p>
          </div>

          <div className="flex items-center justify-between mb-6">
            <div className="flex items-center gap-2">
              <span className="text-sm text-muted-foreground">Sắp xếp:</span>
              <Select value={sortBy} onValueChange={setSortBy}>
                <SelectTrigger className="w-40" data-testid="select-sort">
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="best-match">Phù Hợp Nhất</SelectItem>
                  <SelectItem value="price-low">Giá: Thấp đến Cao</SelectItem>
                  <SelectItem value="price-high">Giá: Cao đến Thấp</SelectItem>
                  <SelectItem value="rating">Đánh Giá Cao Nhất</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>

          <div className="flex flex-col lg:flex-row gap-6">
            <aside className="lg:w-64 flex-shrink-0">
              <FilterSidebar
                priceRange={priceRange}
                maxPrice={125000000}
                selectedBrands={selectedBrands}
                brands={brands}
                onPriceChange={setPriceRange}
                onBrandChange={setSelectedBrands}
                onClearFilters={() => {
                  setPriceRange([0, 125000000]);
                  setSelectedBrands([]);
                }}
              />
            </aside>

            <div className="flex-1">
              {filteredProducts.length === 0 ? (
                <div className="text-center py-16">
                  <p className="text-lg font-semibold mb-2">Không tìm thấy sản phẩm</p>
                  <p className="text-muted-foreground mb-4">
                    Thử điều chỉnh bộ lọc của bạn
                  </p>
                  <Button
                    onClick={() => {
                      setPriceRange([0, 125000000]);
                      setSelectedBrands([]);
                    }}
                  >
                    Xóa Bộ Lọc
                  </Button>
                </div>
              ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                  {filteredProducts.map((product) => (
                    <ProductCard
                      key={product.id}
                      {...product}
                      onAddToCart={handleAddToCart}
                      onClick={(id) => console.log("View product:", id)}
                    />
                  ))}
                </div>
              )}
            </div>
          </div>
        </div>
      </main>

      <Footer />

      <CartDrawer
        isOpen={cartOpen}
        items={cartItems}
        onClose={() => setCartOpen(false)}
        onUpdateQuantity={(id, quantity) => {
          setCartItems(
            cartItems.map((item) =>
              item.id === id ? { ...item, quantity } : item
            )
          );
        }}
        onRemoveItem={(id) => {
          setCartItems(cartItems.filter((item) => item.id !== id));
        }}
        onCheckout={() => {
          console.log("Proceed to checkout");
          setCartOpen(false);
        }}
      />
    </div>
  );
}
