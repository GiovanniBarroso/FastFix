<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class=" dark:bg-gray-800 -lg -lg p-8 w-full max-w-2xl">
            <h2 class="text-2xl font-bold mb-6  ">
                {{ isEditing ? '✏️ Editar Producto' : '➕ Añadir Producto' }}
            </h2>

            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Nombre</label>
                    <input v-model="form.name" type="text" required class="input" />
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Descripción</label>
                    <textarea v-model="form.description" rows="3" class="input"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Precio (€)</label>
                        <input v-model="form.price" type="number" step="0.01" required class="input" />
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Stock</label>
                        <input v-model="form.stock" type="number" required class="input" />
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Imagen (URL)</label>
                    <input v-model="form.image" type="text" class="input" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Categoría ID</label>
                        <input v-model="form.categories_id" type="number" required class="input" />
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Marca ID</label>
                        <input v-model="form.brands_id" type="number" required class="input" />
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <input v-model="form.activo" type="checkbox" class="form-checkbox" />
                    <label class="text-gray-700 dark:text-gray-300">Activo</label>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" @click="close"
                        class="bg-gray-500 hover:bg-gray-600 text-white   ">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white   ">
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

watch(props.productToEdit, (newProduct) => {
    if (newProduct) {
        form.value = { ...newProduct } // Rellena el formulario con los datos del producto
        isEditing.value = true
    }
})

const handleSubmit = async () => {
    try {
        if (isEditing.value) {
            // Actualización del producto
            await api.put(`/products/${form.value.id}`, form.value)
        } else {
            // Creación del producto
            await api.post('/products', form.value)
        }
        emit('saved') // Emitir para actualizar la lista de productos
        close()
    } catch (error) {
        console.error('Error guardando producto:', error)
    }
}

const close = () => {
    emit('close')
}
</script>

<style scoped>
.input {
    @apply w-full   border    ;
}
</style>