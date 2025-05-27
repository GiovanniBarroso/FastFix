// stores/favoriteStore.js
import { defineStore } from 'pinia'
import api from '@/services/api'

export const useFavoriteStore = defineStore('favorite', {
  state: () => ({
    favorites: []
  }),
  actions: {
    async fetchFavorites() {
      const res = await api.get('/favorites')
      this.favorites = res.data.favorites
      console.log('✅ Favoritos cargados:', this.favorites)
    },
    isFavorite(productId) {
      return this.favorites.some(fav => {
        const id = fav.product_id ?? fav.product?.id
        return id === productId
      })
    }
  }
})
