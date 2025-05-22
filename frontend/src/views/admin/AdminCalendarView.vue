<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-10">
        📅 Agenda de Reparaciones, Garantías y Pedidos
      </h1>

      <FullCalendar :options="calendarOptions" />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import api from '@/services/api'

const events = ref([])

const calendarOptions = ref({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  events: events.value,
  eventClick(info) {
    alert('📌 ' + info.event.title)
  }
})

onMounted(async () => {
  try {
    const [repairsRes, guaranteesRes, ordersRes] = await Promise.all([
      api.get('/repairs'),
      api.get('/guarantees'),
      api.get('/orders')
    ])

    const repairEvents = repairsRes.data.map(r => ({
      title: `🛠️ Reparación: ${r.device_type}`,
      start: r.received_at,
      end: r.delivered_at,
      className: 'fc-event-repair'
    }))

    const guaranteeEvents = guaranteesRes.data.map(g => ({
      title: `🛡️ Garantía: ${g.product_name}`,
      start: g.start_date,
      end: g.end_date,
      className: 'fc-event-guarantee'
    }))

    const orderEvents = ordersRes.data.map(o => ({
      title: `🧾 Pedido: ${o.id}`,
      start: o.order_date,
      className: 'fc-event-order'
    }))

    events.value = [...repairEvents, ...guaranteeEvents, ...orderEvents]
    calendarOptions.value.events = events.value
  } catch (error) {
    console.error('Error al cargar eventos:', error)
  }
})
</script>

<style>
/* 🗓️ FullCalendar modo oscuro y claro */

/* Día (evento) en reparaciones */
.fc-event-repair {
  background-color: #1e90ff !important;
  border: none !important;
  color: white !important;
}

/* Día (evento) en garantías */
.fc-event-guarantee {
  background-color: #32cd32 !important;
  border: none !important;
  color: white !important;
}

/* Día (evento) en pedidos */
.fc-event-order {
  background-color: #ffa500 !important;
  border: none !important;
  color: rgb(255, 255, 255) !important;
}

/* 🧱 Estructura general del calendario */
.fc {
  background-color: transparent !important;
}

/* 📅 Día del mes (numeritos) */
.fc .fc-daygrid-day-number {
  color: #1a1a1a; /* claro por defecto */
}
.dark .fc .fc-daygrid-day-number {
  color: #e0e0e0 !important; /* claro en oscuro */
}

/* 📆 Días de la semana: Sun, Mon, etc. */
.fc .fc-col-header-cell-cushion {
  color: #1a1a1a;
  font-weight: 600;
}
.dark .fc .fc-col-header-cell-cushion {
  color: #f0f0f0 !important;
}

/* 🔲 Borde de celdas del calendario */
.fc .fc-daygrid-day {
  border: 1px solid #ddd;
}
.dark .fc .fc-daygrid-day {
  border: 1px solid #444;
}

/* 🔹 Título del mes (ej: May 2025) */
.fc .fc-toolbar-title {
  color: #1a1a1a;
}
.dark .fc .fc-toolbar-title {
  color: #ffffff !important;
}

/* 🕹️ Botones */
.fc .fc-button {
  background: #2563eb;
  border: none;
  color: white;
}
.fc .fc-button:hover {
  background: #1d4ed8;
}
.fc .fc-button:disabled {
  background: #9ca3af;
}

.dark .fc .fc-button {
  background: #3b82f6;
  color: white;
}
.dark .fc .fc-button:hover {
  background: #2563eb;
}

</style>
