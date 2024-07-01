<template>
    <AppLayout title="Create">
        <Container>
            <Heading :title="'Create a Post'"/>

            <form @submit.prevent="createPost" class="mt-6">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput id="title" class="w-full rounded" v-model="form.title" placeholder="Give it a great title..." />
                    <InputError :message="form.errors.title" class="mt-2"/>
                </div>

                <div class="mt-2">
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <MarkdownEditor v-model="form.body" editorClass="min-h-[370px]" placeholder="Write something amazing..." />
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
import TextArea from "@/Components/TextArea.vue";
import TextInput from "@/Components/TextInput.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";

const form = useForm({
    title: '',
    body: '',
});


const createPost = () => form.post(route('posts.store'));
</script>
