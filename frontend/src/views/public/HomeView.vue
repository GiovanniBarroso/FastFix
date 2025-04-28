<template>
  <div class="pt-20 bg-background text-foreground">

    <!-- Hero -->
    <section class="text-center py-24">
      <h1 class="text-5xl sm:text-6xl font-extrabold mb-6 leading-tight">
        Bienvenido a <span class="text-[var(--color-red-600)]">FastFix</span>
      </h1>
      <p class="text-xl sm:text-2xl max-w-2xl mx-auto mb-10">
        Reparaciones profesionales con calidad, rapidez y garantía de excelencia.
      </p>
      <router-link to="/product-list"
        class="inline-block bg-[var(--color-red-600)] hover:bg-[var(--color-red-700)] text-white text-lg font-semibold px-8 py-4 rounded-full transition-transform transform hover:scale-105 shadow-lg">
        Ver productos
      </router-link>
    </section>

    <!-- ¿Qué reparamos? -->
    <section class="py-20 bg-[var(--color-amber-50)]">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold mb-4">¿Qué reparamos?</h2>
        <p class="text-lg text-foreground/70">Expertos en una amplia variedad de dispositivos</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 px-8">
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">📱</div>
          <h3 class="text-xl font-semibold">Móviles</h3>
        </div>
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">💻</div>
          <h3 class="text-xl font-semibold">Ordenadores</h3>
        </div>
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">🎮</div>
          <h3 class="text-xl font-semibold">Consolas</h3>
        </div>
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">📱</div>
          <h3 class="text-xl font-semibold">Tablets</h3>
        </div>
      </div>
    </section>

    <!-- ¿Por qué elegirnos? -->
    <section class="py-20">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold mb-4">¿Por qué elegirnos?</h2>
        <p class="text-lg text-foreground/70">Tu satisfacción es nuestra prioridad</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 px-8">
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">⚡</div>
          <h3 class="text-xl font-semibold">Servicio rápido</h3>
          <p class="text-sm mt-2 text-center text-foreground/60">Solucionamos averías en tiempo récord.</p>
        </div>
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">✅</div>
          <h3 class="text-xl font-semibold">Garantía 100%</h3>
          <p class="text-sm mt-2 text-center text-foreground/60">Confianza y respaldo en cada reparación.</p>
        </div>
        <div
          class="flex flex-col items-center bg-card p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-2">
          <div class="text-5xl mb-4">💬</div>
          <h3 class="text-xl font-semibold">Soporte personalizado</h3>
          <p class="text-sm mt-2 text-center text-foreground/60">Estamos contigo en todo el proceso.</p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-[var(--color-amber-50)] text-center">
      <h2 class="text-3xl font-bold mb-6">¿Tienes una avería?</h2>
      <p class="text-lg text-foreground/70 mb-8">
        Solicita presupuesto sin compromiso y recibe atención inmediata.
      </p>
      <router-link to="/budget-request"
        class="inline-block bg-[var(--color-red-600)] hover:bg-[var(--color-red-700)] text-white text-lg font-semibold px-8 py-4 rounded-full transition-transform transform hover:scale-105 shadow-lg">
        Solicitar presupuesto
      </router-link>
    </section>

  </div>
</template>

<script setup>
// Nada necesario en el script por ahora
</script>

<!-- NO style scoped porque TODO se hace con clases Tailwind puras -->
