<template>

    <Head>
        <link :href="post.routes.show" rel="canonical"/>
    </Head>

    <AppLayout :title="post.title">
        <Container>
            <div class="grid grid-cols-2">
                <div class="w-full">
                    <PageHeading class="mb-4">{{ post.title }}</PageHeading>
                </div>
                <div class="w-full">
                    <Link v-if="post.can.update" :href="route('posts.edit', post.id)"
                          class="flex items-center justify-end">
                    <span class="bg-green-700 hover:bg-green-800 rounded text-white px-5 py-1">
                        Edit Post
                    </span>
                    </Link>
                </div>
            </div>
            <Pill :href="route('posts.index',{ topic: post.topic.slug })" class="mb-4 mt-2">{{ post.topic.name }}</Pill>
            <span class="block mt-1 text-sm text-gray-600">{{ formattedDate }} by {{ post.user.name }}</span>

            <div class="mt-4">
                <span class="text-pink-500 font-bold">{{ post.likes_count }} likes </span>

                <div v-if="$page.props.auth.user" class="mt-2">
                    <Link v-if="post.can.like" :href="route('likes.store', ['post', post.id])"
                          class="inline-block bg-indigo-600 hover:bg-pink-500 transition-colors text-white py-1.5 px-3 rounded-full"
                          method="post">
                        <HandThumbUpIcon class="size-4 inline-block mr-1"/>
                        Like Post
                    </Link>

                    <Link v-else :href="route('likes.destroy', ['post', post.id])"
                          class="inline-block bg-indigo-600 hover:bg-pink-500 transition-colors text-white py-1.5 px-3 rounded-full"
                          method="delete">
                        <HandThumbDownIcon class="size-4 inline-block mr-1"/>
                        Unlike Post
                    </Link>
                </div>
            </div>

            <article class="mt-6 prose prose-sm max-w-none" v-html="post.html"></article>

            <div class="mt-12">
                <h1 class="text-xl font-semibold">Comments</h1>
                <form v-if="$page.props.auth.user"
                      class="mt-4" @submit.prevent="() => commentIdBeingEdited ? updateComment() : addComment()">
                    <div>
                        <InputLabel class="sr-only" for="body">Comment</InputLabel>
                        <MarkdownEditor id="body" ref="commentTextAreaRef" v-model="commentForm.body"
                                        editorClass="!min-h-[140px]" placeholder="Speak your mind Spock..."/>
                        <InputError :message="commentForm.errors.body" class="mt-2"/>
                    </div>

                    <PrimaryButton :disabled="commentForm.processing" class="mt-3" type="submit"
                                   v-text="commentIdBeingEdited ? 'Update Comment':'Add Comment'"></PrimaryButton>
                    <SecondaryButton v-if="commentIdBeingEdited" class="ml-2" @click="cancelEditComment">Cancel
                    </SecondaryButton>
                </form>

                <div v-if="comments.data.length" class="mt-8">
                    <ul class="divide-y mt-4">
                        <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                            <Comment :comment="comment" @delete="deleteComment" @edit="editComment"/>
                        </li>
                    </ul>

                    <Pagination :meta="comments.meta" :only="['comments']"/>
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
import {computed, ref} from "vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router, useForm, Head, Link} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useConfirm} from "@/Utilities/Composables/useConfirm.js";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import Pill from "@/Components/Pill.vue";
import PageHeading from "@/Components/PageHeading.vue";
import {HandThumbUpIcon, HandThumbDownIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps(['post', 'comments']);

const formattedDate = computed(() => relativeDate(props.post.created_at));

const commentForm = useForm({
    body: ''
});

const commentTextAreaRef = ref(null);
const commentIdBeingEdited = ref(null);
const commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));
const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdited.value?.body;
    commentTextAreaRef.value?.focus();
};

const cancelEditComment = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
};
const addComment = () => commentForm.post(route('posts.comments.store', props.post.id), {
    preserveScroll: true,
    onSuccess: () => commentForm.reset()
});

const {confirmation} = useConfirm();

const updateComment = async () => {

    if (!await confirmation('Are you sure you want to update this comment?')) {
        commentTextAreaRef.value?.focus();
        return;
    }


    commentForm.put(route('comments.update', {
        comment: commentIdBeingEdited.value,
        page: props.comments.meta.current_page
    }), {
        preserveScroll: true,
        onSuccess: cancelEditComment
    });
};

const deleteComment = async (commentId) => {

    if (!await confirmation('Are you sure you want to delete this comment?')) {
        return;
    }

    router.delete(route('comments.destroy', {
            comment: commentId,
            page: props.comments.data.length > 1
                ? props.comments.meta.current_page
                : Math.max(props.comments.meta.current_page - 1, 1)
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                // Do something after the comment is deleted
            }
        });
}
</script>
