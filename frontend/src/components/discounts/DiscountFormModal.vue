<template>
  <div v-if="show" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md flex items-center justify-center px-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 w-full max-w-lg overflow-y-auto max-h-[95vh]">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
        {{ isEditing ? '✏️ Editar Descuento' : '➕ Crear Descuento' }}
      </h2>

      <form @submit.prevent="guardar" class="space-y-5">
        <!-- Código -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
          <input
            v-model="form.codigo"
            type="text"
            required
            class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          />
        </div>

        <!-- Descripción -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
          <input
            v-model="form.descripcion"
            type="text"
            class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          />
        </div>

        <!-- Tipo -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
          <select
            v-model="form.tipo"
            required
            class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          >
            <option value="porcentaje">Porcentaje</option>
            <option value="fijo">Fijo</option>
          </select>
        </div>

        <!-- Valor -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor</label>
          <input
            v-model="form.valor"
            type="number"
            step="0.01"
            min="0"
            required
            class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          />
        </div>

        <!-- Fechas -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Inicio</label>
            <input
              v-model="form.inicio"
              type="date"
              required
              class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fin</label>
            <input
              v-model="form.fin"
              type="date"
              required
              class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
            />
          </div>
        </div>

        <!-- Productos -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Productos</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-40 overflow-y-auto border rounded p-2 bg-white dark:bg-gray-700">
            <label
              v-for="p in productos"
              :key="p.id"
              class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-200"
            >
              <input
                type="checkbox"
                :value="p.id"
                v-model="form.product_ids"
                class="accent-blue-600"
              />
              <span>{{ p.nombre }}</span>
            </label>
          </div>
        </div>

        <!-- Activo -->
        <div class="flex items-center">
          <input v-model="form.activo" type="checkbox" id="activo" class="mr-2" />
          <label for="activo" class="text-sm text-gray-700 dark:text-gray-300">¿Activo?</label>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-4">
          <button
            type="button"
            @click="$emit('close')"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold"
          >
            {{ isEditing ? 'Guardar cambios' : 'Crear' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue'
import api from '@/services/api'

const props = defineProps({
  show: Boolean,
  discount: Object
})

const emit = defineEmits(['close', 'refresh', 'saved'])

const isEditing = computed(() => !!props.discount)

const productos = ref([])

const form = ref({
  codigo: '',
  descripcion: '',
  tipo: 'porcentaje',
  valor: 0,
  inicio: '',
  fin: '',
  activo: true,
  product_ids: []
})

const resetForm = () => {
  form.value = {
    codigo: '',
    descripcion: '',
    tipo: 'porcentaje',
    valor: 0,
    inicio: '',
    fin: '',
    activo: true,
    product_ids: []
  }
}

const cargarProductos = async () => {
  try {
    const res = await api.get('/products')
    productos.value = res.data
  } catch (error) {
    console.error('Error al cargar productos:', error)
  }
}

watch(() => props.discount, (nuevo) => {
  if (nuevo) {
    form.value = {
      codigo: nuevo.codigo || '',
      descripcion: nuevo.descripcion || '',
      tipo: nuevo.tipo || 'porcentaje',
      valor: nuevo.valor || 0,
      inicio: nuevo.inicio?.substring(0, 10) || '',
      fin: nuevo.fin?.substring(0, 10) || '',
      activo: nuevo.activo ?? true,
      product_ids: nuevo.products?.map(p => p.id) || []
    }
  } else {
    resetForm()
  }
}, { immediate: true })

const guardar = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/discounts/${props.discount.id}`, form.value)
    } else {
      await api.post('/discounts', form.value)
    }
    emit('saved')
    emit('close')
  } catch (error) {
    console.error('Error al guardar descuento:', error)
    alert('Hubo un error al guardar el descuento.')
  }
}

onMounted(cargarProductos)
</script>
