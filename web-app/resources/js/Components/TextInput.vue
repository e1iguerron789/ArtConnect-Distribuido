<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
       class="w-full px-4 py-2 bg-[#FFF8E7] border border-[#D4AF37]/50 text-gray-800 placeholder-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition duration-200"
        v-model="model"
        ref="input"
    />
</template>
