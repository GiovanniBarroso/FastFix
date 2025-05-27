<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
      <h1 class="text-5xl font-extrabold text-center text-gray-800 dark:text-white mb-16">
        🛠️ Panel de Administración
      </h1>

      <!-- Botón especial para la agenda -->
      <div class="flex justify-center mb-6">
        <button
          @click="router.push('/admin/calendar')"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition-all"
        >
          📅 Ver agenda inteligente
        </button>
      </div>

      <!-- Botón separado para ver notificaciones -->
      <div class="flex justify-center mb-10 relative">
        <router-link
          to="/admin/notifications"
          class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-full shadow-md transition relative"
        >
          🔔 Ver todas las notificaciones

          <span
            v-if="unreadCount > 0"
            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow"
          >
            {{ unreadCount }}
          </span>
        </router-link>
      </div>


      <div class="flex flex-wrap justify-center gap-10">
        <div
          v-for="panel in adminPanels"
          :key="panel.nombre"
          @click="router.push(panel.ruta)"
          class="w-[300px] bg-gradient-to-br from-white to-gray-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-2xl text-center shadow-md hover:shadow-xl transform transition-all hover:-translate-y-1 hover:scale-[1.02] cursor-pointer"
        >
          <div class="text-5xl mb-4 text-blue-600 dark:text-blue-400">
            {{ panel.icono }}
          </div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
            {{ panel.nombre }}
          </h2>
          <p class="text-gray-600 dark:text-gray-300 text-sm">
            {{ panel.descripcion }}
          </p>
        </div>
      </div>


      <!-- 📊 Estadísticas del día -->
      <div class="mt-16 px-4 py-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
          📊 Estadísticas del día
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
          <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-5 shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 dark:text-gray-300">Pedidos hoy</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ stats.pedidos }}</p>
          </div>
          <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-5 shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 dark:text-gray-300">Presupuestos pendientes</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ stats.presupuestos_pendientes }}</p>
          </div>
          <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-5 shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 dark:text-gray-300">Ventas hoy</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">€{{ stats.ventas.toFixed(2) }}</p>
          </div>
          <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-5 shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500 dark:text-gray-300">Usuarios</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ stats.usuarios }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Chat Inteligente flotante -->
    <StartAdminChat />

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import StartAdminChat from '@/components/admin/StartAdminChat.vue'

const router = useRouter()

const stats = ref({
  pedidos: 0,
  presupuestos_pendientes: 0,
  ventas: 0,
  usuarios: 0
})

const unreadCount = ref(0)

onMounted(async () => {
  try {
    const res = await api.get('/admin/stats')
    stats.value = res.data
  } catch (error) {
    console.error('Error al cargar estadísticas:', error)
  }

  try {
    const res = await api.get('/notifications/unread')
    unreadCount.value = res.data.length
  } catch (error) {
    console.error('Error al cargar notificaciones no leídas:', error)
  }
})

const adminPanels = [
  {
    nombre: 'Gestión de productos',
    descripcion: 'Agrega, edita o elimina productos disponibles.',
    ruta: '/admin/products',
    icono: '📦'
  },
  {
    nombre: 'Servicios de reparación',
    descripcion: 'Gestiona los servicios técnicos ofrecidos.',
    ruta: '/admin/repairs',
    icono: '🔧'
  },
  {
    nombre: 'Pedidos',
    descripcion: 'Consulta todos los pedidos realizados.',
    ruta: '/admin/orders',
    icono: '🧾'
  },
  {
    nombre: 'Presupuestos',
    descripcion: 'Revisa las solicitudes de presupuesto enviadas.',
    ruta: '/admin/budgets',
    icono: '📝'
  },
  {
    nombre: 'Usuarios',
    descripcion: 'Administra las cuentas de los usuarios registrados.',
    ruta: '/admin/users',
    icono: '👥'
  }
]
</script>
