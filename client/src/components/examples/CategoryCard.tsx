import { CategoryCard } from '../CategoryCard'
import gamingPc from '@assets/generated_images/Gaming_PC_product_photo_98041800.png'

export default function CategoryCardExample() {
  return (
    <div className="max-w-sm p-4">
      <CategoryCard
        title="Gaming PCs"
        image={gamingPc}
        productCount={48}
        onClick={() => console.log('Category clicked')}
      />
    </div>
  )
}
