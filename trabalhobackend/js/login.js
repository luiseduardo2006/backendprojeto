// Script para o formulário de login
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    form.addEventListener('submit', function(event) {
        const login = document.getElementById('login').value;
        const senha = document.getElementById('senha').value;

        if (!login || !senha) {
            alert('Preencha todos os campos!');
            event.preventDefault();
        }
    });
});
