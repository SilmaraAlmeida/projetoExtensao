    </main>

    <?php if (isset($_SESSION['userNivel']) && $_SESSION['userNivel'] == "G" && in_array($this->controller ?? '', ['Sistema', 'Usuario', 'Configuracao', 'Relatorio', 'Log'])): ?>
        </div>
    <?php endif; ?>

    <footer class="footer text-light py-5" style="background: #003399;">
        <div class="container px-4">
            <div class="row">
                <div class="col col-lg-4">
                    <h3 class="pt-3 fw-bold">Via Muriaé – Conectando Empresas e Talentos Locais  </h3>
                    <p>Nossa missão é transformar o mercado de trabalho em Muriaé com tecnologia, eficiência e inclusão.</p>
                    <p>Rua Exemplo, 123 – Centro, Muriaé/MG  </p>
                    <p>(32) 3721-0000</p>
                    <p>contato@viamuriae.com.br</p>
                </div>
                <div class="col">
                    <h4 class="pt-3">Menu Principal</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-light" >Início</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Empresas</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Candidatos</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Vagas</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h4 class="pt-3">Mais</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-light" >Sobre nós</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Entrar</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h4 class="pt-3">Áreas de Atuação</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-light" >Administração</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Tecnologia da Informação</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Saúde</a></li>
                        <li><a href="#" class="text-decoration-none text-light" >Vendas e Atendimento</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3 text-lg-end">
                    <h4 class="pt-3">Social Media Icon</h4>
                    <div>
                        <a href="#" class="text-decoration-none text-light" ><i class="bi bi-instagram fs-2 me-3"></i></a>
                        <a href="#" class="text-decoration-none text-light" ><i class="bi bi-facebook fs-2 me-3"></i></a>
                        <a href="#" class="text-decoration-none text-light" ><i class="bi bi-whatsapp fs-2 me-3"></i></a>
                        <a href="#" class="text-decoration-none text-light" ><i class="bi bi-linkedin fs-2"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <p>2025 © ViaMuriae. Todos os direitos reservados</p>
                <div class="d-flex">
                    <a href="#" class="text-decoration-none text-light me-4" >Termos de uso</a>
                    <a href="#" class="text-decoration-none text-light" >Politica de privacidade</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="../../public/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>
</html>