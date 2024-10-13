document.getElementById('buscar-log').addEventListener('click', function() {
    const filtro = document.getElementById('filtro').value;

    // Fazendo a requisição AJAX para buscar os logs de autenticação
    fetch(`php/log_autenticacao.php?filtro=${encodeURIComponent(filtro)}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#logTable tbody');
            tableBody.innerHTML = ''; // Limpa os resultados anteriores

            // Verifica se data é um array e se há logs
            if (!Array.isArray(data) || data.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="4">Nenhum log encontrado.</td>';
                tableBody.appendChild(row);
                return;
            }

            // Itera pelos logs e insere as linhas na tabela
            data.forEach(log => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${log.nome}</td>
                    <td>${log.cpf}</td>
                    <td>${log.data_hora}</td>
                    <td>${log['2fa']}</td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Erro ao buscar logs:', error));
});
