<template>
    <section class="py-12  bg-gray-50 dark:bg-gray-900 min-h-screen">
      <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold   mb-10 text-center">
          🛠️ Panel de Administración
        </h1>
  
        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3">
          <div
            v-for="panel in adminPanels"
            :key="panel.nombre"
            class=" dark:bg-gray-800 -2xl -md  transition  cursor-pointer text-center"
            @click="router.push(panel.ruta)"
          >
            <div class="text-5xl mb-4 text-blue-600 dark:text-blue-400">
              {{ panel.icono }}
            </div>
            <h2 class="text-xl font-bold   mb-2">
              {{ panel.nombre }}
            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-sm">
              {{ panel.descripcion }}
            </p>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  import { useRouter } from 'vue-router'
  const router = useRouter()
  
  const adminPanels = [
    {
      nombre: 'Gestión de productos',
      descripcion: 'Agrega, edita o elimina productos disponibles.',
      ruta: '/admin/products',
      icono: '📦'
    },
    {
      nombre: 'Servicios de reparación',
      descripcion: 'Gestiona los servicios técnicos ofrecidos.',
      ruta: '/admin/repairs',
      icono: '🔧'
    },
    {
      nombre: 'Pedidos',
      descripcion: 'Consulta todos los pedidos realizados.',
      ruta: '/admin/orders',
      icono: '🧾'
    },
    {
      nombre: 'Presupuestos',
      descripcion: 'Revisa las solicitudes de presupuesto enviadas.',
      ruta: '/admin/budgets',
      icono: '📝'
    },
    {
      nombre: 'Garantías',
      descripcion: 'Gestiona y valida garantías activas.',
      ruta: '/admin/guarantees',
      icono: '🛡️'
    },
    {
      nombre: 'Usuarios',
      descripcion: 'Administra las cuentas de los usuarios registrados.',
      ruta: '/admin/users',
      icono: '👥'
    }
  ]
  </script>
  