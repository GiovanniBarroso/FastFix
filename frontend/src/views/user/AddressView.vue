<template>
  <section class="py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
      <!-- Encabezado -->
      <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-2">
          📍 Tus direcciones
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">
          Gestiona tus direcciones de envío y facturación asociadas a tu cuenta.
        </p>
      </div>

      <!-- Botón añadir -->
      <div class="flex justify-center mb-12">
        <button
          @click="openCreateModal"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200"
        >
          <span class="text-xl">➕</span> Añadir dirección
        </button>
      </div>

      <!-- Lista de direcciones -->
      <transition-group name="fade" tag="div" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="address in addresses"
          :key="address.id"
          class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-md hover:shadow-xl transition-transform hover:-translate-y-1 relative"
        >
          <div class="flex items-center gap-3 mb-4">
            <div class="text-3xl">🏠</div>
            <div>
              <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ address.nombre }}</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ address.principal ? 'Principal' : 'Secundaria' }}
              </p>
            </div>
          </div>
          <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
            <li class="truncate">📍 {{ address.direccion }}</li>
            <li>📫 {{ address.codigo_postal }} – {{ address.ciudad }}</li>
            <li>🌍 {{ address.provincia }}, {{ address.pais }}</li>
            <li v-if="address.telefono_envio">📞 {{ address.telefono_envio }}</li>
          </ul>

          <!-- Botón editar -->
          <div class="absolute top-4 right-4 flex gap-2">
            <button
              class="text-sm text-gray-500 hover:text-blue-600 transition"
              title="Editar dirección"
              @click="openEditModal(address)"
            >
              ✏️
            </button>
          </div>
        </div>
      </transition-group>

      <!-- Si no hay direcciones -->
      <div v-if="!addresses.length" class="text-center mt-20">
        <img
          src="/images/empty-address.png"
          alt="Sin direcciones"
          class="w-40 h-40 mx-auto opacity-70 mb-6"
        />
        <p class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
          Aún no tienes direcciones registradas
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
          Puedes añadir una dirección al realizar tu primer pedido.
        </p>
        <router-link
          to="/products"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-xl shadow"
        >
          Ir a la tienda
        </router-link>
      </div>

      <!-- Modal -->
      <NewAddressModal
        :visible="showModal"
        :editing="isEditing"
        :initial-data="addressToEdit"
        @close="showModal = false"
        @refresh="fetchAddresses"
      />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import NewAddressModal from '@/components/modals/NewAddressModal.vue'

const addresses = ref([])
const showModal = ref(false)
const isEditing = ref(false)
const addressToEdit = ref(null)

const fetchAddresses = async () => {
  try {
    const { data } = await api.get('/addresses')
    addresses.value = data
  } catch (err) {
    console.error('❌ Error al cargar direcciones:', err)
    addresses.value = []
  }
}

const openCreateModal = () => {
  isEditing.value = false
  addressToEdit.value = null
  showModal.value = true
}

const openEditModal = (address) => {
  isEditing.value = true
  addressToEdit.value = { ...address }
  showModal.value = true
}

onMounted(fetchAddresses)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
