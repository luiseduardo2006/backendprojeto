// Script para carregar os produtos dinamicamente
document.addEventListener('DOMContentLoaded', function() {
    // Simulação de dados de produtos (15 produtos)
    const produtos = [
        { id: 1, nome: 'Camiseta Esportiva', preco: 49.90, imagem: 'img/camiseta.jpg' },
        { id: 2, nome: 'Calção de Corrida', preco: 59.90, imagem: 'img/calcao.jpg' },
        { id: 3, nome: 'Tênis de Corrida', preco: 199.90, imagem: 'img/tenis.jpg' },
        { id: 4, nome: 'Jaqueta Esportiva', preco: 149.90, imagem: 'img/jaqueta.jpg' },
        { id: 5, nome: 'Mochila de Hidratação', preco: 89.90, imagem: 'img/mochila.jpg' },
        { id: 6, nome: 'Boné Esportivo', preco: 29.90, imagem: 'img/bone.jpg' },
        { id: 7, nome: 'Meias Esportivas', preco: 19.90, imagem: 'img/meias.jpg' },
        { id: 8, nome: 'Calça Esportiva', preco: 79.90, imagem: 'img/calca.jpg' },
        { id: 9, nome: 'Bermuda Esportiva', preco: 69.90, imagem: 'img/bermuda.jpg' },
        { id: 10, nome: 'Top Esportivo', preco: 39.90, imagem: 'img/top.jpg' },
        { id: 11, nome: 'Relógio Fitness', preco: 249.90, imagem: 'img/relogio.jpg' },
        { id: 12, nome: 'Óculos Esportivo', preco: 99.90, imagem: 'img/oculos.jpg' },
        { id: 13, nome: 'Luvas Esportivas', preco: 24.90, imagem: 'img/luvas.jpg' },
        { id: 14, nome: 'Garrafa Esportiva', preco: 14.90, imagem: 'img/garrafa.jpg' },
        { id: 15, nome: 'Fone de Ouvido Esportivo', preco: 159.90, imagem: 'img/fone.jpg' }
    ];

    const produtoLista = document.querySelector('.produto-lista');

    produtos.forEach(produto => {
        const produtoDiv = document.createElement('div');
        produtoDiv.classList.add('produto');
        produtoDiv.innerHTML = `
            <img src="${produto.imagem}" alt="${produto.nome}">
            <h3>${produto.nome}</h3>
            <p>Preço: R$${produto.preco.toFixed(2)}</p>
        `;
        produtoLista.appendChild(produtoDiv);
    });
});
