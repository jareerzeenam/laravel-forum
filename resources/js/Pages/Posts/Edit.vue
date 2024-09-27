<template>
    <AppLayout title="Edit">
        <Container>
            <PageHeading>Edit a Post</PageHeading>
            <form class="mt-6" @submit.prevent="editPost">
                <div>
                    <InputLabel class="sr-only" for="title">Title</InputLabel>
                    <TextInput id="title" v-model="form.title" class="w-full rounded"
                               placeholder="Give it a great title..."/>
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div class="mt-3">
                    <InputLabel for="topic_id">Select a Topic</InputLabel>
                    <select id="topic_id" v-model="form.topic_id"
                            class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option v-for="topic in topics" :key="topic.id" :value="topic.id">
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.topic_id" class="mt-2"/>
                </div>

                <div class="mt-2">
                    <InputLabel class="sr-only" for="body">Body</InputLabel>
                    <MarkdownEditor v-model="form.body"
                                    editorClass="min-h-[370px]" placeholder="Write something amazing...">
                        <template #toolbar="{editor}">
                            <li v-if="! isInProduction()">
                                <button class="px-3 py-2"
                                        title="Autofill"
                                        type="button"
                                        @click="autofill">
                                    <i class="ri-archive-line"></i>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor>
                    <InputError :message="form.errors.body" class="mt-2"/>
                </div>

                <div class="mt-3">
                    <PrimaryButton :disabled="form.processing" class="mt-3" type="submit"
                                   v-text="'Update Post'"></PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>

import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Container from "@/Components/Container.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import {isInProduction} from "@/Utilities/environment.js";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps(['topics', 'post']);

const form = useForm({
    title: props.post.title || '',
    topic_id: props.post.topic.id || props.topics[0].id,
    body: props.post.body || '',
});

const editPost = () => form.put(route('posts.update', props.post.id));

const autofill = async () => {

    if (isInProduction()) {
        return;
    }

    const response = await axios.get('/local/post-content');

    form.title = response.data.title;
    form.body = response.data.body;
};
</script>
