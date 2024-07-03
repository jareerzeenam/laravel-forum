<template>
    <Link
        :href="href"
        class="whitespace-nowrap mb-2 rounded-full py-0.5 px-2 border border-pink-500 text-pink-500 hover:bg-indigo-500 hover:text-white hover:border-none"
        :class="{ 'bg-indigo-500 text-white border-none': filled }"
    >
        <slot></slot>
    </Link>
</template>


<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: {
        type: String,
        required: true
    },
    filled: {
        type: Boolean,
        default: false
    }
});
</script>
