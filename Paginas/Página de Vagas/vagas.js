// Dados de exemplo para as vagas
        const vagas = [
            {
                id: 1,
                titulo: "Desenvolvedor Front-end Pleno",
                empresa: "Tech Solutions",
                localizacao: "São Paulo",
                tipo: "CLT",
                descricao: "Buscamos um desenvolvedor Front-end experiente para trabalhar em projetos desafiadores. Responsabilidades incluem o desenvolvimento de interfaces de usuário responsivas, colaboração com a equipe de design e integração com APIs. Necessário ter experiência com React ou Vue.js. Oportunidade de crescimento e ambiente de trabalho colaborativo.",
                detalhes: "Salário: R$ 6.000 - R$ 8.000. Benefícios: Vale-refeição, Plano de Saúde, Bônus Anual. Modalidade: Híbrido. Horário: Flexível.",
                perfilEmpresa: "A Tech Solutions é líder em soluções de tecnologia, com foco em inovação e na criação de produtos que impactam a vida das pessoas. Nossos valores incluem a colaboração, o aprendizado contínuo e a excelência técnica. Venha fazer parte do nosso time!",
                urlCandidatura: "https://forms.gle/exemplo1",
                urlPerfilEmpresa: "/empresas/tech-solutions",
                logoEmpresa: "https://via.placeholder.com/40"
            },
            {
                id: 2,
                titulo: "Estagiário de Marketing Digital",
                empresa: "Marketing Pro",
                localizacao: "Rio de Janeiro",
                tipo: "Estágio",
                descricao: "Junte-se à nossa equipe de marketing e ajude a criar campanhas inovadoras! Você auxiliará na gestão de mídias sociais, análise de métricas e criação de conteúdo. É uma ótima oportunidade para aprender na prática com profissionais experientes e desenvolver suas habilidades na área.",
                detalhes: "Bolsa-auxílio: R$ 1.500. Benefícios: Auxílio-transporte, Vale-refeição. Horário: 6 horas diárias. Requisitos: Cursando Marketing, Publicidade ou áreas afins.",
                perfilEmpresa: "A Marketing Pro é uma agência de marketing digital que atende clientes de diversos segmentos. Somos apaixonados por dados e por estratégias que geram resultados. Nosso ambiente de trabalho é dinâmico e focado em criatividade e inovação.",
                urlCandidatura: "https://forms.gle/exemplo2",
                urlPerfilEmpresa: "/empresas/marketing-pro",
                logoEmpresa: "https://via.placeholder.com/40"
            },
            {
                id: 3,
                titulo: "Analista de Dados Sênior",
                empresa: "Data Insights Co.",
                localizacao: "Remoto",
                tipo: "PJ",
                descricao: "Procuramos um Analista de Dados Sênior para liderar iniciativas de análise e inteligência de negócios. Você será responsável por modelar dados, criar dashboards e apresentar insights estratégicos para a alta gestão. Necessário ter experiência comprovada com SQL, Python e ferramentas de BI (Tableau, Power BI).",
                detalhes: "Valor do Contrato: A combinar. Modalidade: Remoto. Contrato PJ de longo prazo. Requisitos: Experiência sólida em projetos de análise de dados e liderança técnica.",
                perfilEmpresa: "A Data Insights Co. é uma consultoria especializada em big data e inteligência artificial. Trabalhamos com as mais novas tecnologias para transformar dados em valor para nossos clientes. Somos uma equipe enxuta e altamente qualificada, sempre em busca de novos desafios.",
                urlCandidatura: "https://forms.gle/exemplo3",
                urlPerfilEmpresa: "/empresas/data-insights",
                logoEmpresa: "https://via.placeholder.com/40"
            },
            {
                id: 4,
                titulo: "Gerente de Projetos de TI",
                empresa: "Global Solutions",
                localizacao: "São Paulo",
                tipo: "CLT",
                descricao: "Buscamos um Gerente de Projetos com experiência em metodologias ágeis para liderar projetos de desenvolvimento de software de ponta a ponta. Você será o elo entre as equipes técnicas e os stakeholders, garantindo que os projetos sejam entregues no prazo e com qualidade. PMP ou certificação SCRUM é um diferencial.",
                detalhes: "Salário: R$ 10.000 - R$ 14.000. Benefícios: Pacote completo (plano de saúde, seguro de vida, etc.). Modalidade: Presencial. Horário: Comercial.",
                perfilEmpresa: "A Global Solutions é uma multinacional líder no mercado de tecnologia, oferecendo soluções inovadoras para clientes em todo o mundo. Oferecemos um ambiente desafiador e oportunidades de crescimento profissional.",
                urlCandidatura: "https://forms.gle/exemplo4",
                urlPerfilEmpresa: "/empresas/global-solutions",
                logoEmpresa: "https://via.placeholder.com/40"
            },
             {
                id: 5,
                titulo: "Designer UX/UI Pleno",
                empresa: "Creative Labs",
                localizacao: "Belo Horizonte",
                tipo: "CLT",
                descricao: "Estamos em busca de um Designer UX/UI para projetar interfaces intuitivas e agradáveis. Você trabalhará em um ambiente colaborativo, participando de todo o processo, desde a pesquisa com usuários até a prototipação e testes. Conhecimento em Figma ou Adobe XD é essencial.",
                detalhes: "Salário: R$ 4.500 - R$ 6.000. Benefícios: Vale-refeição, Plano de Saúde. Modalidade: Híbrido. Horário: Flexível.",
                perfilEmpresa: "A Creative Labs é uma agência de design premiada, focada em criar experiências digitais incríveis. Somos uma equipe criativa e colaborativa, que valoriza a inovação e a atenção aos detalhes.",
                urlCandidatura: "https://forms.gle/exemplo5",
                urlPerfilEmpresa: "/empresas/creative-labs",
                logoEmpresa: "https://via.placeholder.com/40"
            },
        ];

        const vagasContainer = document.getElementById('vagasContainer');
        const searchInput = document.getElementById('searchInput');
        const filterForm = document.getElementById('filterForm');
        const noResults = document.getElementById('noResults');
        const vagaSidebar = document.getElementById('vagaSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarContent = document.getElementById('sidebarContent');
        const closeSidebarBtn = document.getElementById('closeSidebar');
        const applyButton = document.getElementById('applyButton');
        const resetFiltersBtn = document.getElementById('resetFilters');
        const sideMenu = document.getElementById('sideMenu');
        const menuOverlay = document.getElementById('menuOverlay');
        const openMenuBtn = document.getElementById('openMenuBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const vagasMenuToggle = document.getElementById('vagasMenuToggle');
        const vagasSubMenu = document.getElementById('vagasSubMenu');
        const vagasMenuIcon = document.getElementById('vagasMenuIcon');
        const profileOptions = document.getElementById('profileOptions');

        // Futuramente, esta variável virá da sua lógica de autenticação (backend)
        const isUserLoggedIn = false; // Mude para 'true' para testar a opção de perfil

        const renderVagas = (filteredVagas) => {
            vagasContainer.innerHTML = '';
            if (filteredVagas.length === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
                filteredVagas.forEach(vaga => {
                    const card = document.createElement('div');
                    card.classList.add('bg-white', 'p-6', 'rounded-3xl', 'shadow-md', 'hover:shadow-lg', 'transition-all', 'duration-200');
                    card.setAttribute('data-id', vaga.id);
                    card.innerHTML = `
                        <h3 class="text-xl font-bold text-blue-600 mb-1">${vaga.titulo}</h3>
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0 flex items-center justify-center text-xs text-gray-400 font-bold">
                                <img src="${vaga.logoEmpresa}" alt="Logo da ${vaga.empresa}" class="w-full h-full object-cover rounded-full">
                            </div>
                            <a href="${vaga.urlPerfilEmpresa}" class="text-gray-500 hover:text-blue-600 transition-colors duration-200">${vaga.empresa}</a><span class="text-gray-500"> - ${vaga.localizacao}</span>
                        </div>
                        <span class="text-sm font-semibold bg-gray-200 text-gray-600 py-1 px-3 rounded-full block mt-2 w-fit">${vaga.tipo}</span>
                        <p class="text-gray-700 mt-4 text-justify truncate-3-lines">${vaga.descricao}</p>
                        <button class="saiba-mais-btn mt-4 block text-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">Saiba Mais &rarr;</button>
                    `;
                    vagasContainer.appendChild(card);
                });
            }
        };

        const openSidebar = (vaga) => {
            sidebarContent.innerHTML = `
                <h3 class="text-3xl font-bold text-blue-600 mb-2">${vaga.titulo}</h3>
                <div class="flex items-center space-x-3 mb-4">
                     <div class="w-12 h-12 bg-gray-200 rounded-full flex-shrink-0 flex items-center justify-center text-xs text-gray-400 font-bold">
                        <img src="${vaga.logoEmpresa}" alt="Logo da ${vaga.empresa}" class="w-full h-full object-cover rounded-full">
                    </div>
                    <div>
                        <a href="${vaga.urlPerfilEmpresa}" class="text-gray-500 text-lg hover:text-blue-600 transition-colors duration-200">${vaga.empresa}</a><span class="text-gray-500"> - ${vaga.localizacao}</span>
                    </div>
                </div>
                <div class="space-y-6 text-gray-700 text-lg mt-6">
                    <div>
                        <p class="font-bold">Descrição da Vaga:</p>
                        <p class="text-justify mt-2">${vaga.descricao}</p>
                    </div>
                    <div>
                        <p class="font-bold">Detalhes Adicionais:</p>
                        <p class="text-justify mt-2">${vaga.detalhes}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <p class="font-bold">Sobre a Empresa:</p>
                        <p class="text-justify mt-2">${vaga.perfilEmpresa}</p>
                        <a href="${vaga.urlPerfilEmpresa}" class="mt-4 block text-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">Ver Perfil da Empresa &rarr;</a>
                    </div>
                </div>
            `;
            applyButton.href = vaga.urlCandidatura;
            vagaSidebar.classList.add('open');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        const closeSidebar = () => {
            vagaSidebar.classList.remove('open');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };

        const applyFilters = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const locationFilter = document.getElementById('locationFilter').value;
            const typeFilters = Array.from(document.querySelectorAll('input[name="type"]:checked')).map(cb => cb.value);
            const filteredVagas = vagas.filter(vaga => {
                const matchesSearch = vaga.titulo.toLowerCase().includes(searchTerm) || vaga.empresa.toLowerCase().includes(searchTerm);
                const matchesLocation = locationFilter === 'all' || vaga.localizacao === locationFilter;
                const matchesType = typeFilters.length === 0 || typeFilters.includes(vaga.tipo);
                return matchesSearch && matchesLocation && matchesType;
            });
            renderVagas(filteredVagas);
        };

        // Lógica do Menu Lateral
        openMenuBtn.addEventListener('click', () => {
            sideMenu.classList.add('open');
            menuOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeMenuBtn.addEventListener('click', () => {
            sideMenu.classList.remove('open');
            menuOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        menuOverlay.addEventListener('click', () => {
            sideMenu.classList.remove('open');
            menuOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        vagasMenuToggle.addEventListener('click', () => {
            vagasSubMenu.classList.toggle('hidden');
            vagasMenuIcon.classList.toggle('rotate-180');
        });

        // Lógica de Renderização do Perfil
        const renderProfileSection = () => {
            if (isUserLoggedIn) {
                // Conteúdo para usuário logado (ex: nome do usuário e link para o perfil)
                profileOptions.innerHTML = `
                    <a href="#" class="block font-semibold text-blue-600 hover:text-blue-800">Olá, Candidato!</a>
                    <a href="#" class="block text-sm text-gray-500 hover:text-blue-600">Ver perfil</a>
                `;
            } else {
                // Conteúdo para usuário não logado (ex: opções de login/cadastro)
                profileOptions.innerHTML = `
                    <a href="#" class="block text-gray-700 hover:text-blue-600">Entrar</a>
                    <a href="#" class="block text-gray-700 hover:text-blue-600">Cadastrar</a>
                `;
            }
        };

        // Event listener para os botões "Saiba Mais"
        vagasContainer.addEventListener('click', (e) => {
            const button = e.target.closest('.saiba-mais-btn');
            if (button) {
                const card = button.closest('[data-id]');
                const vagaId = parseInt(card.dataset.id);
                const vagaSelecionada = vagas.find(vaga => vaga.id === vagaId);
                if (vagaSelecionada) {
                    openSidebar(vagaSelecionada);
                }
            }
        });

        searchInput.addEventListener('input', applyFilters);
        filterForm.addEventListener('change', applyFilters);
        closeSidebarBtn.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
        resetFiltersBtn.addEventListener('click', () => {
            filterForm.reset();
            applyFilters();
        });

        // Chamada inicial para renderizar a página
        renderVagas(vagas);
        renderProfileSection();
        
          // Dropdown Desktop Toggle
  const dropdownBtn = document.getElementById("dropdownBtn");
  const dropdownMenu = document.getElementById("dropdownMenu");
  dropdownBtn.addEventListener("click", () => {
    dropdownMenu.classList.toggle("hidden");
  });

        