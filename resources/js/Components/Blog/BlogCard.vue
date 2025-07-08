<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-2">{{ blog.title }}</h2>
            <p class="text-gray-600 text-sm mb-4">
                Posted by {{ fullName }} on
                {{ formatDate(blog.created_at) }}
            </p>

            <div class="prose max-w-none mb-4" v-html="renderedContent"></div>

            <!-- Visibility badge -->
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2 mb-2"
            >
                {{ blog.visibility }}
            </span>

            <!-- Actions for owner -->
            <div v-if="isOwner" class="mt-4 flex space-x-2">
                <button
                    @click="emit('edit', blog)"
                    class="text-blue-500 hover:text-blue-700"
                >
                    Edit
                </button>
                <button
                    @click="$emit('delete', blog.id)"
                    class="text-red-500 hover:text-red-700"
                >
                    Delete
                </button>
            </div>

            <!-- Comments section -->
            <div class="mt-6 border-t pt-4">
                <CommentList :blog-id="blog.id" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

// Components
import CommentList from "@/Components/Blog/CommentList.vue";

const props = defineProps({
    blog: {
        type: Object,
        required: true,
    },
    isOwner: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["edit", "delete"]);

// const fullName = computed(() => {
//     if (!props.blog.user) return "Unknown author";
//     return [
//         props.blog.user.first_name,
//         "''",
//         props.blog.user.name,
//         "''",
//         props.blog.user.last_name,
//     ]
//         .filter(Boolean)
//         .join(" ");
// });

const fullName = computed(() => {
    if (!props.blog.user) {
        // If user object is missing but user_id exists
        return props.blog.user_id
            ? `User #${props.blog.user_id}`
            : "Unknown author";
    }

    // Build name parts without the quotes you had before
    const nameParts = [
        props.blog.user.first_name,
        props.blog.user.name, // Not sure why you had quotes around this
        props.blog.user.last_name,
    ].filter(Boolean); // This removes any undefined/null/empty parts

    return nameParts.join(" ") || "Unknown author";
});

const renderedContent = computed(() => {
    return props.blog.content;
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};
</script>
