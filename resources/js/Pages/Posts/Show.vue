<template>
    <AppLayout :title="post.title">
        <Container>
            <Heading :title="post.title"/>
            <span class="block mt-1 text-sm text-gray-600">{{ formattedDate }} by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed} from "vue";
import moment from "moment";
import Container from "@/Components/Container.vue";
import Heading from "@/Components/Heading.vue";

const props = defineProps(['post']);

const formattedDate = computed(()=> moment(props.post.created_at).fromNow());
</script>
