document.addEventListener('DOMContentLoaded', function() {
    // ------ Lógica para mostrar campos de Trabalhador ou Empresa ------
    const trabalhadorRadio = document.getElementById('trabalhador');
    const empresaRadio = document.getElementById('empresa');
    const trabalhadorFields = document.getElementById('trabalhadorFields');
    const empresaFields = document.getElementById('empresaFields');

    function toggleFields() {
        if (trabalhadorRadio.checked) {
            trabalhadorFields.classList.remove('d-none');
            empresaFields.classList.add('d-none');
        } else if (empresaRadio.checked) {
            trabalhadorFields.classList.add('d-none');
            empresaFields.classList.remove('d-none');
        }
    }

    toggleFields();
    trabalhadorRadio.addEventListener('change', toggleFields);
    empresaRadio.addEventListener('change', toggleFields);

    // ------ Validação e confirmação de senha ------
    const formulario = document.getElementById('formulario');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmarSenha');
    const mensagemErro = document.getElementById('mensagemErro');

    formulario.addEventListener('submit', function(event) {
        if (senha.value !== confirmarSenha.value) {
            event.preventDefault();  // Impede o envio do formulário
            mensagemErro.textContent = 'As senhas não são iguais!';
        } else {
            mensagemErro.textContent = '';
        }
    });
});
