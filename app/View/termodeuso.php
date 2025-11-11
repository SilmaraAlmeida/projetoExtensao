<?php
$termo = $dados['termo'] ?? null;

if (!$termo) {
    echo '<div class="min-h-screen flex items-center justify-center bg-gray-50">';
    echo '<div class="text-center">';
    echo '<i class="fas fa-file-contract text-6xl text-gray-300 mb-4"></i>';
    echo '<p class="text-gray-600 text-lg">Termos de uso não disponíveis no momento.</p>';
    echo '<a href="' . baseUrl() . '" class="mt-4 inline-block text-blue-600 hover:text-blue-800">← Voltar</a>';
    echo '</div>';
    echo '</div>';
    return;
}
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    
    <!-- Header da Página -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-file-contract text-blue-900 text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Termos de Uso</h1>
                        <p class="text-sm text-gray-600">Via Muriaé - Plataforma de Empregos</p>
                    </div>
                </div>
                <a href="<?= baseUrl() ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        
        <!-- Card com Sombra -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Banner Superior -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-2">Termos de Uso</h2>
                        <p class="text-blue-100">Leia atentamente antes de utilizar a plataforma</p>
                    </div>
                    <?php if (!empty($termo['dataRegistro'])): ?>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 text-center">
                            <p class="text-xs text-blue-100 mb-1">Última atualização</p>
                            <p class="text-sm font-bold"><?= date('d/m/Y', strtotime($termo['dataRegistro'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Conteúdo do Termo - RENDERIZADO SEM ESCAPAR -->
            <div class="px-8 py-10 lg:px-12 lg:py-12">
                <div class="termo-conteudo whitespace-pre-wrap text-gray-700 leading-relaxed">
                    <?= $termo['textoTermo'] ?>
                </div>
            </div>

            <!-- Rodapé -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center text-gray-600">
                        <p class="text-sm font-medium">Ao utilizar o Via Muriaé, você concorda com estes Termos de Uso.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Badge LGPD -->
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>
                <i class="fas fa-shield-alt mr-1"></i>
                Seus dados estão protegidos de acordo com a LGPD
            </p>
        </div>

    </div>

</div>

<style>
.termo-conteudo {
    font-size: 1rem;
    line-height: 1.8;
}

.termo-conteudo h1,
.termo-conteudo h2,
.termo-conteudo h3 {
    font-weight: 700;
    color: #1e3a8a;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.termo-conteudo h1 { font-size: 2rem; }
.termo-conteudo h2 { font-size: 1.5rem; }
.termo-conteudo h3 { font-size: 1.25rem; }

.termo-conteudo p {
    margin-bottom: 1rem;
}

.termo-conteudo ul,
.termo-conteudo ol {
    margin-left: 2rem;
    margin-bottom: 1rem;
}

.termo-conteudo li {
    margin-bottom: 0.5rem;
}

.termo-conteudo strong {
    font-weight: 600;
    color: #1f2937;
}
</style>
