<div class="relative bg-white text-gray-900 font-sans overflow-hidden min-h-screen flex items-center justify-center px-8">

  <!-- Fundo com degradê de baixo pra cima / esquerda pra direita -->
  <div class="absolute inset-0 -z-20 bg-gradient-to-tr from-[#003399]/25 via-white to-[#f9f9ff]"></div>

  <!-- Background curvo com degradê (de baixo pra cima, esquerda pra direita) -->
  <div class="absolute bottom-0 left-0 w-full h-full overflow-hidden z-10">
    <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full block">
      <defs>
        <!-- Gradiente azul de baixo/esquerda para cima/direita -->
        <linearGradient id="curveGradient" x1="0" y1="1" x2="1" y2="0">
          <stop offset="0%" stop-color="#002080" />
          <stop offset="100%" stop-color="#003399" />
        </linearGradient>
      </defs>
      <!-- Parábola ajustada mais para direita -->
      <path d="M0,100 L0,86.5 Q50,75 85,0.1 L100,0 L100,100 Z" fill="url(#curveGradient)" />
    </svg>
  </div>

  <!-- Conteúdo -->
  <div class="relative z-20 flex flex-col lg:flex-row items-center justify-between w-full max-w-6xl py-16 lg:py-24 -mt-16 lg:-mt-20">

    <!-- Texto -->
    <div class="max-w-xl text-center lg:text-left space-y-5 px-4">
      <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">
        Conecte-se ao <span class="text-[#003399]">futuro</span> do trabalho em <span class="text-[#FF7A00]">Muriaé</span>
      </h1>

      <p class="text-gray-600 text-lg leading-relaxed">
        A plataforma que une empresas e talentos com propósito.
        Experimente uma nova forma de contratar e ser contratado.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 pt-4 justify-center lg:justify-start">
        <a href="<?= baseUrl() ?>cadastro" 
           class="bg-[#003399] text-white px-8 py-3 rounded-md font-semibold hover:bg-[#002080] transition-all duration-200 text-center">
          Sou Empresa
        </a>
        <a href="<?= baseUrl() ?>cadastro" 
           class="bg-[#FF7A00] text-white px-8 py-3 rounded-md font-semibold hover:bg-[#e66d00] transition-all duration-200 text-center">
          Sou Candidato
        </a>
      </div>
    </div>
  </div>
</div>
