<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-6">
      <div class="mb-6">
        <BackButtonAdmin />
      </div>

      <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white mb-8 text-center">
        🔔 Centro de Notificaciones
      </h1>

      <div class="flex justify-end mb-6">
        <button
          @click="markAllAsRead"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm shadow transition"
        >
          Marcar todas como leídas
        </button>
      </div>

      <div
        v-if="notifications.length"
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl divide-y divide-gray-200 dark:divide-gray-700"
      >
        <div
          v-for="n in notifications"
          :key="n.id"
          class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
        >
          <div class="flex-1">
            <p class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed">
              {{ n.message }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ new Date(n.created_at).toLocaleString('es-ES') }}
            </p>
          </div>
          <div class="text-sm">
            <button
              v-if="!n.read"
              @click="markAsRead(n.id)"
              class="text-blue-600 dark:text-blue-400 hover:underline transition"
            >
              📩 Marcar como leída
            </button>
            <span v-else class="text-green-600 dark:text-green-400 font-semibold"> ✔ Leída </span>
          </div>
        </div>
      </div>

      <div v-else class="text-center text-gray-500 dark:text-gray-400 mt-12">
        No tienes notificaciones por el momento.
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
  try {
    const res = await api.get('/notifications')
    notifications.value = res.data
  } catch (err) {
    console.error('Error al obtener notificaciones:', err)
  }
}

const markAllAsRead = async () => {
  try {
    await api.post('/notifications/mark-all-read')
    await fetchNotifications()
  } catch (err) {
    console.error('Error al marcar todas como leídas:', err)
  }
}

const markAsRead = async (id) => {
  try {
    await api.post(`/notifications/${id}/mark-read`)
    await fetchNotifications()
  } catch (err) {
    console.error('Error al marcar como leída:', err)
  }
}

onMounted(fetchNotifications)
</script>
