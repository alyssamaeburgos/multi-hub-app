<template>
    <div class="bg-gray-50 p-4 rounded-lg">
        <div class="flex justify-between items-start">
            <div>
                <!-- <p class="font-medium">{{ comment.user.name }}</p> -->
                 <p class="font-medium">{{ fullName }}</p>
                <p class="text-gray-500 text-sm">
                    {{ formatDate(comment.created_at) }}
                </p>
            </div>
            <button
                v-if="isOwner"
                @click="handleDelete"
                class="text-red-500 hover:text-red-700"
            >
                Delete
            </button>
        </div>
        <p class="mt-2">{{ comment.content }}</p>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    comment: {
        type: Object,
        required: true,
    },
    isOwner: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["comment-deleted"]);

const fullName = computed(() => {
    if (!props.comment.user) return "Unknown author";
    return [props.comment.user.first_name, props.comment.user.last_name]
        .filter(Boolean)
        .join(" ");
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const handleDelete = async () => {
    try {
        await axios.delete(`/api/comments/${props.comment.id}`);
        emit("comment-deleted", props.comment.id);
    } catch (error) {
        console.error("Error deleting comment:", error);
    }
};
</script>
