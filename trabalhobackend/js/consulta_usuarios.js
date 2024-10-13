document.getElementById('searchBtn').addEventListener('click', function() {
    const searchValue = document.getElementById('search').value;

    // Fazendo a requisição AJAX para consultar os usuários
    fetch(`php/consulta_usuarios.php?search=${encodeURIComponent(searchValue)}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#userTable tbody');
            tableBody.innerHTML = ''; // Limpa os resultados anteriores

            // Verifica se há usuários
            if (data.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="4">Nenhum usuário encontrado.</td>';
                tableBody.appendChild(row);
                return;
            }

            // Itera pelos usuários e insere as linhas na tabela
            data.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.nome}</td>
                    <td>${user.login}</td>
                    <td>${user.email}</td>
                    <td><button onclick="excluirUsuario(${user.id})">Excluir</button></td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Erro ao buscar usuários:', error));
});

// Função para excluir usuário
function excluirUsuario(id) {
    if (confirm('Deseja realmente excluir este usuário?')) {
        fetch(`php/excluir_usuario.php?id=${id}`, { method: 'GET' })
            .then(response => response.text())
            .then(message => {
                alert(message);
                location.reload(); // Recarrega a página após exclusão
            })
            .catch(error => console.error('Erro ao excluir usuário:', error));
    }
}
