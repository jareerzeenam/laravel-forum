<template>
    <AppLayout>
        <Container>
        <ul class="divide-y">
            <li v-for="post in posts.data" :key="post.id">
                <Link :href="route('posts.show', post.id)" class="block group px-2 py-4">
                    <span class="first-letter:uppercase font-bold text-lg group-hover:text-indigo-600">{{ post.title }}</span>
                    <span class="block pt-1 text-sm text-gray-600">{{ formattedDate(post) }} by {{ post.user.name }}</span>
                </Link>
            </li>
        </ul>

            <Pagination :meta="posts.meta" :only="['posts']" />
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from '@inertiajs/vue3'
import moment from "moment";
import {relativeDate} from "@/Utilities/date.js";

defineProps(['posts']);


const formattedDate = (post) => relativeDate(post.created_at);

</script>
