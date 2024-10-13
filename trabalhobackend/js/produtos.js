document.addEventListener('DOMContentLoaded', function() {
    const produtos = [
        { nome: 'Camiseta Esportiva', preco: 49.90, imagem: 'img/camiseta.jpg' },
        { nome: 'Calção de Corrida', preco: 59.90, imagem: 'img/calcao.jpg' },
        { nome: 'Tênis de Corrida', preco: 199.90, imagem: 'img/tenis.jpg' },
        { nome: 'Jaqueta Esportiva', preco: 149.90, imagem: 'img/jaqueta.jpg' },
        { nome: 'Mochila de Hidratação', preco: 89.90, imagem: 'img/mochila.jpg' },
        { nome: 'Boné Esportivo', preco: 29.90, imagem: 'img/bone.jpg' },
        { nome: 'Meias Esportivas', preco: 19.90, imagem: 'img/meias.jpg' },
        { nome: 'Calça Esportiva', preco: 79.90, imagem: 'img/calca.jpg' },
        { nome: 'Bermuda Esportiva', preco: 69.90, imagem: 'img/bermuda.jpg' },
        { nome: 'Top Esportivo', preco: 39.90, imagem: 'img/top.jpg' },
        { nome: 'Relógio Fitness', preco: 249.90, imagem: 'img/relogio.jpg' },
        { nome: 'Óculos Esportivo', preco: 99.90, imagem: 'img/oculos.jpg' },
        { nome: 'Luvas Esportivas', preco: 24.90, imagem: 'img/luvas.jpg' },
        { nome: 'Garrafa Esportiva', preco: 14.90, imagem: 'img/garrafa.jpg' },
        { nome: 'Fone de Ouvido Esportivo', preco: 159.90, imagem: 'img/fone.jpg' }
    ];

    const listaProdutos = document.getElementById('produtos-lista');

    function renderProdutos() {
        listaProdutos.innerHTML = '';
        produtos.forEach(produto => {
            const div = document.createElement('div');
            div.classList.add('produto');
            div.innerHTML = `
                <img src="${produto.imagem}" alt="${produto.nome}">
                <div>
                    <h3>${produto.nome}</h3>
                    <p>Preço: R$${produto.preco.toFixed(2)}</p>
                    <div class="actions">
                        <button class="editar">Editar</button>
                        <button class="remover">Remover</button>
                    </div>
                </div>
            `;
            listaProdutos.appendChild(div);
        });
    }

    renderProdutos();

    document.getElementById('adicionar-produto').addEventListener('click', function() {
        const nome = document.getElementById('nome').value;
        const preco = document.getElementById('preco').value;

        if (nome && preco) {
            produtos.push({ nome, preco: parseFloat(preco.replace('R$', '').replace(',', '.')), imagem: 'img/default.jpg' });
            renderProdutos();
        } else {
            alert('Preencha todos os campos!');
        }
    });
});
