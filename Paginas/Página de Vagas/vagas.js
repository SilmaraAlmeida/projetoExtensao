const vagas = [
            // ... (Seu array de vagas)
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
                logoEmpresa: "https://via.placeholder.com/40",
                salarioDisplay: "R$ 6.000 - R$ 8.000 por mês",
                tempoResposta: "Normalmente responde em até 1 dia",
                periodo: "Híbrido - Flexível"
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
                logoEmpresa: "https://via.placeholder.com/40",
                salarioDisplay: "R$ 1.500 por mês",
                tempoResposta: "Contratando vários candidatos",
                periodo: "Presencial - 6 horas diárias"
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
                logoEmpresa: "https://via.placeholder.com/40",
                salarioDisplay: "Valor do Contrato: A combinar",
                tempoResposta: "Rápido!",
                periodo: "Remoto - PJ"
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
                logoEmpresa: "https://via.placeholder.com/40",
                salarioDisplay: "R$ 10.000 - R$ 14.000 por mês",
                tempoResposta: "Normalmente responde em 2 dias",
                periodo: "Integral - Comercial"
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
                logoEmpresa: "https://via.placeholder.com/40",
                salarioDisplay: "R$ 4.500 - R$ 6.000 por mês",
                tempoResposta: "Normalmente responde em até 1 dia",
                periodo: "Híbrido - Flexível"
            },
        ];

        // 💡 NOVOS ELEMENTOS DOM
        const vagaDetailColumn = document.getElementById('vagaDetailColumn');
        const vagaDetailContent = document.getElementById('vagaDetailContent');
        const vagaDetailDefault = document.getElementById('vagaDetailDefault');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
        const closeMobileSidebarBtn = document.getElementById('closeMobileSidebar');
        const mobileSidebarContent = document.getElementById('mobileSidebarContent');
        const applyMainFiltersBtn = document.getElementById('applyMainFilters');
        const searchTermInput = document.getElementById('searchTermInput');
        const locationMainFilter = document.getElementById('locationMainFilter');
        const secondaryFiltersDiv = document.getElementById('secondaryFilters');
        const vagaCountDisplay = document.getElementById('vagaCountDisplay');
        const btnFechar = document.getElementById('btnFecharVaga');
        const vagaContainer = document.getElementById('vagaContainer');

        // ELEMENTOS EXISTENTES RENOMEADOS/REUTILIZADOS
        const vagasContainer = document.getElementById('vagasContainer');
        const searchInput = document.getElementById('searchInput'); // O input de pesquisa no header
        const filterForm = { // Simulando o form para obter os checkboxes
            querySelectorAll: (selector) => document.querySelectorAll(selector),
            reset: () => {
                locationMainFilter.value = 'all';
                document.querySelectorAll('#secondaryFilters input[type="checkbox"]').forEach(cb => cb.checked = false);
            }
        };
        const noResults = document.getElementById('noResults');

        // Variáveis de Menu Lateral (MANTIDO)
        const sideMenu = document.getElementById('sideMenu');
        const menuOverlay = document.getElementById('menuOverlay');
        const openMenuBtn = document.getElementById('openMenuBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const vagasMenuToggle = document.getElementById('vagasMenuToggle');
        const vagasSubMenu = document.getElementById('vagasSubMenu');
        const vagasMenuIcon = document.getElementById('vagasMenuIcon');
        const profileOptions = document.getElementById('profileOptions');
        const isUserLoggedIn = false;


        // FUNÇÃO PARA CRIAR CHECKBOXES DE TIPO DE VAGA (INJETAR NO TOPO)
        const renderSecondaryFilters = () => {
            const types = ['CLT', 'Estágio', 'PJ'];
            secondaryFiltersDiv.innerHTML = types.map(type => `
                <button data-type="${type}" class="filter-button bg-gray-100 text-gray-700 py-1 px-3 rounded-md border hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center">
                    <input type="checkbox" name="type" value="${type}" class="hidden">
                    ${type}
                </button>
            `).join('');

             // Adicionar o evento de clique aos botões para simular o checkbox
            document.querySelectorAll('.filter-button').forEach(button => {
                button.addEventListener('click', () => {
                    const checkbox = button.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    button.classList.toggle('bg-blue-100');
                    button.classList.toggle('text-blue-700');
                    button.classList.toggle('border-blue-500');
                    applyFilters();
                });
            });
        };
        

        // 💡 FUNÇÃO PARA CRIAR CARD DA VAGA (ADAPTADA AO NOVO ESTILO)
        const createVagaCard = (vaga) => {
            return `
                <div data-id="${vaga.id}" class="vaga-card bg-white p-4 rounded-xl shadow-md cursor-pointer border border-gray-300 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-bold text-blue-800">${vaga.titulo}</h3>
                        <span class="text-xl text-gray-400">...</span>
                    </div>
                    <p class="text-sm font-semibold">${vaga.empresa}</p>
                    <p class="text-sm text-gray-500 mb-2">${vaga.localizacao}</p>
                    
                    <div class="flex items-center text-green-700 font-semibold mb-2">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-2-7h4v2H8v-2zm-3.5-3.5h11v2h-11v-2z"></path></svg>
                        ${vaga.tempoResposta}
                    </div>

                    <div class="flex gap-3 text-sm text-gray-600">
                        <span class="font-bold">${vaga.salarioDisplay.split(' por mês')[0]}</span>
                        <span>· ${vaga.tipo}</span>
                        <span>· ${vaga.periodo.split(' - ')[0]}</span>
                    </div>
                    <button class="mt-2 text-xs text-blue-600 hover:underline">Exibir vagas similares dessa empresa</button>
                </div>
            `;
        };

        // 💡 FUNÇÃO PARA CRIAR CONTEÚDO DETALHADO (ADAPTADA AO NOVO ESTILO)
        const createDetailContent = (vaga) => {
            return `
                <div class="p-6">
                    <button id="btnFecharVaga" class="static top-4 right-4 text-gray-400 hover:text-gray-800 transition-colors">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="flex justify-end mb-4">
                        <a id="applyButtonDesktop" href="${vaga.urlCandidatura}" target="_blank" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-xl hover:bg-blue-700 flex items-center text-sm">Candidatar-se</a>
                        <button class="ml-2 p-2 border rounded-full text-gray-500 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </button>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-1">${vaga.titulo}</h3>
                    <p class="text-md font-semibold text-gray-600">${vaga.empresa}</p>
                    <p class="text-sm text-gray-500 mb-4">${vaga.localizacao}</p>
                    
                    <h4 class="font-bold text-lg mt-6 mb-2 border-b pb-1">Dados da vaga</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2-3-.895-3-2 1.343-2 3-2zM9 14h6M8 17h8"></path></svg>
                            <span class="font-semibold">Salário:</span> <span class="ml-2">${vaga.salarioDisplay}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12a2 2 0 002 2h2M6 4v12a2 2 0 002 2h2m-6-6h4m0 0l-1-1m1 1l1-1"></path></svg>
                            <span class="font-semibold">Tipo de vaga:</span> <span class="ml-2">${vaga.tipo}</span>
                        </div>
                         <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold">Horário:</span> <span class="ml-2">${vaga.periodo}</span>
                        </div>
                    </div>

                    <h4 class="font-bold text-lg mt-6 mb-2 border-b pb-1">Descrição Completa</h4>
                    <p class="mt-2 text-gray-700">${vaga.descricao}</p>
                    <p class="mt-4 text-gray-700">${vaga.detalhes}</p>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mt-6">
                        <p class="font-bold">Sobre a Empresa:</p>
                        <p class="mt-2">${vaga.perfilEmpresa}</p>
                    </div>
                </div>
            `;
        };
        
        // 💡 FUNÇÃO PARA EXIBIR DETALHES (ADAPTADA AO NOVO LAYOUT MASTER-DETAIL)
        const showVagaDetails = (vaga) => {
            const content = createDetailContent(vaga);
            
            
            // 1. Marcar card ativo (feedback visual)
            document.querySelectorAll('.vaga-card').forEach(card => card.classList.remove('border-blue-500', 'border-2'));
            const selectedCard = document.querySelector(`.vaga-card[data-id="${vaga.id}"]`);
            if(selectedCard) {
                selectedCard.classList.add('border-blue-500', 'border-2');
            }

            // 2. Lógica para Desktop vs Mobile
            if (window.innerWidth >= 1024) { // Ponto de quebra 'lg' do Tailwind
                // Modo Desktop (Coluna da Direita)
                vagaDetailDefault.classList.add('hidden');
                vagaDetailContent.classList.remove('hidden');
                vagaDetailContent.innerHTML = content;
                vagaDetailColumn.classList.remove('hidden'); // Garante que a coluna apareça
            } else {
                // Modo Mobile (Modal/Sidebar)
                mobileSidebarContent.innerHTML = content;
                document.getElementById('applyButtonMobile').href = vaga.urlCandidatura;
                mobileSidebar.classList.remove('hidden', 'vaga-sidebar'); 
                mobileSidebarOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        };
        
        
        

        // FUNÇÃO DE FECHAR (ADAPTADA AO NOVO MODAL MOBILE)
        const closeMobileSidebar = () => {
            mobileSidebar.classList.add('hidden');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };


        // FUNÇÃO DE FILTROS (ADAPTADA PARA USAR OS NOVOS CAMPOS DO TOPO)
        const applyFilters = () => {
            const searchTerm = searchTermInput.value.toLowerCase() || searchInput.value.toLowerCase();
            const locationFilter = locationMainFilter.value;
            const typeFilters = Array.from(document.querySelectorAll('#secondaryFilters input[name="type"]:checked')).map(cb => cb.value);

            const filteredVagas = vagas.filter(vaga => {
                const matchesSearch = vaga.titulo.toLowerCase().includes(searchTerm) || vaga.empresa.toLowerCase().includes(searchTerm);
                const matchesLocation = locationFilter === 'all' || vaga.localizacao === locationFilter;
                const matchesType = typeFilters.length === 0 || typeFilters.includes(vaga.tipo);
                return matchesSearch && matchesLocation && matchesType;
            });
            
            renderVagas(filteredVagas);
            vagaCountDisplay.textContent = `Exibindo ${filteredVagas.length} de ${vagas.length} vagas`;
        };

        const renderVagas = (filteredVagas) => {
            vagasContainer.innerHTML = '';
            if (filteredVagas.length === 0) {
                noResults.classList.remove('hidden');
                // Oculta coluna de detalhes no desktop se não houver resultados
                if(window.innerWidth >= 1024) {
                    vagaDetailColumn.classList.add('hidden');
                }
            } else {
                noResults.classList.add('hidden');
                vagaDetailColumn.classList.remove('hidden'); // Mostra a coluna de detalhes
                filteredVagas.forEach(vaga => {
                    vagasContainer.innerHTML += createVagaCard(vaga);
                });
            }
        };

        // EVENTOS (ADAPTADOS/NOVOS)
        
        // 1. Eventos de Busca Principal (ao mudar campos)
        searchTermInput.addEventListener('input', applyFilters);
        locationMainFilter.addEventListener('change', applyFilters);
        applyMainFiltersBtn.addEventListener('click', applyFilters);

        // 2. Eventos de Menu Mobile
        closeMobileSidebarBtn.addEventListener('click', closeMobileSidebar);
        mobileSidebarOverlay.addEventListener('click', closeMobileSidebar);

        // 3. Evento de Clique nos Cards para Detalhes
        vagasContainer.addEventListener('click', (e) => {
            const card = e.target.closest('.vaga-card');
            if (card) {
                const vagaId = parseInt(card.dataset.id);
                const vagaSelecionada = vagas.find(vaga => vaga.id === vagaId);
                if (vagaSelecionada) {
                    showVagaDetails(vagaSelecionada);
                }
            }
        });

        // 4. Lógica do Menu Lateral (MANTIDO)
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

        const renderProfileSection = () => {
            if (isUserLoggedIn) {
                profileOptions.innerHTML = `
                    <a href="#" class="block font-semibold text-blue-600 hover:text-blue-800">Olá, Candidato!</a>
                    <a href="#" class="block text-sm text-gray-500 hover:text-blue-600">Ver perfil</a>
                `;
            } else {
                profileOptions.innerHTML = `
                    <a href="#" class="block text-white hover:text-blue-400">Entrar</a>
                    <a href="#" class="block text-white hover:text-blue-400">Cadastrar</a>
                `;
            }
        };
        
        const dropdownBtn = document.getElementById("dropdownBtn");
        const dropdownMenu = document.getElementById("dropdownMenu");
        dropdownBtn.addEventListener("click", () => {
          dropdownMenu.classList.toggle("hidden");
        });

        // Chamadas iniciais
        renderProfileSection();
        renderSecondaryFilters(); // Novo: renderiza os filtros de tipo de vaga no topo
        applyFilters(); // Renderiza a lista inicial