<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-6">

      <div class="mb-6">
        <BackButtonAdmin />
      </div>

      <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">🔔 Centro de Notificaciones</h1>

      <div class="flex justify-end mb-4">
        <button @click="markAllAsRead" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
          Marcar todas como leídas
        </button>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden divide-y divide-gray-200 dark:divide-gray-700">
        <div
          v-for="n in notifications"
          :key="n.id"
          class="p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition flex justify-between items-center"
        >
          <div class="text-sm text-gray-700 dark:text-gray-200">
            {{ n.message }}
          </div>
          <small class="block text-xs text-gray-500 dark:text-gray-400 mt-1">
            {{ new Date(n.created_at).toLocaleString() }}
          </small>

          <div>
            <button
              v-if="!n.read"
              @click="markAsRead(n.id)"
              class="text-xs text-blue-600 hover:underline dark:text-blue-400"
            >
              Marcar como leída
            </button>
            <span v-else class="text-xs text-gray-400">✔ Leída</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

const notifications = ref([])

const fetchNotifications = async () => {
  const res = await api.get('/notifications')
  notifications.value = res.data
}

const markAllAsRead = async () => {
  await api.post('/notifications/mark-all-read')
  fetchNotifications()
}

const markAsRead = async (id) => {
  await api.post(`/notifications/${id}/mark-read`)
  fetchNotifications()
}

onMounted(fetchNotifications)
</script>
