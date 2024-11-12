document.addEventListener("DOMContentLoaded", () => {
    // Verifica se o modo escuro estava ativado
    const modoEscuroAtivo = localStorage.getItem("modoEscuroAtivo") === "true";
    if (modoEscuroAtivo) {
        document.body.classList.add("modo-escuro");
    }
});

function toggleDarkMode() {
    document.body.classList.toggle("modo-escuro");
    // Salva o estado do modo escuro no localStorage
    const modoEscuroAtivo = document.body.classList.contains("modo-escuro");
    localStorage.setItem("modoEscuroAtivo", modoEscuroAtivo);
}
