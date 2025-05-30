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
            />
        </div>

        <!-- Comment form for logged in users -->
        <CommentForm
            v-if="isLoggedIn"
            :blog-id="blogId"
            @comment-added="handleCommentAdded"
        />

        <p v-else class="text-gray-500">No comments yet.</p>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
// import { useAuthStore } from "@/stores/auth";
import { usePage } from "@inertiajs/vue3";

// COMPONENTS
import CommentForm from "@/Components/Blog/CommentForm.vue";
import CommentItem from "@/Components/Blog/CommentItem.vue";

const props = defineProps({
    blogId: {
        type: [String, Number],
        required: true,
    },
});

// const authStore = useAuthStore();

const user = usePage().props.auth.user;
const comments = ref([]);

// const isLoggedIn = computed(() => authStore.isAuthenticated);
const isLoggedIn = ref(true);

const isCommentOwner = (comment) =>
    // isLoggedIn.value && comment.user_id === authStore.user.id;
    isLoggedIn.value && comment.user_id === user.id;

const fetchComments = async () => {
    try {
        const response = await axios.get(`/api/blogs/${props.blogId}/comments`);
        comments.value = response.data;
    } catch (error) {
        console.error("Error fetching comments:", error);
    }
};

const handleCommentAdded = async (newComment) => {
    try {
        await fetchComments();
    } catch (error) {
        // Optional: revert UI if update failed
        comments.value = comments.value.filter((c) => c.id !== newComment.id);
        console.error("Failed to refresh comments:", error);
    }

    comments.value.push(newComment);
};

const handleCommentDeleted = (commentId) => {
    comments.value = comments.value.filter((c) => c.id !== commentId);
};

onMounted(fetchComments);
</script>
