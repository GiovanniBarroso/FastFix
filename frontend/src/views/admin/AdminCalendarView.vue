<template>
  <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Botón de volver reutilizable -->
      <div class="mb-6" data-aos="fade-right">
        <BackButtonAdmin />
      </div>

      <h1
        class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-10"
        data-aos="fade-up"
      >
        📅 Agenda de Reparaciones
      </h1>

      <div data-aos="zoom-in">
        <FullCalendar :options="calendarOptions" />
      </div>
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
import BackButtonAdmin from '@/components/ui/BackButtonAdmin.vue'
import tippy from 'tippy.js'
import 'tippy.js/dist/tippy.css'

// ✅ AOS
import AOS from 'aos'
import 'aos/dist/aos.css'

const events = ref([])

const calendarOptions = ref({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay',
  },
  events: events.value,
  eventClick(info) {
    alert(`📌 Reparación: ${info.event.title}\nFecha: ${info.event.startStr}`)
  },
  eventDidMount(info) {
    tippy(info.el, {
      content: info.event.extendedProps.tooltip,
      allowHTML: true,
      placement: 'top',
      theme: 'light-border',
      animation: 'fade',
    })
  },
})

onMounted(async () => {
  // 🔄 Iniciar AOS
  AOS.init({ duration: 800, once: true })

  try {
    const repairsRes = await api.get('/repairs')

    const repairEvents = repairsRes.data.map((r) => ({
      title: `🛠️ Reparación: ${r.device_type}`,
      start: r.received_at,
      end: r.delivered_at,
      className: 'fc-event-repair',
      tooltip: `
        <strong>Cliente:</strong> ${r.user?.nombre || '—'}<br/>
        <strong>Dispositivo:</strong> ${r.nombre}<br/>
        <strong>Problema:</strong> ${r.problem_description}<br/>
        <strong>Estado:</strong> ${r.status}<br/>
        <strong>Fecha de recepción:</strong> ${r.received_at}
      `,
    }))

    events.value = repairEvents
    calendarOptions.value.events = repairEvents
  } catch (error) {
    console.error('Error al cargar reparaciones:', error)
  }
})
</script>

<style>
@import 'aos/dist/aos.css';

/* 🎨 FullCalendar */
.fc {
  background-color: transparent !important;
}
.fc .fc-daygrid-day-number {
  color: #1a1a1a;
  font-weight: 500;
}
.dark .fc .fc-daygrid-day-number {
  color: #f0f0f0 !important;
}
.fc .fc-col-header-cell {
  background-color: transparent;
}
.fc .fc-col-header-cell-cushion {
  color: #1a1a1a;
  font-weight: 600;
}
.dark .fc .fc-col-header-cell-cushion {
  color: #ffffff !important;
}
.fc .fc-toolbar-title {
  color: #1a1a1a;
}
.dark .fc .fc-toolbar-title {
  color: #ffffff !important;
}
.fc .fc-daygrid-day {
  border: 1px solid #ddd;
}
.dark .fc .fc-daygrid-day {
  border: 1px solid #444;
}
.fc-event-repair {
  background-color: #1e90ff !important;
  border: none !important;
  color: white !important;
}
.fc-event-guarantee {
  background-color: #32cd32 !important;
  border: none !important;
  color: white !important;
}
.fc-event-order {
  background-color: #ffa500 !important;
  border: none !important;
  color: white !important;
}
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
.fc-event-time {
  display: none !important;
}
</style>
