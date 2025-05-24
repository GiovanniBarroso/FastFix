import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref([])

  const addItem = (product) => {
    const existing = items.value.find((p) => p.id === product.id)
    if (existing) {
      existing.quantity += 1
    } else {
      items.value.push({ ...product, quantity: 1 })
    }
  }

  const removeItem = (productId) => {
    items.value = items.value.filter((p) => p.id !== productId)
  }

  const clearCart = () => {
    items.value = []
  }

  const totalCount = computed(() => items.value.reduce((sum, p) => sum + p.quantity, 0))

  const loadCart = () => {
    const saved = localStorage.getItem('cart')
    if (saved) {
      items.value = JSON.parse(saved)
    }
  }

  // Guardar automáticamente al cambiar
  watch(items, (newVal) => {
    localStorage.setItem('cart', JSON.stringify(newVal))
  }, { deep: true })

  return {
    items,
    addItem,
    removeItem,
    clearCart,
    totalCount,
    loadCart, // <- importante exportarlo
  }
})
