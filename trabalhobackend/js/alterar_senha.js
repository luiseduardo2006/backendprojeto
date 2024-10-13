// Script para validação de senha
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('alterar-senha-form');

    form.addEventListener('submit', function(event) {
        const novaSenha = document.getElementById('nova_senha').value;
        const confirmaSenha = document.getElementById('confirma_senha').value;

        if (novaSenha !== confirmaSenha) {
            alert('As senhas não coincidem!');
            event.preventDefault();
        }
    });
});
