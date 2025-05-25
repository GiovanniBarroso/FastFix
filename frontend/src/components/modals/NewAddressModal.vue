<template>
  <transition name="fade">
    <div v-if="visible"
      class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center px-4">
      <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-xl p-6 relative max-h-[90vh] overflow-y-auto">
        <button @click="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl">×</button>
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">➕ Nueva dirección</h2>

        <form @submit.prevent="submitAddress" class="grid grid-cols-1 gap-4 text-left">
          <div>
            <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">Nombre</label>
            <input v-model="form.nombre" class="input" required />
          </div>
          <div>
            <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">Dirección</label>
            <input v-model="form.direccion" class="input" required />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">Código Postal</label>
              <input v-model="form.codigo_postal" class="input" required />
            </div>
            <div>
              <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">Ciudad</label>
              <input v-model="form.ciudad" class="input" required />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">Provincia</label>
              <input v-model="form.provincia" class="input" required />
            </div>
            <div>
              <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">País</label>
              <input v-model="form.pais" class="input" required />
            </div>
          </div>
          <div>
            <label class="text-sm text-gray-700 dark:text-gray-300 block mb-1">Teléfono</label>
            <input v-model="form.telefono_envio" class="input" required />
          </div>

          <label class="inline-flex items-center gap-2 text-sm mt-2 text-gray-800 dark:text-gray-200">
            <input v-model="form.principal" type="checkbox" class="rounded text-blue-600" />
            Establecer como principal
          </label>

          <div class="pt-4 flex justify-end">
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded font-semibold transition">
              Guardar dirección
            </button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, defineEmits, defineProps } from 'vue'
import api from '@/services/api'

const emit = defineEmits(['close', 'refresh'])
const props = defineProps({ visible: Boolean })

const form = ref({
  nombre: '', direccion: '', codigo_postal: '', ciudad: '', provincia: '', pais: '', telefono_envio: '', principal: false
})

const closeModal = () => {
  emit('close')
  resetForm()
}

const resetForm = () => {
  form.value = {
    nombre: '', direccion: '', codigo_postal: '', ciudad: '', provincia: '', pais: '', telefono_envio: '', principal: false
  }
}

const submitAddress = async () => {
  try {
    await api.post('/user/addresses', form.value)
    emit('refresh')
    closeModal()
  } catch (err) {
    console.error('❌ Error al guardar dirección:', err)
  }
}
</script>

<style scoped>
.input {
  @apply w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>