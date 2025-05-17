<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-xl">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        {{ isEditing ? '✏️ Editar Usuario' : '➕ Añadir Usuario' }}
      </h2>

      <form @submit.prevent="handleSubmit" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
          <input v-model="form.name" type="text" required
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input v-model="form.email" type="email" required
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol</label>
          <select v-model="form.role_id" required
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option disabled value="">Selecciona un rol</option>
            <option v-for="rol in roles" :key="rol.id" :value="rol.id">{{ rol.name }}</option>
          </select>
        </div>

        <div v-if="!isEditing">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
          <input v-model="form.password" type="password" required
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div class="flex justify-end gap-4 pt-6">
          <button type="button" @click="close"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-semibold">
            Cancelar
          </button>
          <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">
            {{ isEditing ? 'Actualizar' : 'Guardar' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import api from '@/services/api'

const props = defineProps(['show', 'userToEdit'])
const emit = defineEmits(['close', 'saved'])

const form = ref({
  id: null,
  name: '',
  email: '',
  password: '',
  role_id: ''
})

const isEditing = ref(false)
const roles = ref([])

const fetchRoles = async () => {
  try {
    const res = await api.get('/roles')
    roles.value = res.data
  } catch (error) {
    console.error('Error cargando roles:', error)
  }
}

watch(() => props.show, (visible) => {
  if (visible && props.userToEdit) {
    form.value = {
      id: props.userToEdit.id,
      name: props.userToEdit.name,
      email: props.userToEdit.email,
      password: '',
      role_id: props.userToEdit.role_id ?? props.userToEdit.role?.id ?? ''
    }
    isEditing.value = true
  } else if (visible && !props.userToEdit) {
    resetForm()
  }
})

const handleSubmit = async () => {
  try {
    const payload = {
      name: form.value.name,
      email: form.value.email,
      password: form.value.password || undefined, // evitar enviar string vacío
      role_id: form.value.role_id
    }

    if (isEditing.value) {
      await api.put(`/users/${form.value.id}`, payload)
    } else {
      await api.post('/users', payload)
    }

    emit('saved')
    close()
  } catch (error) {
    console.error('Error guardando usuario:', error.response?.data ?? error)
  }
}

const resetForm = () => {
  form.value = {
    id: null,
    name: '',
    email: '',
    password: '',
    role_id: ''
  }
  isEditing.value = false
}

const close = () => {
  resetForm()
  emit('close')
}

onMounted(fetchRoles)
</script>
