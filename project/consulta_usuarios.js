function abrirFormulario(acao, id_usuario = null) {
    // Abre o formulário de edição ou inserção com dados preenchidos, se necessário
}

function excluirUsuario(id_usuario) {
    if (confirm("Tem certeza que deseja excluir este usuário?")) {
        fetch('consulta_usuarios.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `acao=excluir&id_usuario=${id_usuario}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`usuario-${id_usuario}`).remove();
                alert(data.message);
            }
        });
    }
}
