<template>
    <AppLayout :title="post.title">
        <Container>
            <Heading :title="post.title"/>
            <span class="block mt-1 text-sm text-gray-600">{{ formattedDate }} by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>

            <div class="mt-12">
                <h1 class="text-xl font-semibold">Comments</h1>
                <form v-if="$page.props.auth.user" @submit.prevent="addComment" class="mt-4">
                    <div>
                        <InputLabel for="body" class="sr-only">Comment</InputLabel>
                        <TextArea id="body" v-model="commentForm.body" rows="4" placeholder="Speak your mind Spock..."/>
                        <InputError :message="commentForm.errors.body" class="mt-2"/>
                    </div>

                    <PrimaryButton type="submit" class="mt-3" :disabled="commentForm.processing">Add Comment</PrimaryButton>
                </form>

                <div class="mt-8" v-if="comments.data.length">
                    <ul class="divide-y mt-4">
                        <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                            <Comment :comment="comment" />
                        </li>
                    </ul>

                    <Pagination :meta="comments.meta" :only="['comments']" />
                </div>
                <div v-else>
                    <p class="mt-4">No comments yet. Be the first to comment!</p>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed} from "vue";
import Container from "@/Components/Container.vue";
import Heading from "@/Components/Heading.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps(['post','comments']);

const formattedDate = computed(()=> relativeDate(props.post.created_at));

const commentForm = useForm({
    body: ''
});
const addComment = () => commentForm.post(route('posts.comments.store', props.post.id),{
    preserveScroll: true,
    onSuccess: ()=> commentForm.reset()
});
</script>
