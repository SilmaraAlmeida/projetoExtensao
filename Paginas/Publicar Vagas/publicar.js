const vagaForm = document.getElementById('vagaForm');

        vagaForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Cria um objeto com os dados do formulário
            const novaVaga = {
                id: Date.now(), // Simula um ID único
                titulo: document.getElementById('titulo').value,
                empresa: document.getElementById('empresa').value,
                localizacao: document.getElementById('localizacao').value,
                tipo: document.getElementById('tipo').value,
                descricao: document.getElementById('descricao').value,
                detalhes: document.getElementById('detalhes').value,
                perfilEmpresa: document.getElementById('perfilEmpresa').value,
                urlCandidatura: document.getElementById('urlCandidatura').value,
                logoEmpresa: document.getElementById('logoEmpresa').value,
            };

            // Futuramente, esta parte irá enviar 'novaVaga' para um backend
            // para ser salva no banco de dados e exibida na página de vagas.
            console.log('Dados da nova vaga:', novaVaga);

            // Simula o sucesso da publicação e limpa o formulário
            alert('Vaga publicada com sucesso!');
            vagaForm.reset();
        });