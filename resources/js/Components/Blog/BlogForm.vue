<!-- components/blog/BlogForm.vue -->
<template>
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">
            {{ editing ? "Edit" : "Create" }} Blog Post
        </h2>

        <form @submit.prevent="handleSubmit">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2"
                    >Title</label
                >
                <input
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                />
            </div>

            <div class="mb-4">
                <label
                    for="content"
                    class="block text-gray-700 font-medium mb-2"
                    >Content (Markdown supported)</label
                >
                <textarea
                    id="content"
                    v-model="form.content"
                    rows="10"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                ></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2"
                    >Visibility</label
                >
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input
                            v-model="form.visibility"
                            type="radio"
                            value="public"
                            class="form-radio h-4 w-4 text-blue-600"
                        />
                        <span class="ml-2">Public</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            v-model="form.visibility"
                            type="radio"
                            value="private"
                            class="form-radio h-4 w-4 text-blue-600"
                        />
                        <span class="ml-2">Private (only you can see)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <!-- <button
                    type="button"
                    @click="$emit('cancel')"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button> -->

                <button
                    type="button"
                    @click="handleCancel"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    {{ editing ? "Update" : "Publish" }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const props = defineProps({
    blog: {
        type: Object,
        default: null,
    },
    // editing: Boolean,
});

const emit = defineEmits(["cancel", "saved"]);

const editing = computed(() => props.blog !== null);

console.log(editing.value);

const form = ref({
    title: "",
    content: "",
    visibility: "public",
});

onMounted(() => {
    if (props.blog) {
        form.value = {
            title: props.blog.title,
            content: props.blog.content,
            visibility: props.blog.visibility,
        };
    }
});

// Add this before your handleSubmit to check axios defaults
// console.log("Axios defaults:", axios.defaults.baseURL, axios.defaults.headers);

const handleSubmit = async () => {
    try {
        let response;

        if (editing.value) {
            // const response = await axios.put(
            //     `/api/blogs/${props.blog.id}`,
            //     form.value
            // );
            response = await axios.put(
                `/api/blogs/${props.blog.id}`,
                form.value
            );

            // console.log(response.data);
        } else {
            response = await axios.post("/api/blogs", form.value);
        }
        emit("saved", response.data);
    } catch (error) {
        console.error("Full error object:", error);
        console.error("Error response:", error.response);
        console.error("Error message:", error.message);
    }
};

const handleCancel = () => {
    form.value = {
        title: "",
        content: "",
        visibility: "public",
    };

    emit("cancel");
};
</script>
