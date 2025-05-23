<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden hover:shadow-lg transition">
    <img :src="getImageUrl(product.image)" class="w-full h-48 object-cover" alt="Producto" />
    <div class="p-4">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ product.name }}</h3>
      <p class="text-sm text-gray-600 dark:text-gray-300">{{ product.description }}</p>
      <div class="mt-4 flex justify-between items-center">
        <span class="text-lg font-bold text-gray-900 dark:text-white">
          €{{ parseFloat(product.price).toFixed(2) }}
        </span>
        <div class="flex gap-2">
          <button @click="addToCart"
            class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-2 rounded transition">
            Añadir al carrito
          </button>
          <button @click="addToFavorites"
            class="bg-pink-500 hover:bg-pink-600 text-white text-sm px-3 py-2 rounded transition">
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
