<template>
  <div
    class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-1 flex flex-col h-[440px]"
  >
    <!-- Imagen -->
    <img
      :src="getImageUrl(product.image)"
      class="w-full h-44 object-contain bg-white p-3 border-b border-gray-200 dark:border-gray-700"
      alt="Producto"
    />

    <!-- Contenido -->
    <div class="p-4 flex flex-col justify-between flex-grow">
      <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
          {{ product.nombre }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 min-h-[44px]">
          {{ product.descripcion }}
        </p>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <span class="text-base font-bold text-gray-900 dark:text-white">
          €{{ parseFloat(product.precio).toFixed(2) }}
        </span>
        <div class="flex gap-2">
          <button
            @click="addToCart"
            class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-4 py-2 rounded-md transition-transform transform hover:scale-105"
          >
            Añadir
          </button>
          <button
            @click="toggleFavorite"
            :aria-label="isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos'"
            class="bg-rose-400 hover:bg-rose-700 text-white text-sm px-4 py-2 rounded-md transition-transform transform hover:scale-105"
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
    required: true
  }
})

const baseURL = 'http://localhost:8000'

// Imagen del producto
const getImageUrl = (filename) => {
  if (!filename) return `${baseURL}/images/default.jpg`
  return filename.startsWith('http') ? filename : `${baseURL}/images/${filename}`
}

// Añadir al carrito
const addToCart = async () => {
  try {
    await api.post('/cart', {
      id: props.product.id,
      cantidad: 1
    })

    cart.addItem({
      id: props.product.id,
      product: {
        nombre: props.product.nombre,
        precio: props.product.precio,
        imagen: props.product.image,
        brand: props.product.brand || null
      },
      quantity: 1
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
  return favoriteStore.favorites.some(fav => {
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
      const fav = favoriteStore.favorites.find(f => {
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
