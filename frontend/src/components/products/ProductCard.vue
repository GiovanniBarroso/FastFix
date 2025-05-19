<template>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden hover:shadow-lg transition">
      <img :src="getImageUrl(product.image)" class="w-full h-48 object-cover" alt="Producto" />
      <div class="p-4">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ product.name }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ product.description }}</p>
        <div class="mt-4 flex justify-between items-center">
          <span class="text-lg font-bold text-gray-900 dark:text-white">€{{ parseFloat(product.price).toFixed(2) }}</span>
          <button
            @click="addToCart"
            class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded transition"
          >
            Añadir al carrito
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import api from '@/services/api'
  import { useToast } from 'vue-toastification'
  import { defineProps } from 'vue'
  
  const toast = useToast()
  
  // ✅ Extraer la prop
  const props = defineProps({
    product: {
      type: Object,
      required: true
    }
  })
  
  const getImageUrl = (filename) => {
    if (!filename) return '/images/default.jpg'
    return filename.startsWith('http') ? filename : `/images/${filename}`
  }
  
  const addToCart = async () => {
    try {
      await api.post('/cart', {
        id: props.product.id,
        cantidad: 1
      })
      toast.success(`${props.product.name} agregado al carrito.`)
    } catch (error) {
      console.error(error)
      toast.error('No fue posible añadir el producto al carrito.')
    }
  }
  </script>
  