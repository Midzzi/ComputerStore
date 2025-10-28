const products = [
  {
    id: 'p1',
    name: 'Gaming PC X300',
    price: '$1,899',
    description: 'High performance gaming PC with RTX-class GPU',
    image: 'images/Gaming_PC_product_photo_98041800.png'
  },
  {
    id: 'p2',
    name: 'Premium Laptop 14"',
    price: '$1,299',
    description: 'Thin, light, and powerful for creators',
    image: 'images/Premium_laptop_product_photo_a37bb832.png'
  },
  {
    id: 'p3',
    name: 'Workspace Setup',
    price: '$549',
    description: 'Ergonomic desk setup for productivity',
    image: 'images/Gaming_workspace_hero_image_20d00825.png'
  }
];

function createCard(p){
  const el = document.createElement('div');
  el.className = 'card';
  el.innerHTML = `
    <img src="${p.image}" alt="${p.name}">
    <h4>${p.name}</h4>
    <p class="desc">${p.description}</p>
    <div class="meta"><span class="price">${p.price}</span></div>
  `;
  return el;
}

const grid = document.getElementById('productGrid');
products.forEach(p => grid.appendChild(createCard(p)));