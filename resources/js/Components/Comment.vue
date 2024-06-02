<template>
<div class="sm:flex">
    <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
        <img :src="comment.user.profile_photo_url" class="h-12 w-12 rounded-full" />
    </div>

    <div>
        <p class="mt-1">{{ comment.body }}</p>
        <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">By {{ comment.user.name }} {{ relativeDate(comment.created_at)}}</span>
    </div>
</div>
</template>

<script setup>

import {relativeDate} from "@/Utilities/date.js";

defineProps(['comment']);
</script>

