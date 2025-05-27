<template>
  <div
    class="group bg-white dark:bg-gray-800 rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden transition-transform duration-300 hover:-translate-y-2 flex flex-col h-[460px] border border-gray-200 dark:border-gray-700"
  >
    <!-- Imagen -->
    <div
      class="relative w-full h-44 bg-white dark:bg-gray-900 flex items-center justify-center border-b border-gray-200 dark:border-gray-700"
    >
      <img
        :src="getImageUrl(product.image)"
        class="h-full object-contain transition-transform duration-300 group-hover:scale-105"
        alt="Producto"
      />
    </div>

    <!-- Contenido -->
    <div class="p-5 flex flex-col justify-between flex-grow">
      <div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 truncate">
          {{ product.nombre }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
          {{ product.descripcion }}
        </p>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <span class="text-lg font-black text-gray-900 dark:text-white">
          €{{ parseFloat(product.precio).toFixed(2) }}
        </span>
        <div class="flex gap-2">
          <button
            @click="addToCart"
            class="bg-teal-600 hover:bg-teal-700 text-white text-xs px-4 py-2 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:scale-105"
          >
            Añadir
          </button>
          <button
            @click="toggleFavorite"
            :aria-label="isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos'"
            class="bg-rose-500 hover:bg-rose-600 text-white text-xs px-4 py-2 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:scale-105"
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
