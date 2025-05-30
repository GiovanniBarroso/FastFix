<template>
  <section class="py-20 bg-[#F8F9FA] dark:bg-[#1E2A38] min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón de volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Título -->
      <div class="text-center mb-12">
        <h1
          class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#FFBF00] to-[#007BFF] mb-4 animate-glow"
        >
          ❤️ Tus favoritos
        </h1>
        <p class="text-lg text-[#5E6C77] dark:text-[#E5E7EB] animate-fade-in">
          Estos son los productos que has marcado como favoritos.
        </p>
      </div>

      <!-- Grid con animaciones -->
      <template v-if="favorites.length">
        <transition-group
          name="fade-scale"
          tag="div"
          class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 animate-fade-up"
        >
          <FavoriteCard
            v-for="fav in favorites"
            :key="fav.id"
            :favorite="fav"
            @removed="fetchFavorites"
            class="transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(255,191,0,0.4)] rounded-2xl"
          />
        </transition-group>
      </template>
      <template v-else>
        <div class="text-center text-[#5E6C77] dark:text-[#E5E7EB] mt-20 text-lg animate-fade-in">
          Aún no tienes productos en tu lista de favoritos. 🌟
        </div>
      </template>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import FavoriteCard from '@/components/products/FavoriteCard.vue'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'

const favorites = ref([])

const fetchFavorites = async () => {
  try {
    const response = await api.get('/favorites')
    console.log('Favoritos cargados:', response.data.favorites)
    favorites.value = response.data.favorites
  } catch (error) {
    console.error('Error al cargar favoritos:', error)
  }
}

onMounted(fetchFavorites)
</script>

<style scoped>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.3s ease;
}
.fade-scale-enter-from {
  opacity: 0;
  transform: scale(0.95);
}
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.animate-fade-in-down {
  animation: fadeInDown 0.6s ease-out both;
}

.animate-fade-in {
  animation: fadeIn 0.8s ease-out both;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fadeInUp 0.8s ease-out both;
}

@keyframes glow {
  0% {
    text-shadow:
      0 0 5px rgba(0, 123, 255, 0.4),
      0 0 10px rgba(0, 123, 255, 0.3);
  }
  100% {
    text-shadow:
      0 0 12px rgba(255, 191, 0, 0.5),
      0 0 20px rgba(255, 191, 0, 0.4);
  }
}
.animate-glow {
  animation: glow 2.2s ease-in-out infinite alternate;
}
</style>
