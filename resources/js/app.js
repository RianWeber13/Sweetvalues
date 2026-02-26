import './bootstrap';

// Anexamos a função ao objeto window para que o HTML consiga acessá-la globalmente
window.formatarMoeda = function(input) {
    let valor = input.value;

    // 1. Remove tudo o que não for número
    valor = valor.replace(/\D/g, "");

    // 2. Transforma em decimal (centavos)
    valor = (valor / 100).toFixed(2) + "";

    // 3. Troca ponto por vírgula
    valor = valor.replace(".", ",");

    // 4. Regex para pontos de milhar
    valor = valor.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,"); // Milhões
    valor = valor.replace(/(\d)(\d{3}),/g, "$1.$2,");           // Milhares

    // 5. Devolve o valor formatado ao campo
    input.value = valor;
};