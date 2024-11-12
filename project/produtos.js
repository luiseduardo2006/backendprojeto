let cart = [];

function loadCart() {
  const cartData = localStorage.getItem('cart');
  if (cartData) {
    cart = JSON.parse(cartData);
    renderCart();
  }
}

function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function addToCart(productName, productPrice) {
  cart.push({ name: productName, price: productPrice });
  saveCart();
  renderCart();
  showCart(); // Exibe o carrinho quando um item é adicionado
}

function renderCart() {
  const cartItems = document.getElementById('cart-items');
  cartItems.innerHTML = '';
  cart.forEach((item, index) => {
    const li = document.createElement('li');
    li.textContent = `${item.name} - R$${item.price.toFixed(2)}`;
    const removeButton = document.createElement('button');
    removeButton.textContent = 'Remover';
    removeButton.onclick = () => {
      removeFromCart(index);
    };
    li.appendChild(removeButton);
    cartItems.appendChild(li);
  });
}

function removeFromCart(index) {
  cart.splice(index, 1);
  saveCart();
  renderCart();
}

function clearCart() {
  cart = [];
  saveCart();
  renderCart();
}

function showCart() {
  const cartElement = document.getElementById('cart');
  cartElement.style.display = 'block';
}

function toggleCart() {
  const cartElement = document.getElementById('cart');
  cartElement.style.display = cartElement.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => {
  loadCart();
  checkDarkModePreference();

  const payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', () => {
    window.location.href = 'pagamento.html'; // Redireciona para a página de pagamento
  });
});

// Função para alternar o modo escuro
function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');
  if (document.body.classList.contains('dark-mode')) {
    localStorage.setItem('darkMode', 'enabled');
  } else {
    localStorage.setItem('darkMode', 'disabled');
  }
}

// Verifica a preferência do modo escuro ao carregar a página
function checkDarkModePreference() {
  if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
  }
}
