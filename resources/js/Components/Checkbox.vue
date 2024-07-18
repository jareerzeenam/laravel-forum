<script setup>

const model = defineModel('checked');

const props = defineProps({
    value: {
        type: String,
        default: null,
    },
});

</script>


<template>
    <input
        v-model="model"
        type="checkbox"
        :value="value"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    >
</template>
