<!-- src/views/DashboardView.vue -->
<template>
  <AppLayout>
    <template #default>
      <h1 class="text-2xl font-bold mb-4">Bienvenido al Dashboard</h1>
      <p><strong>Nombre:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
    </template>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/components/Layout/AppLayout.vue'
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { useRouter } from 'vue-router'

const user = ref({})
const router = useRouter()

onMounted(async () => {
  try {
    const res = await api.get('/me')
    user.value = res.data
  } catch (e) {
    console.error('Error cargando usuario', e)
    localStorage.clear()
    router.push('/login')
  }
})
</script>