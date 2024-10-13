// Script para validar o formulário de cadastro
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cadastro-form');
    form.addEventListener('submit', function(event) {
        const senha = document.getElementById('senha').value;
        const confirmaSenha = document.getElementById('confirma_senha').value;

        if (senha !== confirmaSenha) {
            alert('As senhas não coincidem!');
            event.preventDefault();
        }
    });
});
