<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      
      <!-- Botón de volver reutilizable -->
      <div class="mb-6">
        <BackButtonAdmin />
      </div>
      
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">👥 Gestión de usuarios</h1>
        <button
          @click="openForCreate"
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
              <th class="p-4 text-left">Apellidos</th>
              <th class="p-4 text-left">Email</th>
              <th class="p-4 text-left">Teléfono</th>
              <th class="p-4 text-left">Rol</th>
              <th class="p-4 text-left">Registro</th>
              <th class="p-4 text-left">Verificado</th>
              <th class="p-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in users" :key="user.id" class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ user.name }}</td>
              <td class="p-4">{{ user.apellidos || '—' }}</td>
              <td class="p-4">{{ user.email }}</td>
              <td class="p-4">{{ user.telefono || '—' }}</td>
              <td class="p-4">
                <span
                  :class="[ 'px-3 py-1 rounded-full text-xs font-semibold',
                    user.role?.name === 'admin'
                      ? 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white'
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white'
                  ]"
                >
                  {{ user.role?.name || 'Sin rol' }}
                </span>
              </td>
              <td class="p-4">{{ formatFecha(user.fecha_registro || user.created_at) }}</td>
              <td class="p-4">
                <span :class="user.email_verified_at ? 'text-green-600' : 'text-red-600'">
                  {{ user.email_verified_at ? '✔' : '✘' }}
                </span>
              </td>
              <td class="p-4 flex gap-2">
                <button @click="openForEdit(user)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-xs font-semibold">
                  Editar
                </button>
                <button @click="deleteUser(user.id)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-xs font-semibold">
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <UserFormModal
      :show="showModal"
      :userToEdit="selectedUser"
      @close="showModal = false"
      @saved="fetchUsers"
    />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import UserFormModal from '@/components/users/UserFormModal.vue'
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'

const users = ref([])
const showModal = ref(false)
const selectedUser = ref(null)

const fetchUsers = async () => {
  try {
    const response = await api.get('/users')
    users.value = response.data
  } catch (error) {
    console.error('Error al cargar usuarios:', error)
  }
}

const formatFecha = (fecha) => {
  return new Date(fecha).toLocaleDateString('es-ES')
}


const openForCreate = () => {
  selectedUser.value = null
  showModal.value = true
}

const openForEdit = (user) => {
  selectedUser.value = user
  showModal.value = true
}

const deleteUser = async (id) => {
  if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
    try {
      await api.delete(`/users/${id}`)
      await fetchUsers()
    } catch (error) {
      console.error('Error al eliminar usuario:', error)
    }
  }
}

onMounted(fetchUsers)
</script>
