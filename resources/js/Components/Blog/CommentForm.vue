<template>
    <div class="mb-6">
        <form @submit.prevent="handleSubmit">
            <!-- Textarea -->
            <textarea
                v-model="content"
                :placeholder="
                    isEditing ? 'Edit your comment...' : 'Write a comment...'
                "
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            ></textarea>

            <div class="mt-2 flex justify-end space-x-2">
                <!-- Cancel button -->
                <button
                    v-if="isEditing"
                    type="button"
                    @click="cancelEdit"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                    :disabled="isSubmitting"
                >
                    <span v-if="isSubmitting">Processing...</span>
                    <span v-else>{{ isEditing ? "Update" : "Post" }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";

const props = defineProps({
    blogId: {
        type: [String, Number],
        required: true,
    },

    commentToEdit: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["comment-added", "comment-updated", "cancel-edit"]);

const content = ref("");
const isSubmitting = ref(false);
const isEditing = computed(() => !!props.commentToEdit);

watch(
    () => props.commentToEdit,
    (newVal) => {
        if (newVal) {
            console.log("Editing comment:", newVal);
            content.value = newVal.content;
        } else {
            console.log("Creating new comment");
            content.value = "";
        }
    },
    { immediate: true }
);

const cancelEdit = () => {
    emit("cancel-edit");
};

const handleSubmit = async () => {
    console.log("Submitting form", { isEditing, content: content.value });
    console.log("Blog ID:", props.blogId);
    if (isSubmitting.value) return;
    isSubmitting.value = true;

    try {
        if (isEditing.value) {
            // Update existing comment
            const response = await axios.put(
                `/api/comments/${props.commentToEdit.id}`,
                {
                    content: content.value,
                }
            );
            emit("comment-updated", response.data);
        } else {
            // Create new comment
            const response = await axios.post(
                `/api/blogs/${props.blogId}/comments`,
                {
                    content: content.value,
                }
            );
            emit("comment-added", response.data);
        }
        content.value = "";
    } catch (error) {
        alert(error.response?.data?.message || "Something went wrong");
    } finally {
        isSubmitting.value = false;
    }
};
</script>
