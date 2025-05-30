<template>
  <div
    class="group relative rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-gray-800 dark:via-gray-900 dark:to-black shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-500 flex flex-col min-h-[540px] max-w-xs w-full"
  >
    <!-- Imagen -->
    <div
      class="relative w-full h-48 bg-white dark:bg-gray-950 flex items-center justify-center border-b border-gray-300 dark:border-gray-700 overflow-hidden"
    >
      <img
        :src="getImageUrl(product.image)"
        :alt="`Imagen de ${product.nombre}`"
        class="h-full object-contain transition-transform duration-500 group-hover:scale-110"
      />
      <!-- Etiqueta de descuento -->
      <div
        v-if="product.precio_base > product.precio"
        class="absolute top-2 left-2 bg-gradient-to-br from-red-500 to-rose-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg animate-pulse"
      >
        -{{ calcularPorcentajeDescuento(product.precio_base, product.precio) }}%
      </div>
    </div>

    <!-- Contenido -->
    <div class="flex flex-col justify-between flex-grow p-5 space-y-4">
      <div>
        <h3 class="text-lg font-extrabold text-white leading-snug mb-1">
          {{ product.nombre }}
        </h3>
        <p class="text-sm text-gray-400 line-clamp-2">
          {{ product.descripcion }}
        </p>
      </div>

      <div class="flex justify-between items-end mt-auto">
        <!-- Precios -->
        <div class="flex flex-col">
          <span class="text-xl font-black text-teal-400 leading-none">
            €{{ parseFloat(product.precio).toFixed(2) }}
          </span>
          <span
            v-if="product.precio_base > product.precio"
            class="text-sm text-gray-500 dark:text-gray-400 line-through"
          >
            €{{ parseFloat(product.precio_base).toFixed(2) }}
          </span>
        </div>

        <!-- Botones -->
        <div class="flex gap-2">
          <button
            @click="addToCart"
            class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-4 py-2 rounded-full shadow-md hover:shadow-lg transition hover:scale-105 focus:outline-none"
            title="Añadir al carrito"
          >
            🛒 Añadir
          </button>
          <button
            @click="toggleFavorite"
            :aria-label="isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos'"
            :title="isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos'"
            class="bg-rose-600 hover:bg-rose-700 text-white text-xs px-4 py-2 rounded-full shadow-md hover:shadow-lg transition hover:scale-105 focus:outline-none"
          >
            {{ isFavorite ? '💖' : '🤍' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useCartStore } from '@/stores/cartStore'
import { useFavoriteStore } from '@/stores/favoriteStore'
import api from '@/services/api'
import { useToast } from 'vue-toastification'

const toast = useToast()
const cart = useCartStore()
const favoriteStore = useFavoriteStore()

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const getImageUrl = (filename) => {
  if (!filename) return '/images/default.jpg'
  return `/products/${filename}`
}

const calcularPorcentajeDescuento = (base, actual) => {
  return Math.round(((base - actual) / base) * 100)
}

// Añadir al carrito
const addToCart = async () => {
  try {
    await api.post('/cart', {
      id: props.product.id,
      cantidad: 1,
    })

    cart.addItem({
      id: props.product.id,
      product: {
        nombre: props.product.nombre,
        precio: props.product.precio,
        imagen: props.product.image,
        brand: props.product.brand || null,
      },
      cantidad: 1,
    })

    toast.success(`${props.product.nombre} agregado al carrito.`)
  } catch (error) {
    console.error(error)
    toast.error('No fue posible añadir el producto al carrito.')
  }
}

// ¿Es favorito?
const isFavorite = computed(() => {
  const id = props.product.id
  return favoriteStore.favorites.some((fav) => {
    const favId = fav.product_id ?? fav.product?.id
    return favId === id
  })
})

// Cargar favoritos si no se han cargado aún
onMounted(async () => {
  if (!favoriteStore.favorites.length) {
    await favoriteStore.fetchFavorites()
  }
})

// Añadir o quitar de favoritos
const toggleFavorite = async () => {
  try {
    if (isFavorite.value) {
      const fav = favoriteStore.favorites.find((f) => {
        const favId = f.product_id ?? f.product?.id
        return favId === props.product.id
      })
      if (fav) await api.delete(`/favorites/${fav.id}`)
      toast.info(`${props.product.nombre} eliminado de favoritos`)
    } else {
      await api.post('/favorites', { product_id: props.product.id })
      toast.success(`${props.product.nombre} agregado a favoritos`)
    }

    await favoriteStore.fetchFavorites()
  } catch (error) {
    console.error(error)
    toast.error('Error al actualizar favoritos')
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
