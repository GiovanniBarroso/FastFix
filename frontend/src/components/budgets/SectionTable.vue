<template>
  <div class="mb-16" :data-aos="'fade-up'">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
      <span>{{ icon }}</span> {{ title }}
    </h2>

    <div
      v-if="items.length"
      class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
    >
      <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
        <thead
          class="bg-gradient-to-r from-purple-400 to-pink-500 text-white uppercase text-xs tracking-wider"
        >
          <tr>
            <th class="p-4 text-left">#</th>
            <th class="p-4 text-left">Nombre</th>
            <th class="p-4 text-left">Email</th>
            <th v-if="type !== 'respondido'" class="p-4 text-left">Teléfono</th>
            <th class="p-4 text-left">Mensaje</th>
            <th v-if="type === 'respondido'" class="p-4 text-left">Respuesta</th>
            <th v-if="type === 'respondido'" class="p-4 text-left">Presupuesto</th>
            <th v-if="type === 'respondido'" class="p-4 text-left">Respondido</th>
            <th v-if="showActions" class="p-4 text-left">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in items"
            :key="item.id"
            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
          >
            <td class="p-4 font-semibold">{{ index + 1 }}</td>
            <td class="p-4">{{ item.user?.nombre || '—' }}</td>
            <td class="p-4">{{ item.user?.email || '—' }}</td>
            <td v-if="type !== 'respondido'" class="p-4">{{ item.user?.telefono || '—' }}</td>
            <td class="p-4 max-w-sm">
              <div class="truncate bg-gray-100 dark:bg-gray-700 p-2 rounded" :title="item.mensaje">
                {{ item.mensaje }}
              </div>
            </td>
            <td v-if="type === 'respondido'" class="p-4 max-w-sm">
              <div
                class="truncate bg-gray-50 dark:bg-gray-800 p-2 rounded"
                :title="item.respuesta_admin"
              >
                {{ item.respuesta_admin || '—' }}
              </div>
            </td>
            <td
              v-if="type === 'respondido'"
              class="p-4 font-mono text-green-600 dark:text-green-400"
            >
              {{
                item.presupuesto_estimado !== null && item.presupuesto_estimado !== undefined
                  ? `€${Number(item.presupuesto_estimado)}`
                  : '—'
              }}
            </td>
            <td v-if="type === 'respondido'" class="p-4">
              {{ formatFecha(item.fecha_respuesta || item.updated_at) }}
            </td>
            <td v-if="showActions" class="p-4">
              <div class="flex items-center gap-2">
                <button
                  @click="$emit('open-modal', item)"
                  class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  💌 Contactar
                </button>
                <button
                  @click="$emit('rechazar', item.id)"
                  class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-full text-xs font-semibold shadow transition hover:scale-105"
                >
                  ❌ Rechazar
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else class="text-gray-500 dark:text-gray-300 italic mt-4">
      No hay solicitudes {{ title.toLowerCase() }}.
    </div>
  </div>
</template>

<script setup>
defineProps({
  icon: String,
  title: String,
  items: Array,
  type: String,
  showActions: {
    type: Boolean,
    default: false,
  },
})

const formatFecha = (fecha) => {
  if (!fecha) return '—'
  return new Date(fecha).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}
</script>
