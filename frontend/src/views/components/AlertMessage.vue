<template>
    <div v-if="message" :class="[
        'w-full flex items-start gap-2 p-3 rounded-md border text-sm',
        type === 'success' && 'bg-green-50 text-green-800 border-green-200',
        type === 'error' && 'bg-red-50 text-red-800 border-red-200',
        type === 'warning' && 'bg-yellow-50 text-yellow-800 border-yellow-200',
        type === 'info' && 'bg-blue-50 text-blue-800 border-blue-200'
    ]">
        <!-- Icono -->
        <component :is="icon" class="w-5 h-5 mt-0.5" />

        <!-- Mensaje -->
        <p class="flex-1 leading-snug">{{ message }}</p>
    </div>
</template>

<script setup>
import { h, computed } from 'vue'

const props = defineProps({
    message: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'info' // info, success, error, warning
    }
})

const icon = computed(() => {
    const baseClass = 'fill-current'
    switch (props.type) {
        case 'success':
            return {
                render: () => h('svg', { class: baseClass, xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 20 20', fill: 'currentColor' }, [
                    h('path', { d: 'M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z' })
                ])
            }
        case 'error':
            return {
                render: () => h('svg', { class: baseClass, xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 20 20', fill: 'currentColor' }, [
                    h('path', { fillRule: 'evenodd', d: 'M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4h2v2h-2v-2zm0-8h2v6h-2V6z', clipRule: 'evenodd' })
                ])
            }
        case 'warning':
            return {
                render: () => h('svg', { class: baseClass, xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'currentColor' }, [
                    h('path', { d: 'M1 21h22L12 2 1 21zm12-3h-2v2h2v-2zm0-6h-2v4h2v-4z' })
                ])
            }
        default:
            return {
                render: () => h('svg', { class: baseClass, xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 20 20', fill: 'currentColor' }, [
                    h('path', { d: 'M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-8 4a1 1 0 100-2 1 1 0 000 2zm1-9H9v6h2V5z' })
                ])
            }
    }
})
</script>