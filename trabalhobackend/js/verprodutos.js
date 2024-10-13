// Função para buscar produtos do servidor
async function fetchProdutos() {
    try {
        const response = await fetch('php/consulta_produtos.php');
        if (!response.ok) {
            throw new Error('Erro ao buscar produtos');
        }

        const produtos = await response.json();
        displayProdutos(produtos);
    } catch (error) {
        console.error('Erro:', error);
        document.getElementById('produtos-container').innerHTML = '<p>Não foi possível carregar os produtos.</p>';
    }
}

// Função para exibir produtos na página
function displayProdutos(produtos) {
    const container = document.getElementById('produtos-container');
    container.innerHTML = ''; // Limpa o contêiner antes de adicionar novos produtos

    produtos.forEach(produto => {
        const produtoDiv = document.createElement('div');
        produtoDiv.className = 'produto';
        produtoDiv.innerHTML = `
            <h3>${produto.nome}</h3>
            <p>${produto.descricao}</p>
            <p>Preço: R$ ${produto.preco.toFixed(2)}</p>
        `;
        container.appendChild(produtoDiv);
    });
}

// Chama a função para buscar produtos ao carregar a página
window.onload = fetchProdutos;
