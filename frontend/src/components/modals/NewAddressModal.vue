<template>
  <transition name="fade">
    <div
      v-if="visible"
      class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center px-4"
    >
      <div
        class="bg-gray-900 text-white rounded-xl shadow-lg w-full max-w-xl p-6 relative max-h-[90vh] overflow-y-auto border border-gray-700"
      >
        <button @click="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl">×</button>
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">➕ <span>Nueva dirección</span></h2>

        <form @submit.prevent="submitAddress" class="grid grid-cols-1 gap-4 text-left">
          <!-- Campo nombre -->
          <div>
            <label class="block text-sm text-gray-300 mb-1">Nombre</label>
            <input v-model="form.nombre" placeholder="Casa principal" class="input-dark" required />
          </div>

          <!-- Calle y número -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm text-gray-300 mb-1">Calle</label>
              <input v-model="form.calle" placeholder="Ejemplo" class="input-dark" required />
            </div>
            <div>
              <label class="block text-sm text-gray-300 mb-1">Número</label>
              <input v-model="form.numero" placeholder="33" class="input-dark" required />
            </div>
          </div>

          <!-- Código postal y ciudad -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm text-gray-300 mb-1">Código Postal</label>
              <input v-model="form.codigo_postal" placeholder="41001" class="input-dark" required />
            </div>
            <div>
              <label class="block text-sm text-gray-300 mb-1">Ciudad</label>
              <input v-model="form.ciudad" placeholder="Sevilla" class="input-dark" required />
            </div>
          </div>

          <!-- Provincia y país -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm text-gray-300 mb-1">Provincia</label>
              <input v-model="form.provincia" placeholder="Andalucía" class="input-dark" required />
            </div>
            <div>
              <label class="block text-sm text-gray-300 mb-1">País</label>
              <input v-model="form.pais" placeholder="España" class="input-dark" required />
            </div>
          </div>

          <!-- Checkbox -->
          <label class="inline-flex items-center gap-2 text-sm text-gray-200 mt-2">
            <input v-model="form.principal" type="checkbox" class="rounded text-blue-600" />
            Establecer como principal
          </label>

          <!-- Botón -->
          <div class="pt-4 flex justify-end">
            <button
              type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded font-semibold transition"
            >
              Guardar dirección
            </button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, defineEmits, defineProps, watch } from 'vue'
import api from '@/services/api'

const emit = defineEmits(['close', 'refresh'])
const props = defineProps({ visible: Boolean })

const form = ref({
  nombre: '',
  calle: '',
  numero: '',
  codigo_postal: '',
  ciudad: '',
  provincia: '',
  pais: '',
  principal: false
})

watch(() => props.visible, (nuevoValor) => {
  if (nuevoValor) resetForm()
})

const closeModal = () => {
  emit('close')
}

const resetForm = () => {
  form.value = {
    nombre: '',
    calle: '',
    numero: '',
    codigo_postal: '',
    ciudad: '',
    provincia: '',
    pais: '',
    principal: false
  }
}

const submitAddress = async () => {
  try {
    await api.post('/addresses', form.value)
    emit('refresh')
    closeModal()
  } catch (error) {
    console.error('❌ Error al guardar la dirección:', error.response?.data || error)
  }
}
</script>

<style scoped>
.input-dark {
  @apply w-full rounded px-3 py-2 text-white bg-gray-800 border border-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150;
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
