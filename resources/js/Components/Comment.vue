<template>
<div class="sm:flex">
    <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
        <img :src="comment.user.profile_photo_url" class="h-12 w-12 rounded-full" />
    </div>

    <div class="flex-1">
        <div class="mt-1 prose prose-sm max-w-none" v-html="comment.html"></div>
        <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">
            By {{ comment.user.name }} {{ relativeDate(comment.created_at)}} |
            <span class="text-pink-500 font-bold">{{ comment.likes_count }} likes</span>
        </span>

        <div class="mt-2 flex justify-end space-x-3 empty:hidden">
            <div v-if="$page.props.auth.user">
                <Link v-if="comment.can.like" preserve-scroll :href="route('likes.store', ['comment', comment.id])" method="post" class="inline-block text-gray-700 hover:text-pink-500 transition-colors mt-2">
                    <HandThumbUpIcon class="size-4 inline-block mr-1"/>
                    <span class="sr-only">Like Comment</span>
                </Link>

                <Link v-else preserve-scroll :href="route('likes.destroy', ['comment', comment.id])" method="delete" class="inline-block text-gray-700 hover:text-pink-500 transition-colors mt-2">
                    <HandThumbDownIcon class="size-4 inline-block mr-1"/>
                    <span class="sr-only">Unlike Comment</span>
                </Link>
            </div>

            <form v-if="comment.can?.update" @submit.prevent="$emit('edit', comment.id)">
                <button class="p-2 rounded font-mono text-green-700 text-s hover:font-semibold hover:text-white hover:bg-red-700 hover:transition-all">Edit</button>
            </form>
            <form v-if="comment.can?.delete" @submit.prevent="$emit('delete', comment.id)">
                <button class="p-2 rounded font-mono text-red-700 text-s hover:font-semibold hover:text-white hover:bg-red-700 hover:transition-all">Delete</button>
            </form>
        </div>
    </div>
</div>
</template>

<script setup>

import {relativeDate} from "@/Utilities/date.js";
import {HandThumbDownIcon, HandThumbUpIcon} from "@heroicons/vue/20/solid/index.js";
import {Link} from "@inertiajs/vue3";

const props = defineProps(['comment']);

const emit = defineEmits(['edit','delete']);

</script>

