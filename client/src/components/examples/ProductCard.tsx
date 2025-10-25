import { ProductCard } from '../ProductCard'
import heroImage from '@assets/generated_images/Gaming_PC_product_photo_98041800.png'

export default function ProductCardExample() {
  return (
    <div className="max-w-sm p-4">
      <ProductCard
        id="1"
        name="Gaming Desktop PC RTX 4090"
        price={2499.99}
        salePrice={2299.99}
        image={heroImage}
        rating={4.8}
        reviewCount={156}
        stock={8}
        specs={["RTX 4090", "32GB RAM", "2TB SSD"]}
        onAddToCart={(id) => console.log('Add to cart:', id)}
        onClick={(id) => console.log('View product:', id)}
      />
    </div>
  )
}
