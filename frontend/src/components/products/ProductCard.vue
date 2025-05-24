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
      <!-- Título y descripción -->
      <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
          {{ product.name }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 min-h-[44px]">
          {{ product.description }}
        </p>
      </div>

      <!-- Precio y botones -->
      <div class="mt-4 flex justify-between items-center">
        <span class="text-base font-bold text-gray-900 dark:text-white">
          €{{ parseFloat(product.price).toFixed(2) }}
        </span>
        <div class="flex gap-2">
          <button
            @click="addToCart"
            class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-4 py-2 rounded-md transition-transform transform hover:scale-105"
          >
            Añadir
          </button>
          <button
            @click="addToFavorites"
            class="bg-rose-600 hover:bg-rose-700 text-white text-sm px-4 py-2 rounded-md transition-transform transform hover:scale-105"
          >
            ❤
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '@/stores/cartStore'
import api from '@/services/api'
import { useToast } from 'vue-toastification'
import { defineProps } from 'vue'

const toast = useToast()
const cart = useCartStore()

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const baseURL = 'http://localhost:8000'

const getImageUrl = (filename) => {
  if (!filename) return `${baseURL}/images/default.jpg`
  return filename.startsWith('http') ? filename : `${baseURL}/images/${filename}`
}

const addToCart = async () => {
  try {
    await api.post('/cart', {
      id: props.product.id,
      cantidad: 1
    })

    cart.addItem({
      id: props.product.id,
      name: props.product.name,
      price: props.product.price,
      image: props.product.image,
      quantity: 1
    })

    toast.success(`${props.product.name} agregado al carrito.`)
  } catch (error) {
    console.error(error)
    toast.error('No fue posible añadir el producto al carrito.')
  }
}

const addToFavorites = async () => {
  try {
    await api.post('/favorites', {
      product_id: props.product.id
    })
    toast.success(`${props.product.name} agregado a favoritos.`)
  } catch (error) {
    console.error(error)
    toast.error('No fue posible añadir a favoritos.')
  }
}
</script>
