<template>
    <div class="bg-gray-50 p-4 rounded-lg">
        <div class="flex justify-between items-start">
            <div>
                <!-- <p class="font-medium">{{ fullName }}</p> -->
                <p class="font-medium">
                    {{ comment.user?.name || "Anonymous" }}
                </p>
                <p class="text-gray-500 text-sm">
                    {{ formatDate(comment.created_at) }}
                    <span v-if="comment.updated_at !== comment.created_at"
                        >(edited)</span
                    >
                </p>
            </div>

            <div v-if="isOwner">
                <button
                    @click="handleEdit"
                    class="text-blue-500 hover:text-blue-700 mr-2"
                >
                    Edit
                </button>
                <button
                    @click="handleDelete"
                    class="text-red-500 hover:text-red-700"
                >
                    Delete
                </button>
            </div>
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

const emit = defineEmits(["comment-deleted", "edit-comment"]);

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

const handleEdit = () => {
    console.log("Edit button clicked", props.comment);
    emit("edit-comment", props.comment);
};

const handleDelete = async () => {
    if (!confirm("Are you sure you want to delete this comment?")) return;

    try {
        await axios.delete(`/api/comments/${props.comment.id}`);
        emit("comment-deleted", props.comment.id);
    } catch (error) {
        console.error("Error deleting comment:", error);
        alert("Failed to delete comment");
    }
};
</script>
