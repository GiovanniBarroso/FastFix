<template>
    <button :type="type" :disabled="loading || disabled" :class="[
        'flex items-center justify-center px-4 py-2 rounded-md font-semibold transition duration-300',
        'text-white bg-blue-600 hover:bg-blue-700',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        fullWidth ? 'w-full' : '',
    ]">
        <!-- Spinner -->
        <svg v-if="loading" class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z" />
        </svg>

        <span>
            <slot />
        </span>
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit'
    },
    loading: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    fullWidth: {
        type: Boolean,
        default: true
    }
})
</script>