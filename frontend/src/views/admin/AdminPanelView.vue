<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
      <!-- Título -->
      <h1
        class="text-5xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600 mb-16 leading-tight"
        data-aos="fade-down"
      >
        🛠️ Panel de Administración
      </h1>

      <!-- Botón de agenda -->
      <div class="flex justify-center mb-6" data-aos="zoom-in">
        <button
          @click="router.push('/admin/calendar')"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg hover:shadow-[0_0_12px_rgba(59,130,246,0.6)] transition-all"
        >
          📅 Ver agenda inteligente
        </button>
      </div>

      <!-- Botón de notificaciones -->
      <div class="flex justify-center mb-10 relative" data-aos="zoom-in">
        <router-link
          to="/admin/notifications"
          class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-full shadow-md hover:shadow-[0_0_12px_rgba(139,92,246,0.6)] transition relative"
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

      <!-- Paneles -->
      <div class="flex flex-wrap justify-center gap-10">
        <div
          v-for="(panel, index) in adminPanels"
          :key="panel.nombre"
          @click="router.push(panel.ruta)"
          :data-aos="'fade-up'"
          :data-aos-delay="index * 100"
          :class="[
            'group w-[300px] backdrop-blur-md border border-gray-200 dark:border-gray-700 p-8 rounded-3xl text-center shadow-2xl transform transition-all hover:-translate-y-1 hover:scale-105 cursor-pointer',
            index % 3 === 0
              ? 'bg-white/90 dark:bg-white/5 hover:shadow-[0_0_20px_rgba(59,130,246,0.4)]'
              : index % 3 === 1
                ? 'bg-white/90 dark:bg-white/5 hover:shadow-[0_0_20px_rgba(239,68,68,0.4)]'
                : 'bg-white/90 dark:bg-white/5 hover:shadow-[0_0_20px_rgba(132,204,22,0.4)]',
          ]"
        >
          <div
            class="text-5xl mb-4 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform"
          >
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

      <!-- Estadísticas -->
      <div
        class="mt-20 px-6 py-10 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl"
        data-aos="fade-up"
      >
        <h2
          class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-500 mb-8 leading-tight"
        >
          📊 Estadísticas del día
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div
            class="bg-gradient-to-br from-blue-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 shadow hover:shadow-lg transition hover:scale-105"
            data-aos="zoom-in"
          >
            <p class="text-sm text-gray-600 dark:text-gray-300">Pedidos hoy</p>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
              🛒 {{ stats.pedidos }}
            </p>
          </div>
          <div
            class="bg-gradient-to-br from-green-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 shadow hover:shadow-lg transition hover:scale-105"
            data-aos="zoom-in"
          >
            <p class="text-sm text-gray-600 dark:text-gray-300">Presupuestos pendientes</p>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">
              📋 {{ stats.presupuestos_pendientes }}
            </p>
          </div>
          <div
            class="bg-gradient-to-br from-yellow-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 shadow hover:shadow-lg transition hover:scale-105"
            data-aos="zoom-in"
          >
            <p class="text-sm text-gray-600 dark:text-gray-300">Ventas hoy</p>
            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
              💶 €{{ Number(stats.ventas || 0).toFixed(2) }}
            </p>
          </div>
          <div
            class="bg-gradient-to-br from-purple-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 shadow hover:shadow-lg transition hover:scale-105"
            data-aos="zoom-in"
          >
            <p class="text-sm text-gray-600 dark:text-gray-300">Usuarios</p>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
              👥 {{ stats.usuarios }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Chat flotante -->
    <StartAdminChat />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import StartAdminChat from '@/components/admin/StartAdminChat.vue'

const router = useRouter()
const unreadCount = ref(0)

const stats = ref({
  pedidos: 0,
  presupuestos_pendientes: 0,
  ventas: 0,
  usuarios: 0,
})

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
    icono: '📦',
  },
  {
    nombre: 'Servicios de reparación',
    descripcion: 'Gestiona los servicios técnicos ofrecidos.',
    ruta: '/admin/repairs',
    icono: '🔧',
  },
  {
    nombre: 'Pedidos',
    descripcion: 'Consulta todos los pedidos realizados.',
    ruta: '/admin/orders',
    icono: '🧾',
  },
  {
    nombre: 'Presupuestos',
    descripcion: 'Revisa las solicitudes de presupuesto enviadas.',
    ruta: '/admin/budgets',
    icono: '📝',
  },
  {
    nombre: 'Usuarios',
    descripcion: 'Administra las cuentas de los usuarios registrados.',
    ruta: '/admin/users',
    icono: '👥',
  },
  {
    nombre: 'Descuentos',
    descripcion: 'Crea, edita o elimina cupones y descuentos para productos.',
    ruta: '/admin/discounts',
    icono: '🏷️',
  },
]
</script>
