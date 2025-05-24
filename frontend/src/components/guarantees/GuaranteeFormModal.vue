<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-xl">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        {{ isEditing ? '✏️ Editar Garantía' : '➕ Añadir Garantía' }}
      </h2>

      <form @submit.prevent="handleSubmit" class="space-y-5">
        <!-- Usuario -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cliente</label>
          <select v-model="form.user_id" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option disabled value="">Selecciona un cliente</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }} ({{ user.email }})
            </option>
          </select>
        </div>

        <!-- Reparación -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reparación</label>
          <select v-model="form.repair_id" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option disabled value="">Selecciona una reparación</option>
            <option v-for="repair in repairs" :key="repair.id" :value="repair.id">
              {{ repair.device_type }} - {{ repair.name }} ({{ repair.user?.name || '—' }})
            </option>
          </select>
        </div>

        <!-- Fechas -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de inicio</label>
            <input v-model="form.fecha_inicio" type="date" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de fin</label>
            <input v-model="form.fecha_fin" type="date" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-6">
          <button type="button" @click="close" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-semibold">
            Cancelar
          </button>
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">
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

const props = defineProps(['show', 'guaranteeToEdit'])
const emit = defineEmits(['close', 'saved'])

const form = ref({
  id: null,
  user_id: '',
  repair_id: '',
  fecha_inicio: '',
  fecha_fin: ''
})

const isEditing = ref(false)
const users = ref([])
const repairs = ref([])

const fetchUsersAndRepairs = async () => {
  try {
    const [usersRes, repairsRes] = await Promise.all([
      api.get('/users'),
      api.get('/repairs')
    ])
    users.value = usersRes.data
    repairs.value = repairsRes.data
  } catch (error) {
    console.error('Error cargando usuarios/reparaciones:', error)
  }
}

watch(() => props.show, (visible) => {
  if (visible && props.guaranteeToEdit) {
    form.value = {
      id: props.guaranteeToEdit.id,
      user_id: props.guaranteeToEdit.user_id,
      repair_id: props.guaranteeToEdit.repair_id,
      fecha_inicio: props.guaranteeToEdit.fecha_inicio,
      fecha_fin: props.guaranteeToEdit.fecha_fin,
    }
    isEditing.value = true
  } else if (visible) {
    resetForm()
  }
})

const handleSubmit = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/guarantees/${form.value.id}`, form.value)
    } else {
      await api.post('/guarantees', form.value)
    }

    emit('saved')
    close()
  } catch (error) {
    console.error('Error guardando garantía:', error.response?.data ?? error)
  }
}

const resetForm = () => {
  form.value = {
    id: null,
    user_id: '',
    repair_id: '',
    fecha_inicio: '',
    fecha_fin: ''
  }
  isEditing.value = false
}

const close = () => {
  resetForm()
  emit('close')
}

onMounted(fetchUsersAndRepairs)
</script>
