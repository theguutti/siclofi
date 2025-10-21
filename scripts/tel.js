const telInputs = document.querySelectorAll('input[id*="telefone"], input[name*="telefone"]');

telInputs.forEach(input => {
    input.addEventListener('keypress', () => {
        let inputlength = input.value.length;
        
        if (inputlength === 0) {
            input.value += '(';
        } else if (inputlength === 3){
            input.value += ')';
        }
    });
});
