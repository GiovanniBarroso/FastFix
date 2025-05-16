<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-2xl">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        {{ isEditing ? '✏️ Editar Producto' : '➕ Añadir Producto' }}
      </h2>

      <form @submit.prevent="handleSubmit" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
          <input v-model="form.name" type="text" required
                 class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
          <textarea v-model="form.description" rows="3"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio (€)</label>
            <input v-model="form.price" type="number" step="0.01" required
                   class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
            <input v-model="form.stock" type="number" required
                   class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagen (URL)</label>
          <input v-model="form.image" type="text"
                 class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoría ID</label>
            <input v-model="form.categories_id" type="number" required
                   class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca ID</label>
            <input v-model="form.brands_id" type="number" required
                   class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
          </div>
        </div>

        <div class="flex items-center gap-2 mt-2">
          <input v-model="form.activo" type="checkbox" class="form-checkbox text-green-600" />
          <label class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
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
import { ref, watch } from 'vue'
import api from '@/services/api'

const props = defineProps(['show', 'productToEdit'])
const emit = defineEmits(['close', 'saved'])

const form = ref({
  id: null,
  name: '',
  description: '',
  price: 0,
  stock: 0,
  image: '',
  categories_id: null,
  brands_id: null,
  activo: true,
})

const isEditing = ref(false)

watch(
  () => props.show,
  (visible) => {
    if (visible && props.productToEdit) {
      form.value = {
        id: props.productToEdit.id,
        name: props.productToEdit.name,
        description: props.productToEdit.description,
        price: props.productToEdit.price,
        stock: props.productToEdit.stock,
        image: props.productToEdit.image,
        categories_id: props.productToEdit.categories_id,
        brands_id: props.productToEdit.brands_id,
        activo: props.productToEdit.activo,
      }
      isEditing.value = true
    } else if (visible && !props.productToEdit) {
      resetForm()
    }
  }
)

const handleSubmit = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/products/${form.value.id}`, form.value)
    } else {
      await api.post('/products', form.value)
    }
    emit('saved')
    close()
  } catch (error) {
    console.error('Error guardando producto:', error)
  }
}

const resetForm = () => {
  form.value = {
    id: null,
    name: '',
    description: '',
    price: 0,
    stock: 0,
    image: '',
    categories_id: null,
    brands_id: null,
    activo: true,
  }
  isEditing.value = false
}

const close = () => {
  resetForm()
  emit('close')
}
</script>
