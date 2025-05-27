// stores/cartStore.js
import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref([])

  const addItem = (product) => {
    const existing = items.value.find((p) => p.id === product.id)
    if (existing) {
      existing.cantidad += 1
    } else {
      items.value.push({ ...product, cantidad: 1 })
    }
  }

  const updateItemCantidad = (id, cantidad) => {
    const item = items.value.find((p) => p.id === id)
    if (item) item.cantidad = cantidad
  }

  const removeItem = (id) => {
    items.value = items.value.filter((p) => p.id !== id)
  }

  const clearCart = () => {
    items.value = []
  }

  const setCart = (data) => {
    items.value = data
  }

  const totalCount = computed(() =>
    items.value.reduce((sum, p) => sum + p.cantidad, 0)
  )

  const loadCart = () => {
    const saved = localStorage.getItem('cart')
    if (saved) {
      items.value = JSON.parse(saved)
    }
  }

  // Guarda automáticamente el carrito en localStorage al modificarse
  watch(
    items,
    (newVal) => {
      localStorage.setItem('cart', JSON.stringify(newVal))
    },
    { deep: true }
  )

  return {
    items,
    addItem,
    updateItemCantidad,
    removeItem,
    clearCart,
    setCart,
    totalCount,
    loadCart,
  }
})
