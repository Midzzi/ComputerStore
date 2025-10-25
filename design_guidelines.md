# Design Guidelines: Computer & Laptop E-Commerce Platform

## Design Approach: Reference-Based (E-Commerce Leaders)

**Primary References**: Newegg (tech-focused), Amazon (functionality), Shopify stores (modern aesthetics)

**Core Principles**:
- Trust through clarity: Clear product information, prominent pricing, visible stock status
- Efficient browsing: Quick category navigation, robust filtering, visual product comparison
- Purchase confidence: High-quality product images, detailed specifications, customer reviews

---

## Typography System

**Font Families** (Google Fonts):
- **Primary**: Inter (interface, body text, specifications)
- **Accent**: Space Grotesk (headings, pricing, CTAs)

**Hierarchy**:
- Hero Headline: 3xl-5xl, bold, Space Grotesk
- Product Names: xl-2xl, semibold, Inter
- Section Headers: 2xl-3xl, bold, Space Grotesk
- Price Display: 2xl-3xl, bold, accent color emphasis
- Body Text: base-lg, regular, Inter
- Specifications: sm-base, medium, monospace feel
- Labels/Metadata: xs-sm, medium, uppercase tracking

---

## Layout System

**Spacing Primitives**: Tailwind units of **2, 4, 6, 8, 12, 16**
- Tight spacing: p-2, gap-2 (tags, badges)
- Standard spacing: p-4, gap-4, mb-6 (cards, buttons)
- Section spacing: py-12, py-16, py-20 (page sections)
- Generous spacing: p-8, gap-8 (product details, cart)

**Container Strategy**:
- Page wrapper: max-w-7xl mx-auto px-4
- Product grids: w-full with responsive columns
- Product details: max-w-6xl split layout
- Cart sidebar: fixed w-96 on desktop

**Grid Patterns**:
- Desktop: 4 columns for product cards (grid-cols-4)
- Tablet: 3 columns (md:grid-cols-3)
- Mobile: 1-2 columns (grid-cols-1 sm:grid-cols-2)

---

## Component Library

### Navigation
**Header Structure**:
- Sticky top navigation with logo, category mega-menu, search bar, cart icon with badge
- Secondary bar: Category quick links (Desktop Computers | Laptops | Components | Peripherals | Accessories)
- Mobile: Hamburger menu with slide-out drawer

**Search Component**:
- Prominent search bar (min-w-96) with autocomplete dropdown
- Search suggestions showing product thumbnails + names
- Advanced filters toggle button

### Product Components

**Product Card** (Primary):
- Product image (aspect-ratio-square, object-cover)
- Hover: Quick view overlay with "Add to Cart" + "Details" buttons (blurred backdrop)
- Product name (line-clamp-2)
- Specification highlights (3-4 key specs in badge format)
- Price display (regular + sale price if applicable)
- Stock indicator (In Stock badge, Low Stock warning, Out of Stock status)
- Rating stars + review count

**Product Detail Layout**:
- Two-column split (60/40):
  - Left: Image gallery with main image + 4-6 thumbnails
  - Right: Product info, price, quantity selector, Add to Cart CTA
- Full-width tabs below: Specifications | Description | Reviews | Q&A
- Related products carousel at bottom

**Category Filter Sidebar**:
- Collapsible sections: Price Range (slider), Brand (checkboxes), Specs (CPU, RAM, Storage, GPU)
- Active filters display with remove capability
- Clear all filters button

### Shopping Cart

**Cart Drawer** (Slide from right):
- Item list with thumbnail, name, price, quantity controls (-, +, remove)
- Subtotal calculation
- "View Cart" and "Checkout" CTAs
- Empty state illustration when cart is empty

**Cart Page**:
- Full item details table with columns: Product | Price | Quantity | Total
- Promo code input field
- Order summary box (sticky on scroll): Subtotal, Shipping, Tax, Total
- Proceed to Checkout CTA

### Checkout Flow
**Multi-step indicator**: Shipping → Payment → Review
- Form sections with clear labels
- Order summary sidebar (persistent)
- Trust badges (Secure Checkout, Money-back Guarantee)
- Payment method icons

---

## Page Structures

### Homepage

**Hero Section** (h-screen or min-h-[600px]):
- Large hero image: High-quality tech lifestyle shot (gaming setup, modern workspace, or flagship laptop)
- Overlay: Bold headline ("Upgrade Your Tech Arsenal"), subheadline, CTA button with blurred backdrop
- Animated subtle particles/grid pattern in background

**Featured Categories** (3-column grid):
- Large category cards with product images, category name, "Shop Now" link
- Categories: Gaming PCs | Professional Laptops | Custom Builds

**Trending Products** (4-column carousel):
- "Hot Deals" section with countdown timer badges
- Product cards with special pricing highlight

**Why Choose Us** (3-column feature grid):
- Icons from Heroicons: ShieldCheck (Warranty), Truck (Free Shipping), ChatBubble (24/7 Support)
- Short benefit descriptions

**Newsletter + Footer**:
- Newsletter signup with email input, incentive ("Get 10% off first order")
- Footer: Quick links, Categories, Support info, Social media, Payment method icons

### Product Listing Page

**Structure**:
- Breadcrumb navigation
- Page header: Category name, product count, sort dropdown (Best Match | Price Low-High | Newest)
- Filter sidebar (left, 25% width) + Product grid (right, 75% width)
- Pagination with load more option

### Product Detail Page

**Above the Fold**:
- Image gallery + Product info side-by-side
- Prominent "Add to Cart" + "Buy Now" buttons (different visual weights)
- Key specs list, stock status, shipping estimate

**Content Tabs**:
- Technical specifications table (organized by category)
- Product description with rich formatting
- Customer reviews with star rating distribution graph
- Q&A section

---

## Images

**Required Images**:
1. **Hero**: Modern tech workspace with multiple monitors, RGB lighting, premium laptop (landscape, 1920x1080+)
2. **Category Cards**: Close-up product shots (gaming PC with RGB, sleek laptop, components array)
3. **Product Images**: High-res product photos on white background + lifestyle context shots
4. **Trust Badges**: Payment provider logos, security seals
5. **Empty States**: Illustration for empty cart, no search results

**Image Treatment**:
- Sharp, professional product photography
- Consistent white or subtle gradient backgrounds for product shots
- Lifestyle images with natural lighting for hero/category sections

---

## Interaction Patterns

**Micro-interactions**:
- Cart badge bounce animation when item added
- Product card subtle lift on hover (translate-y-1)
- Add to Cart button success state (checkmark + "Added" text, 2s duration)
- Quantity selector with smooth number transitions

**Loading States**:
- Skeleton screens for product grids
- Shimmer effect on loading cards
- Progress indicator for checkout steps

**Animations**: Minimal and purposeful
- Page transitions: Subtle fade
- Modal/drawer entry: Slide + fade
- No auto-playing carousels or distracting effects

---

## Accessibility & Quality

- All interactive elements have visible focus states
- Form inputs with clear labels, error messages inline
- Alt text for all product images
- Keyboard navigation throughout
- ARIA labels for icon-only buttons
- Color contrast meeting WCAG AA standards

**Icons**: Heroicons (outline for navigation, solid for filled states)

This design creates a professional, conversion-optimized e-commerce experience that balances visual appeal with functional efficiency, building trust through clarity while maintaining modern aesthetics.