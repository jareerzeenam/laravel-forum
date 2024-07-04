<template>
    <AppLayout title="Create">
        <Container>
            <PageHeading>Create a Post</PageHeading>

            <form @submit.prevent="createPost" class="mt-6">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput id="title" class="w-full rounded" v-model="form.title" placeholder="Give it a great title..." />
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div class="mt-3">
                    <InputLabel for="topic_id">Select a Topic</InputLabel>
                    <select id="topic_id" v-model="form.topic_id" class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option v-for="topic in topics" :key="topic.id" :value="topic.id">
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.topic_id" class="mt-2"/>
                </div>

                <div class="mt-2">
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <MarkdownEditor v-model="form.body" editorClass="min-h-[370px]" placeholder="Write something amazing...">
                        <template #toolbar="{editor}">
                            <li v-if="! isInProduction()">
                                <button @click="autofill"
                                        type="button"
                                        class="px-3 py-2"
                                        title="Autofill">
                                    <i class="ri-archive-line"></i>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor>
                    <InputError :message="form.errors.body" class="mt-2"/>
                </div>

                <div class="mt-3">
                    <PrimaryButton type="submit" class="mt-3" :disabled="form.processing" v-text="'Create Post'"></PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>

import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Heading from "@/Components/Heading.vue";
import Container from "@/Components/Container.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import {isInProduction} from "@/Utilities/environment.js";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps(['topics']);

const form = useForm({
    title: '',
    topic_id: props.topics[0].id,
    body: '',
});

const createPost = () => form.post(route('posts.store'));

const autofill = async () => {

    if (isInProduction()) {
        return;
    }

    const response = await axios.get('/local/post-content');

    form.title = response.data.title;
    form.body = response.data.body;
};
</script>
