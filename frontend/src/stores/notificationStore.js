// src/stores/notificationStore.js
import { defineStore } from 'pinia'
import api from '@/services/api'

export const useNotificationStore = defineStore('notification', {
  state: () => ({
    notifications: [],
    unreadCount: 0
  }),

  actions: {
    async fetchNotifications() {
      try {
        const res = await api.get('/notifications')
        this.notifications = res.data
        this.unreadCount = res.data.filter(n => !n.read).length
      } catch (e) {
        console.error('Error al cargar notificaciones:', e)
      }
    },

    markAllAsRead() {
      return api.post('/notifications/mark-all-read').then(() => {
        this.fetchNotifications()
      })
    },

    markAsRead(id) {
      return api.post(`/notifications/${id}/mark-read`).then(() => {
        this.fetchNotifications()
      })
    },

    addNotification(notification) {
      this.notifications.unshift(notification)
      this.unreadCount++
    }
  }
})
