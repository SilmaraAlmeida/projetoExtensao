        </main>

        <?php if (isset($_SESSION['userNivel']) && $_SESSION['userNivel'] == "G" && in_array($this->controller ?? '', ['Sistema', 'Usuario', 'Configuracao', 'Relatorio', 'Log'])): ?>
            </div>
        <?php endif; ?>

        <footer class="footer">
            <div class="footer-left">
                <p>Copyright © 2025 <strong>Via Muriaé</strong> Todos os direitos reservados.</p>
            </div>
            <div class="footer-right">
                <p>Entidades sem fins lucrativos</p>
            </div>
        </footer>
        </body>
        </html>