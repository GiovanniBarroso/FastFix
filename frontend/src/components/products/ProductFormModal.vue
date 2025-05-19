<template>
  <div v-if="show" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md backdrop-saturate-150 flex items-center justify-center px-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-2xl overflow-y-auto max-h-[90vh]">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        {{ isEditing ? '✏️ Editar Producto' : '➕ Añadir Producto' }}
      </h2>

      <form @submit.prevent="handleSubmit" class="space-y-5">
        <!-- Nombre -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
          <input v-model="form.name" type="text" required
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <!-- Descripción -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
          <textarea v-model="form.description" rows="3"
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
        </div>

        <!-- Precio y stock -->
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

        <!-- Imagen -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagen</label>
          <input type="file" accept="image/*" @change="handleFileUpload"
            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

          <div v-if="previewUrl" class="mt-3">
            <a :href="previewUrl" target="_blank">
              <img :src="previewUrl" alt="Vista previa"
                class="w-32 h-32 object-cover rounded border hover:scale-105 transition" />
            </a>
          </div>
        </div>


        <!-- Categoría y Marca -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoría</label>
            <select v-model="form.category_id" required
              class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
              <option disabled value="">Selecciona categoría</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca</label>
            <select v-model="form.brand_id" required
              class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
              <option disabled value="">Selecciona marca</option>
              <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
            </select>
          </div>
        </div>

        <!-- Activo -->
        <div class="flex items-center gap-2 mt-2">
          <input v-model="form.activo" type="checkbox" class="form-checkbox text-green-600" />
          <label class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-6">
          <button type="button" @click="close"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-semibold">
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

const baseURL = 'http://localhost:8000'

const getImageUrl = (filename) => {
  if (!filename) return `${baseURL}/images/default.jpg`
  return filename.startsWith('http') ? filename : `${baseURL}/images/${filename}`
}

const props = defineProps(['show', 'productToEdit'])
const emit = defineEmits(['close', 'saved'])

const form = ref({
  id: null,
  name: '',
  description: '',
  price: 0,
  stock: 0,
  category_id: '',
  brand_id: '',
  activo: true,
})

const imageFile = ref(null)
const previewUrl = ref(null)
const isEditing = ref(false)
const categories = ref([])
const brands = ref([])

const fetchCategoriesAndBrands = async () => {
  try {
    const [catRes, brandRes] = await Promise.all([
      api.get('/categories'),
      api.get('/brands'),
    ])
    categories.value = catRes.data
    brands.value = brandRes.data
  } catch (error) {
    console.error('Error cargando categorías o marcas:', error)
  }
}

const handleFileUpload = (e) => {
  const file = e.target.files[0]
  if (file) {
    imageFile.value = file
    previewUrl.value = URL.createObjectURL(file)
  }
}

const handleSubmit = async () => {
  try {
    const data = new FormData()
    data.append('name', form.value.name)
    data.append('description', form.value.description)
    data.append('price', form.value.price)
    data.append('stock', form.value.stock)
    data.append('category_id', form.value.category_id)
    data.append('brand_id', form.value.brand_id)
    data.append('activo', form.value.activo ? 1 : 0)

    if (imageFile.value) {
      data.append('image', imageFile.value)
    }

    const config = { headers: { 'Content-Type': 'multipart/form-data' } }

    if (isEditing.value) {
      data.append('_method', 'PUT')
      await api.post(`/products/${form.value.id}`, data, config)
    } else {
      await api.post('/products', data, config)
    }

    emit('saved')
    close()
  } catch (error) {
    console.error('Error guardando producto:', error.response?.data ?? error)
  }
}

const resetForm = () => {
  form.value = {
    id: null,
    name: '',
    description: '',
    price: 0,
    stock: 0,
    category_id: '',
    brand_id: '',
    activo: true,
  }
  imageFile.value = null
  previewUrl.value = null
  isEditing.value = false
}

const close = () => {
  resetForm()
  emit('close')
}

watch(() => props.show, (visible) => {
  if (visible && props.productToEdit) {
    form.value = {
      id: props.productToEdit.id,
      name: props.productToEdit.name,
      description: props.productToEdit.description,
      price: props.productToEdit.price,
      stock: props.productToEdit.stock,
      category_id: props.productToEdit.category_id,
      brand_id: props.productToEdit.brand_id,
      activo: props.productToEdit.activo,
    }

    // ✅ Usar getImageUrl para la vista previa de la imagen
    previewUrl.value = props.productToEdit.image
      ? getImageUrl(props.productToEdit.image)
      : null

    imageFile.value = null
    isEditing.value = true
  } else if (visible) {
    resetForm()
  }
})

onMounted(fetchCategoriesAndBrands)
</script>
