<template>
  <div class="fixed bottom-6 right-6 z-50">

    <!-- Botón para abrir el chat -->
    <button
    v-if="!visible"
    @click="visible = true"
    class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg text-xl cursor-pointer"
    aria-label="Abrir chat"
    >
    🤖
    </button>


    <!-- Chat flotante -->
    <div
      v-if="visible"
      class="w-80 bg-white dark:bg-gray-900 shadow-xl rounded-xl overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700"
    >
      <!-- Cabecera con botón cerrar -->
      <div class="p-4 bg-blue-600 text-white font-semibold text-sm flex justify-between items-center">
        🤖 Pregúntale al sistema
        <button @click="visible = false" class="text-white text-lg cursor-pointer">
            ⬇️
        </button>
      </div>


      <!-- Chat -->
      <div
        ref="chatBox"
        class="flex-1 px-4 py-3 space-y-3 overflow-y-auto text-sm bg-white dark:bg-gray-900"
        style="max-height: 300px;"
      >
        <div
          v-for="(msg, i) in messages"
          :key="i"
          class="animate-chat"
          :class="msg.tipo === 'usuario'
            ? 'self-end bg-blue-600 text-white rounded-tl-2xl rounded-bl-2xl ml-auto'
            : 'self-start bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-tr-2xl rounded-br-2xl mr-auto'"
          style="max-width: 75%; padding: 0.6rem 1rem;"
        >
          {{ msg.texto }}
        </div>
        <div v-if="isTyping" class="text-xs italic text-gray-500 dark:text-gray-400">
          🤖 escribiendo...
        </div>
      </div>

      <!-- Sugerencias -->
      <div class="px-3 py-2 bg-gray-50 dark:bg-gray-800 border-t dark:border-gray-700 flex flex-wrap gap-2 text-xs">
        <button
          v-for="sugerencia in sugerencias"
          :key="sugerencia"
          @click="usarSugerencia(sugerencia)"
          class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition"
        >
          {{ sugerencia }}
        </button>
      </div>

      <!-- Input -->
      <div class="p-3 border-t dark:border-gray-700 bg-white dark:bg-gray-800">
        <input
          v-model="input"
          @keyup.enter="handleQuery"
          placeholder="Ej: Pedidos de hoy"
          class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-sm text-gray-800 dark:text-white"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick, onMounted, watch } from 'vue'
import api from '@/services/api'

const input = ref('')
const messages = ref([])
const isTyping = ref(false)
const visible = ref(true)
const chatBox = ref(null)

const sugerencias = [
  'Pedidos de hoy',
  'Presupuestos pendientes',
  'Usuarios registrados',
  'Ventas de hoy'
]

// Cargar historial si existe
onMounted(() => {
  const guardados = localStorage.getItem('chat_historial_admin')
  if (guardados) messages.value = JSON.parse(guardados)
  scrollToBottom()
})

watch(messages, () => {
  localStorage.setItem('chat_historial_admin', JSON.stringify(messages.value))
})

const scrollToBottom = () => {
  nextTick(() => {
    if (chatBox.value) {
      chatBox.value.scrollTop = chatBox.value.scrollHeight
    }
  })
}

const usarSugerencia = (texto) => {
  input.value = texto
  handleQuery()
}

const handleQuery = async () => {
  const q = input.value.trim()
  if (!q) return

  messages.value.push({ tipo: 'usuario', texto: q })
  input.value = ''
  scrollToBottom()

  isTyping.value = true
  await new Promise(resolve => setTimeout(resolve, 500)) // Simula escribiendo...

  try {
    const query = q.toLowerCase()
    let respuesta = '🤖 No entendí. Prueba con: "Pedidos de hoy", "Presupuestos pendientes", "Usuarios registrados"...'

    if (query.includes('pedido')) {
      const res = await api.get('/admin/stats')
      respuesta = `📦 Hoy se han registrado ${res.data.pedidos} pedidos.`
    } else if (query.includes('presupuesto')) {
      const res = await api.get('/budgets')
      const pendientes = res.data.filter(b => b.estado === 'pendiente').length
      respuesta = `📝 Hay ${pendientes} presupuestos pendientes.`
    } else if (query.includes('usuario')) {
      const res = await api.get('/admin/stats')
      respuesta = `👥 Actualmente hay ${res.data.usuarios} usuarios registrados.`
    } else if (query.includes('venta')) {
      const res = await api.get('/admin/stats')
      const totalVentas = Number(res.data.ventas || 0)
      respuesta = `💰 Las ventas de hoy suman un total de €${totalVentas.toFixed(2)}.`

    }

    isTyping.value = false
    messages.value.push({ tipo: 'sistema', texto: respuesta })
    scrollToBottom()
  } catch (error) {
    console.error(error)
    isTyping.value = false
    messages.value.push({ tipo: 'sistema', texto: '⚠️ Error al procesar la consulta.' })
  }
}
</script>

<style scoped>
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-thumb {
  background: #bbb;
  border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
  background: #999;
}

.animate-chat {
  animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
