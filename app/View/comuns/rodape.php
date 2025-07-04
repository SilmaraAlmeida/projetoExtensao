    </main>

    <?php if (isset($_SESSION['userNivel']) && $_SESSION['userNivel'] == "G" && in_array($this->controller ?? '', ['Sistema', 'Usuario', 'Configuracao', 'Relatorio', 'Log'])): ?>
        </div>
    <?php endif; ?>

    <!-- <footer class="footer">
        <div class="footer-left">
            <p>Copyright © 2025 <strong>Via Muriaé</strong> Todos os direitos reservados.</p>
        </div>
        <div class="footer-right">
            <p>Entidades sem fins assslucrativos</p>
        </div>
    </footer> -->

    <footer class=""></footer>
    
    <script src="../../public/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>
</html>