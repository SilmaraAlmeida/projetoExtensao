document.addEventListener('DOMContentLoaded', function() {
    const smallCards = document.querySelectorAll('.small-card');
    const jobDetailCardContainer = document.getElementById('jobDetailCardContainer');
    const closeBtn = jobDetailCardContainer.querySelector('.custom-close-btn');
    const leftColumn = document.getElementById('leftColumn');
    const rightColumn = document.getElementById('rightColumn');

    // Elementos do card de detalhes para preencher
    const detailJobTitle = document.getElementById('detailJobTitle');
    const detailJobCompany = document.getElementById('detailJobCompany');
    const detailJobLocation = document.getElementById('detailJobLocation');
    const detailJobSalary = document.getElementById('detailJobSalary');
    const detailJobDescription = document.getElementById('detailJobDescription');
    const detailJobRequirements = document.getElementById('detailJobRequirements');
    const detailJobBenefits = document.getElementById('detailJobBenefits');

    // Dados de exemplo para as vagas (você pode substituir por dados reais de uma API)
    const jobData = {
        1: {
            title: "Estágio em Análise e Desenvolvimento de Sistemas",
            company: "Empresa Alpha Ltda.",
            location: "Remoto - Todo Brasil",
            salary: "Salário: R$ 1.500 - R$ 2.000",
            description: "Buscamos estagiário para atuar no desenvolvimento e manutenção de sistemas web, utilizando tecnologias modernas como React, Node.js e bancos de dados SQL. Oportunidade de aprendizado e crescimento em um ambiente dinâmico.",
            requirements: [
                "Cursando Análise e Desenvolvimento de Sistemas ou áreas correlatas.",
                "Conhecimento básico em lógica de programação e algoritmos.",
                "Vontade de aprender e proatividade.",
                "Disponibilidade de 20 ou 30 horas semanais."
            ],
            benefits: [
                "Bolsa auxílio competitiva.",
                "Vale refeição ou alimentação.",
                "Auxílio internet.",
                "Plano de desenvolvimento individual."
            ]
        },
        2: {
            title: "Estágio Front-end",
            company: "Tech Solutions S.A.",
            location: "São Paulo, SP - Híbrido",
            salary: "Salário: R$ 2.500 - R$ 3.500",
            description: "Estágio Front-end para atuar em projetos inovadores, criando interfaces de usuário intuitivas e responsivas. Fará parte de um time ágil, utilizando frameworks como Vue.js e Bootstrap.",
            requirements: [
                "Experiência com HTML5, CSS3, JavaScript (ES6+).",
                "Conhecimento em frameworks como Vue.js, React ou Angular.",
                "Familiaridade com controle de versão (Git).",
                "Desejável: experiência com metodologias ágeis."
            ],
            benefits: [
                "Plano de saúde e odontológico.",
                "Vale transporte ou auxílio combustível.",
                "Participação nos lucros.",
                "Horário flexível."
            ]
        },
        3: {
            title: "Analista de Dados Estágio",
            company: "Data Insight Consultoria",
            location: "Rio de Janeiro, RJ - Presencial",
            salary: "Salário: R$ 1.800 - R$ 2.200",
            description: "Vaga de estágio para Analista de Dados, auxiliando na coleta, limpeza, análise e visualização de grandes volumes de dados. Oportunidade de trabalhar com ferramentas de BI e programação (Python/R).",
            requirements: [
                "Cursando Estatística, Ciência da Computação, Engenharia ou áreas correlatas.",
                "Conhecimento básico em SQL e Excel.",
                "Desejável: noções de Python ou R.",
                "Boa capacidade analítica e atenção aos detalhes."
            ],
            benefits: [
                "Bolsa auxílio.",
                "Auxílio transporte.",
                "Seguro de vida.",
                "Cursos e treinamentos na área."
            ]
        }
        // Adicione mais dados de vagas conforme necessário
    };

    smallCards.forEach(card => {
        card.addEventListener('click', function() {
            const jobId = this.dataset.jobId;
            const job = jobData[jobId];

            if (job) {
                // Preencher o card de detalhes com os dados da vaga
                detailJobTitle.textContent = job.title;
                detailJobCompany.textContent = job.company;
                detailJobLocation.textContent = job.location;
                detailJobSalary.textContent = job.salary;
                detailJobDescription.textContent = job.description;

                // Limpar e preencher requisitos
                detailJobRequirements.innerHTML = '';
                job.requirements.forEach(req => {
                    const li = document.createElement('li');
                    li.textContent = req;
                    detailJobRequirements.appendChild(li);
                });

                // Limpar e preencher benefícios
                detailJobBenefits.innerHTML = '';
                job.benefits.forEach(ben => {
                    const li = document.createElement('li');
                    li.textContent = ben;
                    detailJobBenefits.appendChild(li);
                });

                // Ajustar as classes das colunas para mostrar/esconder e redimensionar
                // Incluí 'col-md-6' nas remoções e 'col-md-4' nas adições para a coluna esquerda
                leftColumn.classList.remove('col-lg-6', 'col-md-12'); // Remove col-md-12 aqui
                leftColumn.classList.add('col-lg-4', 'col-md-4'); // Adiciona col-md-4

                // Incluí 'col-md-6' nas remoções e 'col-md-8' nas adições para a coluna direita
                rightColumn.classList.remove('col-lg-6', 'col-md-12'); // Remove col-md-12 aqui
                rightColumn.classList.add('col-lg-8', 'col-md-8'); // Adiciona col-md-8

                jobDetailCardContainer.classList.remove('d-none'); // Mostra o card de detalhes
            }
        });
    });

    closeBtn.addEventListener('click', function() {
        // Ajustar as classes das colunas de volta ao estado inicial
        // Incluí 'col-md-4' nas remoções e 'col-md-6' nas adições para a coluna esquerda
        leftColumn.classList.remove('col-lg-4', 'col-md-4');
        leftColumn.classList.add('col-lg-6', 'col-md-12'); // Volta para col-md-12 quando escondido

        // Incluí 'col-md-8' nas remoções e 'col-md-6' nas adições para a coluna direita
        rightColumn.classList.remove('col-lg-8', 'col-md-8');
        rightColumn.classList.add('col-lg-6', 'col-md-12'); // Volta para col-md-12 quando escondido

        jobDetailCardContainer.classList.add('d-none'); // Esconde o card de detalhes
    });
});