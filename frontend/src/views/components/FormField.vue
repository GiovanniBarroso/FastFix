<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="block mb-1 text-sm font-medium text-gray-700">
            {{ label }}
        </label>

        <input :id="id" :type="type" :placeholder="placeholder" :autocomplete="autocomplete" :class="[
            'w-full px-4 py-2 border rounded-md bg-gray-50 text-gray-800 placeholder-gray-400 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white',
            error ? 'border-red-500' : 'border-gray-300'
        ]" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />

        <p v-if="error" class="text-sm text-red-600 mt-1">{{ error }}</p>
    </div>
</template>

<script setup>
defineProps({
    modelValue: String,
    label: String,
    placeholder: String,
    type: {
        type: String,
        default: 'text'
    },
    autocomplete: {
        type: String,
        default: 'off'
    },
    error: String,
    id: {
        type: String,
        default: () => `input-${Math.random().toString(36).substring(2, 10)}`
    }
})

defineEmits(['update:modelValue'])
</script>