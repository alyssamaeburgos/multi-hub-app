<!-- components/blog/CommentList.vue -->
<template>
    <div>
        <h3 class="text-lg font-medium mb-4">Comments</h3>

        <!-- Comments list -->
        <div v-if="comments.length > 0" class="mt-4 space-y-4 mb-6">
            <CommentItem
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
                :is-owner="isCommentOwner(comment)"
                @comment-deleted="handleCommentDeleted"
                @edit-comment="handleEditComment"
            />
        </div>

        <!-- Edit form when editing a comment -->
        <CommentForm
            v-if="isLoggedIn"
            :blog-id="blogId"
            :comment-to-edit="editingComment"
            @comment-added="handleCommentAdded"
            @comment-updated="handleCommentUpdated"
            @cancel-edit="cancelEdit"
        />

        <p v-else class="text-gray-500">No comments yet.</p>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
// import { axios } from "axios";

// COMPONENTS
import CommentForm from "@/Components/Blog/CommentForm.vue";
import CommentItem from "@/Components/Blog/CommentItem.vue";

const props = defineProps({
    blogId: {
        type: [String, Number],
        required: true,
    },
});

const user = usePage().props.auth.user;
const comments = ref([]);
const editingComment = ref(null);
// const isLoggedIn = ref(true);
const isLoggedIn = computed(() => !!user);

const isCommentOwner = (comment) =>
    isLoggedIn.value && comment.user_id === user.id;

const fetchComments = async () => {
    try {
        const response = await axios.get(`/api/blogs/${props.blogId}/comments`);
        comments.value = response.data;
    } catch (error) {
        console.error("Error fetching comments:", error);
    }
};

// const handleCommentAdded = async (newComment) => {
//     try {
//         await fetchComments();
//     } catch (error) {
//         // Optional: revert UI if update failed
//         comments.value = comments.value.filter((c) => c.id !== newComment.id);
//         console.error("Failed to refresh comments:", error);
//     }

//     comments.value.push(newComment);
// };

const handleCommentAdded = (newComment) => {
    comments.value.unshift(newComment);
};

const handleCommentDeleted = (commentId) => {
    comments.value = comments.value.filter((c) => c.id !== commentId);
};

const handleEditComment = (comment) => {
    console.log("Editing comment received", comment); // Add this
    // editingComment.value = comment;
    editingComment.value = { ...comment };
};

const handleCommentUpdated = (updatedComment) => {
    console.log("Before update", comments.value);
    const index = comments.value.findIndex((c) => c.id === updatedComment.id);
    if (index !== -1) {
        comments.value[index] = updatedComment;
    }
    console.log("After update", comments.value);
    editingComment.value = null;
};

const cancelEdit = () => {
    editingComment.value = null;
};

onMounted(fetchComments);
</script>
