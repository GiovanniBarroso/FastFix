<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-2xl">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        {{ isEditing ? '✏️ Editar Reparación' : '➕ Añadir Reparación' }}
      </h2>

      <form @submit.prevent="handleSubmit" class="space-y-5">
        <!-- Usuario -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cliente</label>
          <select v-model="form.user_id" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option disabled value="">Selecciona un cliente</option>
            <option v-for="usuario in users" :key="usuario.id" :value="usuario.id">
              {{ usuario.name }} ({{ usuario.email }})
            </option>
          </select>
        </div>

        <!-- Producto -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producto asociado (opcional)</label>
          <select v-model="form.product_id" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option value="">— Sin producto —</option>
            <option v-for="product in products" :key="product.id" :value="product.id">
              {{ product.name }}
            </option>
          </select>
        </div>

        <!-- Otros campos -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de dispositivo</label>
          <input v-model="form.device_type" type="text" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca</label>
            <input v-model="form.brand" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modelo</label>
            <input v-model="form.model" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción del problema</label>
          <textarea v-model="form.problem_description" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
        </div>

        <!-- Estado -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
          <select v-model="form.status" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option value="pendiente">Pendiente</option>
            <option value="en progreso">En progreso</option>
            <option value="terminado">Terminado</option>
            <option value="entregado">Entregado</option>
          </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Costo de reparación (€)</label>
            <input v-model="form.repair_cost" type="number" step="0.01" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de recepción</label>
            <input v-model="form.received_at" type="date" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de entrega</label>
          <input v-model="form.delivered_at" type="date" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

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
import { ref, onMounted, watch } from 'vue'
import api from '@/services/api'

const props = defineProps(['show', 'repairToEdit'])
const emit = defineEmits(['close', 'saved'])

const form = ref({
  id: null,
  user_id: '',
  product_id: null,
  device_type: '',
  brand: '',
  model: '',
  problem_description: '',
  repair_notes: '',
  status: 'pendiente',
  repair_cost: null,
  received_at: '',
  delivered_at: ''
})

const users = ref([])
const products = ref([])
const isEditing = ref(false)

onMounted(async () => {
  try {
    const [userRes, productRes] = await Promise.all([
      api.get('/users'),
      api.get('/products')
    ])
    users.value = userRes.data
    products.value = productRes.data
  } catch (error) {
    console.error('Error cargando usuarios/productos:', error)
  }
})

watch(
  () => props.show,
  (visible) => {
    if (visible && props.repairToEdit) {
      form.value = { ...props.repairToEdit }
      isEditing.value = true
    } else if (visible && !props.repairToEdit) {
      resetForm()
    }
  }
)

const handleSubmit = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/repairs/${form.value.id}`, form.value)
    } else {
      await api.post('/repairs', form.value)
    }
    emit('saved')
    close()
  } catch (error) {
    if (error.response?.status === 422) {
      console.error('Errores de validación:', error.response.data.errors)
    } else {
      console.error('Error guardando reparación:', error)
    }
  }
}

const resetForm = () => {
  form.value = {
    id: null,
    user_id: '',
    product_id: null,
    device_type: '',
    brand: '',
    model: '',
    problem_description: '',
    repair_notes: '',
    status: 'pendiente',
    repair_cost: null,
    received_at: '',
    delivered_at: ''
  }
  isEditing.value = false
}

const close = () => {
  resetForm()
  emit('close')
}
</script>
