<template>
  <div class="relative z-50 inline-block">

    <!-- Botón de campana -->
    <button @click="visible = !visible" class="relative bg-white dark:bg-gray-800 p-3 rounded-full shadow-lg hover:scale-105 transition cursor-pointer">
      <span class="text-2xl">🔔</span>
      <span v-if="unreadCount" class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5">{{ unreadCount }}</span>
    </button>

    <!-- Panel flotante -->
   <div
  v-show="visible"
  class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl p-4 space-y-3 border dark:border-gray-700 transition-all duration-200 ease-out opacity-0"
  :class="{ 'opacity-100': visible }"
>
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-bold text-gray-800 dark:text-white">Notificaciones</h3>
        <button @click="markAllAsRead" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Marcar todo leído</button>
      </div>

      <div class="max-h-60 overflow-y-auto space-y-2 text-sm">
        <div
          v-for="n in notifications"
          :key="n.id"
          class="p-2 rounded-md border dark:border-gray-600"
          :class="n.read ? 'bg-gray-100 dark:bg-gray-700' : 'bg-yellow-100 dark:bg-yellow-800'"
        >
          {{ n.message }}
        </div>
      </div>

      <RouterLink to="/admin/notifications" class="block text-xs text-center text-blue-600 dark:text-blue-400 hover:underline">
        Ver todas
      </RouterLink>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const visible = ref(false)
const notifications = ref([])
const unreadCount = ref(0)

const fetchNotifications = async () => {
  const res = await api.get('/notifications')
  notifications.value = res.data
  unreadCount.value = res.data.filter(n => !n.read).length
}

const markAllAsRead = async () => {
  await api.post('/notifications/mark-all-read')
  fetchNotifications()
}

onMounted(fetchNotifications)
</script>

<style scoped>
/* para que funcione con v-show */
div[style*="opacity-0"] {
  pointer-events: none;
}

</style>