<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 w-full max-w-lg">
      <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">📩 Contactar con {{ cliente?.nombre }}</h2>

      <form @submit.prevent="enviarMensaje" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input
            type="email"
            :value="cliente?.email"
            disabled
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensaje</label>
          <textarea
            v-model="mensaje"
            rows="5"
            placeholder="Escribe tu respuesta aquí..."
            required
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          ></textarea>
        </div>

        <div class="flex justify-end gap-4 pt-2">
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
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import api from '@/services/api'

const props = defineProps({
  show: Boolean,
  cliente: Object
})

const emit = defineEmits(['close'])

const mensaje = ref('')

watch(() => props.show, (nuevoValor) => {
  if (nuevoValor) {
    mensaje.value = ''
  }
})

const enviarMensaje = async () => {
  if (!props.cliente?.id || !mensaje.value) return

  try {
    await api.post(`/budgets/${props.cliente.id}/reply`, {
      mensaje: mensaje.value
    })

    alert(`Mensaje enviado a ${props.cliente.nombre} (${props.cliente.email})`)
    emit('close')
  } catch (error) {
    console.error('Error al enviar mensaje:', error)
    alert('Error al enviar el mensaje.')
  }
}
</script>
