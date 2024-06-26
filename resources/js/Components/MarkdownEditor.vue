<template>
    <div>
        <EditorContent :editor="editor" />
    </div>
</template>

<script setup>
import {EditorContent, useEditor} from "@tiptap/vue-3";
import {StarterKit} from "@tiptap/starter-kit";

const props = defineProps({
    modelValue:'',
});

const editor = useEditor({
    extensions: [
        StarterKit,
    ],
});
</script>
