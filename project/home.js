document.addEventListener('DOMContentLoaded', function () {
  const carouselImages = document.querySelector('.carousel-images');
  const prevButton = document.querySelector('.prev');
  const nextButton = document.querySelector('.next');
  const totalImages = document.querySelectorAll('.carousel-item').length;
  let currentIndex = 0;

  function showImage(index) {
    const offset = -index * 300; // Ajuste para corresponder à largura da imagem
    carouselImages.style.transform = `translateX(${offset}px)`;
  }

  prevButton.addEventListener('click', function () {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalImages - 1;
    showImage(currentIndex);
  });

  nextButton.addEventListener('click', function () {
    currentIndex = (currentIndex < totalImages - 1) ? currentIndex + 1 : 0;
    showImage(currentIndex);
  });

  showImage(currentIndex);
});

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

function toggleCart() {
  const cartElement = document.getElementById('cart');
  cartElement.style.display = cartElement.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => {
  loadCart();
});

// Função para alternar o modo escuro
function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');
  if (document.body.classList.contains('dark-mode')) {
    localStorage.setItem('darkMode', 'enabled');
  } else {
    localStorage.removeItem('darkMode');
  }
}

// Verifica a preferência do modo escuro ao carregar a página
function checkDarkModePreference() {
  if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
  }
}

// Chama a função ao carregar a página
document.addEventListener('DOMContentLoaded', checkDarkModePreference);

// Função para redirecionar para a página de pagamento
function redirectToPayment() {
  window.location.href = 'pagamento.html';
}

// Adiciona evento ao botão "Pagar" no carrinho
document.getElementById('pay-button').addEventListener('click', redirectToPayment); 

