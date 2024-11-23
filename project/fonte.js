// Variável para rastrear o tamanho atual da fonte
let fontSize = 100; // 100% representa o tamanho padrão

// Função para aplicar o tamanho da fonte em todos os elementos do body, independente do modo
function aplicarFonte() {
    document.body.style.fontSize = fontSize + '%';

    // Opcional: ajuste de tamanho em elementos específicos no modo escuro
    const darkModeElements = document.querySelectorAll('.dark-mode p, .dark-mode h1, .dark-mode h2, .dark-mode li');
    darkModeElements.forEach(element => {
        element.style.fontSize = fontSize + '%';
    });
}

// Função para aumentar a fonte
function aumentarFonte() {
    if (fontSize < 150) { // Limita o aumento a 150%
        fontSize += 10;
        aplicarFonte();
    }
}

// Função para diminuir a fonte
function diminuirFonte() {
    if (fontSize > 50) { // Limita a redução a 50%
        fontSize -= 10;
        aplicarFonte();
    }
}

// Função para alternar o modo escuro
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    aplicarFonte(); // Reaplica o tamanho da fonte no modo atual
}
