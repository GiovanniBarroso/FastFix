<template>
  <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6" data-aos="fade-up" data-aos-duration="700">
      <!-- Botón de volver -->
      <div class="mb-6" data-aos="fade-right" data-aos-delay="100">
        <BackButtonAdmin />
      </div>

      <!-- Encabezado -->
      <div
        class="flex justify-between items-center mb-10"
        data-aos="zoom-in-up"
        data-aos-delay="200"
      >
        <h1
          class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500"
        >
          👥 Gestión de usuarios
        </h1>
        <button
          @click="openForCreate"
          class="bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:shadow-[0_0_12px_rgba(99,102,241,0.6)] transition-all"
          data-aos="fade-left"
          data-aos-delay="300"
        >
          + Añadir usuario
        </button>
      </div>

      <!-- Tabla de usuarios -->
      <div
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
        data-aos="fade-up"
        data-aos-delay="400"
      >
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
          <thead
            class="bg-gradient-to-r from-yellow-300 to-yellow-500 dark:from-yellow-500 dark:to-yellow-600 text-gray-900 dark:text-white"
          >
            <tr>
              <th class="p-4 text-left font-semibold tracking-wide">#</th>
              <th class="p-4 text-left font-semibold tracking-wide">Nombre</th>
              <th class="p-4 text-left font-semibold tracking-wide">Apellidos</th>
              <th class="p-4 text-left font-semibold tracking-wide">Email</th>
              <th class="p-4 text-left font-semibold tracking-wide">Teléfono</th>
              <th class="p-4 text-left font-semibold tracking-wide">Rol</th>
              <th class="p-4 text-left font-semibold tracking-wide">Registro</th>
              <th class="p-4 text-left font-semibold tracking-wide">Verificado</th>
              <th class="p-4 text-left font-semibold tracking-wide">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(user, index) in users"
              :key="user.id"
              class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              data-aos="fade-up"
              data-aos-delay="500"
            >
              <td class="p-4">{{ index + 1 }}</td>
              <td class="p-4 font-medium">{{ user.nombre }}</td>
              <td class="p-4">{{ user.apellidos || '—' }}</td>
              <td class="p-4">{{ user.email }}</td>
              <td class="p-4">{{ user.telefono || '—' }}</td>
              <td class="p-4">
                <span
                  :class="[
                    'inline-block px-2 py-1 text-xs font-semibold rounded-full shadow-sm',
                    user.role?.nombre === 'admin'
                      ? 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-white'
                      : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white',
                  ]"
                >
                  {{ user.role?.nombre || 'Sin rol' }}
                </span>
              </td>
              <td class="p-4 font-mono">
                {{ formatFecha(user.fecha_registro || user.created_at) }}
              </td>
              <td class="p-4">
                <span
                  :class="[
                    'inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full shadow-sm',
                    user.email_verified_at
                      ? 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-white'
                      : 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-white',
                  ]"
                >
                  {{ user.email_verified_at ? '✔ Verificado' : '✘ No verificado' }}
                </span>
              </td>
              <td class="p-4 flex gap-2">
                <button
                  @click="openForEdit(user)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  ✏️ Editar
                </button>
                <button
                  @click="deleteUser(user.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  🗑️ Eliminar
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
import AOS from 'aos'
import 'aos/dist/aos.css'

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

onMounted(() => {
  fetchUsers()
  AOS.init({ duration: 800, once: true })
})
</script>
