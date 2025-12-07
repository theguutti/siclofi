const cpfInputs = document.querySelectorAll('input[id*="cpf"], input[name*="cpf"]');

cpfInputs.forEach(input => {
    input.addEventListener('keypress', () => {
        let inputlength = input.value.length;
        
        if (inputlength === 3 || inputlength === 7) {
            input.value += '.';
        } else if (inputlength === 11) {
            input.value += '-';
        }
    });
});

// TODO: CALCULAR VALIDEZ CPF
/*
CPF EXEMPLO: 111.444.777-__

> ETAPA 1 - PRIMEIRO DÍGITO VERIFICADOR (111.444.777-X_).
    1 - SOMAR O PRODUTO DE CADA DÍGITO ORIGINAL PELA SUA POSIÇÃO.
    (1*10) + (1*9) + (1*8) + (4*7) + (4*6) + (4*5) + (7*4) + (7*3) + (7*2) = 162

    2 - PEGAR O RESTO DA DIVISÃO ENTRE A SOMA E 11.
    162 %% 11 = 8

    3 - VERIFICAR SE O RESTO É MAIOR OU MENOR QUE 2.
        3.1 - MAIOR QUE 2 (SUBTRAIR 11 E O VALOR DO RESTO DA DIVISÃO).
    11 - 8 = 3
        3.2 - MENOR QUE 2.
    DÍGITO VERIFICADOR = 0

> ETAPA 2 - SEGUNDO DÍGITO VERIFICADOR (111.444.777-_X).
    1 - SOMAR O PRODUTO DE CADA DÍGITO (INCLUINDO O VERIFICADOR) PELA SUA POSIÇÃO.
    (1*11) + (1*10) + (1*9) + (4*8) + (4*7) + (4*6) + (7*5) + (7*4) + (7*3) + (3*2) = 204

    2 - PEGAR O RESTO DA DIVISÃO ENTRE A SOMA E 11.
    204 %% 11 = 6

    3 - VERIFICAR SE O RESTO É MAIOR OU MENOR QUE 2.
        3.1 - MAIOR QUE 2 (SUBTRAIR 11 E O VALOR DO RESTO DA DIVISÃO).
    11 - 6 = 5
        3.2 - MENOR QUE 2.
    DÍGITO VERIFICADOR = 0

> RESULTADO.
CPF: 111.444.777-35
*/
