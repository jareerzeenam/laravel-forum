<template>
<div class="sm:flex">
    <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
        <img :src="comment.user.profile_photo_url" class="h-12 w-12 rounded-full" />
    </div>

    <div class="flex-1">
        <p class="mt-1 break-all">{{ comment.body }}</p>
        <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">By {{ comment.user.name }} {{ relativeDate(comment.created_at)}}</span>
        <div class="mt-2 text-right empty:hidden">
            <form v-if="comment.can?.delete" @submit.prevent="$emit('delete', comment.id)">
                <button class=" p-2 rounded font-mono text-red-700 text-s hover:font-semibold hover:text-white hover:bg-red-700 hover:transition-all">Delete</button>
            </form>
        </div>
    </div>
</div>
</template>

<script setup>

import {relativeDate} from "@/Utilities/date.js";

const props = defineProps(['comment']);

const emit = defineEmits(['delete']);

</script>

