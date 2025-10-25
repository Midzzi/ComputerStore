import { Card } from "@/components/ui/card";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import { Slider } from "@/components/ui/slider";
import { Button } from "@/components/ui/button";
import { X } from "lucide-react";

interface FilterSidebarProps {
  priceRange: [number, number];
  maxPrice?: number;
  selectedBrands: string[];
  brands: string[];
  onPriceChange?: (range: [number, number]) => void;
  onBrandChange?: (brands: string[]) => void;
  onClearFilters?: () => void;
}

export function FilterSidebar({
  priceRange,
  maxPrice = 5000,
  selectedBrands,
  brands,
  onPriceChange,
  onBrandChange,
  onClearFilters,
}: FilterSidebarProps) {
  const handleBrandToggle = (brand: string) => {
    const newBrands = selectedBrands.includes(brand)
      ? selectedBrands.filter((b) => b !== brand)
      : [...selectedBrands, brand];
    onBrandChange?.(newBrands);
  };

  return (
    <Card className="p-4 space-y-6">
      <div className="flex items-center justify-between">
        <h3 className="font-bold text-lg">Filters</h3>
        {(selectedBrands.length > 0 || priceRange[0] > 0 || priceRange[1] < maxPrice) && (
          <Button
            variant="ghost"
            size="sm"
            onClick={onClearFilters}
            className="gap-1"
            data-testid="button-clear-filters"
          >
            <X className="h-3 w-3" />
            Clear
          </Button>
        )}
      </div>

      <div className="space-y-3">
        <Label className="text-sm font-semibold">Price Range</Label>
        <div className="space-y-4">
          <Slider
            value={priceRange}
            max={maxPrice}
            step={100}
            onValueChange={(value) => onPriceChange?.(value as [number, number])}
            className="w-full"
            data-testid="slider-price"
          />
          <div className="flex items-center justify-between text-sm">
            <span className="font-mono" data-testid="text-min-price">${priceRange[0]}</span>
            <span className="font-mono" data-testid="text-max-price">${priceRange[1]}</span>
          </div>
        </div>
      </div>

      <div className="space-y-3">
        <Label className="text-sm font-semibold">Brand</Label>
        <div className="space-y-2">
          {brands.map((brand) => (
            <div key={brand} className="flex items-center gap-2">
              <Checkbox
                id={`brand-${brand}`}
                checked={selectedBrands.includes(brand)}
                onCheckedChange={() => handleBrandToggle(brand)}
                data-testid={`checkbox-brand-${brand}`}
              />
              <Label
                htmlFor={`brand-${brand}`}
                className="text-sm cursor-pointer flex-1"
              >
                {brand}
              </Label>
            </div>
          ))}
        </div>
      </div>
    </Card>
  );
}
