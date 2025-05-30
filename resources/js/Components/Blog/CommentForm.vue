<template>
    <div class="mb-6">
        <form @submit.prevent="handleSubmit">
            <textarea
                v-model="content"
                placeholder="Write a comment..."
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            ></textarea>
            <div class="mt-2 flex justify-end">
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    Post Comment
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    blogId: {
        type: [String, Number],
        required: true,
    },
});

const emit = defineEmits(["comment-added"]);

const content = ref("");

const handleSubmit = async () => {
    try {
        const response = await axios.post(
            `/api/blogs/${props.blogId}/comments`,
            {
                content: content.value,
            }
        );

        emit("comment-added", response.data);
        content.value = "";
    } catch (error) {
        console.error("Error posting comment:", error);
    }
};
</script>
