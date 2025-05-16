<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">👥 Gestión de usuarios</h1>
        <button
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition"
        >
          + Añadir usuario
        </button>
      </div>

      <!-- Tabla de usuarios -->
      <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead class="bg-blue-500 dark:bg-blue-600 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Nombre</th>
              <th class="p-4 text-left">Email</th>
              <th class="p-4 text-left">Rol</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(user, index) in users"
              :key="user.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ user.name }}</td>
              <td class="p-4">{{ user.email }}</td>
              <td class="p-4">
                <span
                  :class="[ 'px-3 py-1 rounded-full text-xs font-semibold',
                    user.role?.nombre === 'admin'
                      ? 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white'
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white'
                  ]"
                >
                  {{ user.role?.nombre || 'Sin rol' }}
                </span>
              </td>
              <td class="p-4 flex gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-xs font-semibold">
                  Editar
                </button>
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-xs font-semibold">
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const users = ref([])

onMounted(async () => {
  try {
    const response = await api.get('/users')
    users.value = response.data
    console.log('Usuarios cargados:', users.value)
  } catch (error) {
    console.error('Error al cargar usuarios:', error)
  }
})
</script>
