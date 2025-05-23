import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

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

  return { items, addItem, removeItem, clearCart, totalCount }
})
