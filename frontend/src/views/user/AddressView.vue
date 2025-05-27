<template>
  <section class="py-20 bg-gradient-to-b from-white to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
      <!-- Botón volver -->
      <div class="mb-6">
        <BackButtonUser />
      </div>

      <!-- Encabezado -->
      <div class="text-center mb-10">
        <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
          📍 Tus direcciones
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">
          Gestiona tus direcciones de envío y facturación asociadas a tu cuenta.
        </p>
      </div>

      <!-- Botón añadir centrado -->
      <div class="flex justify-center mb-12">
        <button @click="showModal = true"
          class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200">
          ➕ Añadir nueva dirección
        </button>
      </div>

      <!-- Lista de direcciones -->
      <div v-if="addresses.length" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="address in addresses" :key="address.id"
          class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-xl transition hover:-translate-y-1">
          <div class="flex items-center gap-3 mb-4">
            <div class="text-4xl">🏠</div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
              {{ address.nombre }}
            </h2>
          </div>
          <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1 pl-1">
            <li>{{ address.direccion }}</li>
            <li>{{ address.codigo_postal }} – {{ address.ciudad }}</li>
            <li>{{ address.provincia }}, {{ address.pais }}</li>
            <li>📞 {{ address.telefono_envio }}</li>
          </ul>
        </div>
      </div>

      <!-- Sin direcciones -->
      <div v-else class="flex flex-col items-center text-center text-gray-600 dark:text-gray-400 mt-20">
        <img src="/images/empty-address.png" alt="Sin direcciones" class="w-40 h-40 mb-6 opacity-70" />
        <p class="text-xl font-semibold mb-2">Aún no tienes direcciones registradas</p>
        <p class="text-sm mb-4">Puedes añadir una dirección al realizar tu primer pedido.</p>
        <router-link to="/products"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-xl shadow">
          Ir a la tienda
        </router-link>
      </div>

      <!-- Modal -->
      <NewAddressModal :visible="showModal" @close="showModal = false" @refresh="fetchAddresses" />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BackButtonUser from '@/components/ui/BackButtonUser.vue'
import NewAddressModal from '@/components/modals/NewAddressModal.vue'

const addresses = ref([])
const showModal = ref(false)

const fetchAddresses = async () => {
  try {
    const { data } = await api.get('/user/addresses')
    addresses.value = data.addresses
  } catch (err) {
    console.error('❌ Error al cargar direcciones:', err)
  }
}

onMounted(fetchAddresses)
</script>
