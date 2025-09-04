        const form = document.getElementById('form-anuncio-vaga');
        const successMessage = document.getElementById('mensagem-sucesso');

        const campos = {
            titulo: document.getElementById('titulo'),
            localizacao: document.getElementById('localizacao'),
            cargaHoraria: document.getElementById('carga-horaria'),
            tipoContrato: document.getElementById('tipo-contrato'),
            descricao: document.getElementById('descricao')
        };
        
        const erros = {
            titulo: document.getElementById('error-titulo'),
            localizacao: document.getElementById('error-localizacao'),
            cargaHoraria: document.getElementById('error-carga-horaria'),
            tipoContrato: document.getElementById('error-tipo-contrato'),
            descricao: document.getElementById('error-descricao')
        };

        function validarFormulario() {
            let formValido = true;
            Object.values(erros).forEach(el => el.classList.add('hidden'));

            if (campos.titulo.value.trim() === '') {
                erros.titulo.classList.remove('hidden');
                formValido = false;
            }
            if (campos.localizacao.value.trim() === '') {
                erros.localizacao.classList.remove('hidden');
                formValido = false;
            }
            if (campos.cargaHoraria.value === '') {
                erros.cargaHoraria.classList.remove('hidden');
                formValido = false;
            }
            if (campos.tipoContrato.value === '') {
                erros.tipoContrato.classList.remove('hidden');
                formValido = false;
            }
            if (campos.descricao.value.trim() === '') {
                erros.descricao.classList.remove('hidden');
                formValido = false;
            }

            return formValido;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (validarFormulario()) {
                const dadosVaga = {
                    id: Date.now(), // Um ID único para a vaga
                    titulo: campos.titulo.value,
                    localizacao: campos.localizacao.value,
                    cargaHoraria: campos.cargaHoraria.value,
                    tipoContrato: campos.tipoContrato.value,
                    salario: document.getElementById('salario').value,
                    descricao: campos.descricao.value,
                    requisitos: document.getElementById('requisitos').value.split(',').map(item => item.trim())
                };

                // Pega as vagas existentes ou cria um novo array
                const vagasExistentes = JSON.parse(localStorage.getItem('vagas')) || [];
                
                // Adiciona a nova vaga ao array
                vagasExistentes.push(dadosVaga);
                
                // Salva o array de volta no localStorage
                localStorage.setItem('vagas', JSON.stringify(vagasExistentes));
                
                successMessage.classList.remove('hidden');
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                }, 4000);
                
                form.reset();
                console.log('Vaga publicada e salva no localStorage:', dadosVaga);
            }
        });