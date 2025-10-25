import { FilterSidebar } from '../FilterSidebar'
import { useState } from 'react'

export default function FilterSidebarExample() {
  const [priceRange, setPriceRange] = useState<[number, number]>([0, 5000])
  const [selectedBrands, setSelectedBrands] = useState<string[]>(['ASUS', 'Dell'])

  return (
    <div className="max-w-xs p-4">
      <FilterSidebar
        priceRange={priceRange}
        maxPrice={5000}
        selectedBrands={selectedBrands}
        brands={['ASUS', 'Dell', 'HP', 'Lenovo', 'MSI', 'Acer']}
        onPriceChange={(range) => {
          setPriceRange(range)
          console.log('Price range:', range)
        }}
        onBrandChange={(brands) => {
          setSelectedBrands(brands)
          console.log('Selected brands:', brands)
        }}
        onClearFilters={() => {
          setPriceRange([0, 5000])
          setSelectedBrands([])
          console.log('Filters cleared')
        }}
      />
    </div>
  )
}
