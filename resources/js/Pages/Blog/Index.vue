<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8">Blog Posts</h1>

            <!-- Show create button for logged in users -->
            <button
                v-if="isLoggedIn"
                @click="showForm = true"
                class="mb-6 bg-blue-500 text-white px-4 py-2 rounded"
            >
                Create New Post
            </button>

            <!-- Blog Form (conditionally shown) -->
            <BlogForm
                v-if="showForm"
                :blog="selectedBlog"
                @cancel="handleCancel"
                @saved="handleBlogSaved"
            />

            <!-- Blog Cards -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <BlogCard
                    v-for="blog in blogs"
                    :key="blog.id"
                    :blog="blog"
                    :is-owner="isOwner(blog)"
                    @edit="handleEditBlog"
                    @delete="handleDeleteBlog"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

// Components Imports
import BlogForm from "@/Components/Blog/BlogForm.vue";
import BlogCard from "@/Components/Blog/BlogCard.vue";

const user = usePage().props.auth.user;
const loading = ref(false);
const error = ref("");
const isLoggedIn = ref(true);
const showForm = ref(false);
const editingBlog = ref(null);
const selectedBlog = ref(null); // Stores the blog to edit (null = create mode)

const blogs = ref([]);

const isOwner = (blog) => isLoggedIn.value && blog.user_id === user.id;

const fetchBlogs = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/blogs");

        blogs.value = response.data;

        console.log(blogs.value);
    } catch (error) {
        console.error("Error fetching blogs:", error); // Log errors
    } finally {
        loading.value = false;
    }
};

// const showForm = () => {};

// const handleBlogSaved = (newBlog) => {
//     // editing.value = true;

//     if (editingBlog.value) {
//         const index = blogs.value.findIndex((b) => b.id === newBlog.id);

//         if (index !== -1) {
//             blogs.value[index] = newBlog;
//         }
//     } else {
//         blogs.value.unshift(newBlog);
//     }
//     // finally {
//     //     editing.value = false;
//     // }
//     showForm.value = false;
//     selectedBlog.value = null; // IMPORTANT: Reset selectedBlog when canceling
// };

const handleBlogSaved = (newBlog) => {
    const index = blogs.value.findIndex((b) => b.id === newBlog.id);

    if (index !== -1) {
        blogs.value[index] = newBlog; // ✅ Update existing blog in place
    } else {
        blogs.value.unshift(newBlog); // ✅ Add new blog to the beginning
    }

    // ✅ Cleanup: hide form, clear selected & editing blog
    showForm.value = false;
    selectedBlog.value = null;
    editingBlog.value = null; // <-- ✅ Make sure to clear this after editing
};

const handleCancel = () => {
    showForm.value = false;
    selectedBlog.value = null; // IMPORTANT: Reset selectedBlog when canceling
};

const handleEditBlog = (b) => {
    selectedBlog.value = b;

    showForm.value = true;
};

const handleDeleteBlog = () => {
    
};

onMounted(fetchBlogs);
</script>
