<template>
  <div v-if="show" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md backdrop-saturate-150 flex items-center justify-center px-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 w-full max-w-lg">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
        📩 Contactar con <span>{{ cliente?.user?.name || 'Cliente' }}</span>
      </h2>

      <form @submit.prevent="enviarMensaje" class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input
            type="email"
            :value="cliente?.user?.email || ''"
            disabled
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed"
          />
        </div>

        <!-- Teléfono -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
          <input
            type="text"
            :value="cliente?.user?.telefono || '—'"
            disabled
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white cursor-not-allowed"
          />
        </div>

        <!-- Mensaje -->
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

const emit = defineEmits(['close', 'respondido'])

const mensaje = ref('')

watch(() => props.show, (nuevoValor) => {
  if (nuevoValor) {
    mensaje.value = ''
  }
})

const enviarMensaje = async () => {
  const id = props.cliente?.id
  const nombre = props.cliente?.user?.name
  const email = props.cliente?.user?.email

  if (!id || !mensaje.value) return

  try {
    // 1. Enviar el mensaje
    await api.post(`/budgets/${id}/reply`, {
      mensaje: mensaje.value
    })

    // 2. Marcar como respondido
    await api.put(`/budgets/${id}`, {
      estado: 'respondido'
    })

    // 3. Emitir eventos
    emit('respondido', id)
    emit('close')

    alert(`Mensaje enviado a ${nombre} (${email})`)
  } catch (error) {
    console.error('Error al enviar mensaje:', error)
    alert('Error al enviar el mensaje.')
  }
}
</script>
