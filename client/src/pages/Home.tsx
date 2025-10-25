import { Header } from "@/components/Header";
import { Hero } from "@/components/Hero";
import { CategoryCard } from "@/components/CategoryCard";
import { ProductCard } from "@/components/ProductCard";
import { Footer } from "@/components/Footer";
import { CartDrawer } from "@/components/CartDrawer";
import { useState } from "react";
import { ShieldCheck, Truck, Headphones } from "lucide-react";
import { Card } from "@/components/ui/card";

import heroImage from "@assets/generated_images/Gaming_workspace_hero_image_20d00825.png";
import gamingPc from "@assets/generated_images/Gaming_PC_product_photo_98041800.png";
import laptop from "@assets/generated_images/Premium_laptop_product_photo_a37bb832.png";
import components from "@assets/generated_images/Computer_components_collection_photo_2986d14b.png";

// todo: remove mock functionality
const mockProducts = [
  {
    id: "1",
    name: "PC Gaming RTX 4090",
    price: 2499.99,
    salePrice: 2299.99,
    image: gamingPc,
    rating: 4.8,
    reviewCount: 156,
    stock: 8,
    specs: ["RTX 4090", "32GB RAM", "2TB SSD"],
  },
  {
    id: "2",
    name: "Laptop Cao Cấp Doanh Nghiệp",
    price: 1899.99,
    image: laptop,
    rating: 4.6,
    reviewCount: 89,
    stock: 15,
    specs: ["i7-13700H", "16GB RAM", "1TB SSD"],
  },
  {
    id: "3",
    name: "Bộ Linh Kiện Lắp Ráp",
    price: 1299.99,
    salePrice: 1199.99,
    image: components,
    rating: 4.9,
    reviewCount: 234,
    stock: 25,
    specs: ["RTX 4070", "DDR5 RAM", "NVMe SSD"],
  },
  {
    id: "4",
    name: "Máy Trạm Chuyên Nghiệp",
    price: 3299.99,
    image: gamingPc,
    rating: 4.7,
    reviewCount: 67,
    stock: 5,
    specs: ["Xeon CPU", "64GB RAM", "4TB SSD"],
  },
];

export default function Home() {
  const [cartOpen, setCartOpen] = useState(false);
  const [cartItems, setCartItems] = useState<any[]>([]);

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
    console.log("Added to cart:", productId);
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
        <div
          className="relative min-h-[600px] flex items-center justify-center overflow-hidden"
          style={{
            backgroundImage: `url(${heroImage})`,
            backgroundSize: "cover",
            backgroundPosition: "center",
          }}
        >
          <div className="absolute inset-0 bg-gradient-to-r from-black/70 to-black/40" />
          <Hero onShopNow={() => window.scrollTo({ top: 800, behavior: "smooth" })} />
        </div>

        <section className="max-w-7xl mx-auto px-4 py-16">
          <h2 className="text-3xl font-bold text-center mb-12 font-mono">
            Danh Mục Sản Phẩm
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <CategoryCard
              title="PC Gaming"
              image={gamingPc}
              productCount={48}
              onClick={() => console.log("Navigate to Gaming PCs")}
            />
            <CategoryCard
              title="Laptop"
              image={laptop}
              productCount={92}
              onClick={() => console.log("Navigate to Laptops")}
            />
            <CategoryCard
              title="Linh Kiện"
              image={components}
              productCount={156}
              onClick={() => console.log("Navigate to Components")}
            />
          </div>
        </section>

        <section className="max-w-7xl mx-auto px-4 py-16">
          <div className="flex items-center justify-between mb-8">
            <h2 className="text-3xl font-bold font-mono">Sản Phẩm Nổi Bật</h2>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {mockProducts.map((product) => (
              <ProductCard
                key={product.id}
                {...product}
                onAddToCart={handleAddToCart}
                onClick={(id) => console.log("View product:", id)}
              />
            ))}
          </div>
        </section>

        <section className="bg-card py-16">
          <div className="max-w-7xl mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-12 font-mono">
              Tại Sao Chọn TechStore
            </h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              <Card className="p-6 text-center space-y-4">
                <div className="flex justify-center">
                  <div className="p-4 bg-primary/10 rounded-full">
                    <ShieldCheck className="h-8 w-8 text-primary" />
                  </div>
                </div>
                <h3 className="font-bold text-xl">Bảo Hành 2 Năm</h3>
                <p className="text-muted-foreground">
                  Tất cả sản phẩm đều có chế độ bảo hành toàn diện
                </p>
              </Card>
              <Card className="p-6 text-center space-y-4">
                <div className="flex justify-center">
                  <div className="p-4 bg-primary/10 rounded-full">
                    <Truck className="h-8 w-8 text-primary" />
                  </div>
                </div>
                <h3 className="font-bold text-xl">Miễn Phí Vận Chuyển</h3>
                <p className="text-muted-foreground">
                  Miễn phí vận chuyển cho đơn hàng trên $500
                </p>
              </Card>
              <Card className="p-6 text-center space-y-4">
                <div className="flex justify-center">
                  <div className="p-4 bg-primary/10 rounded-full">
                    <Headphones className="h-8 w-8 text-primary" />
                  </div>
                </div>
                <h3 className="font-bold text-xl">Hỗ Trợ 24/7</h3>
                <p className="text-muted-foreground">
                  Đội ngũ chuyên gia sẵn sàng hỗ trợ mọi lúc
                </p>
              </Card>
            </div>
          </div>
        </section>
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
