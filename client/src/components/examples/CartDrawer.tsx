import { CartDrawer } from '../CartDrawer'
import { useState } from 'react'
import gamingPc from '@assets/generated_images/Gaming_PC_product_photo_98041800.png'
import laptop from '@assets/generated_images/Premium_laptop_product_photo_a37bb832.png'

export default function CartDrawerExample() {
  const [items, setItems] = useState([
    {
      id: '1',
      name: 'Gaming Desktop PC RTX 4090',
      price: 2299.99,
      quantity: 1,
      image: gamingPc,
    },
    {
      id: '2',
      name: 'Premium Business Laptop',
      price: 1599.99,
      quantity: 2,
      image: laptop,
    },
  ])

  return (
    <CartDrawer
      isOpen={true}
      items={items}
      onClose={() => console.log('Close cart')}
      onUpdateQuantity={(id, quantity) => {
        setItems(items.map(item => item.id === id ? { ...item, quantity } : item))
        console.log('Update quantity:', id, quantity)
      }}
      onRemoveItem={(id) => {
        setItems(items.filter(item => item.id !== id))
        console.log('Remove item:', id)
      }}
      onCheckout={() => console.log('Checkout')}
    />
  )
}
