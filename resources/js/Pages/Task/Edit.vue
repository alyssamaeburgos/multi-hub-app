<template>
    <AuthenticatedLayout>
        <div class="flex justify-center items-center mt-5">
            <div class="tasks-add w-98 p-8 border rounded shadow-md">
                <div class="tasks-form">
                    <h1 class="action-title text-2xl font-semibold mb-6">
                        Add Task
                    </h1>
                    <form @submit.prevent="submitForm">
                        <input
                            class="w-full p-2 border rounded mt-2"
                            v-model="form.title"
                            placeholder="Title"
                        />
                        <textarea
                            class="w-full p-2 border rounded mt-4"
                            v-model="form.description"
                            placeholder="Description"
                        ></textarea>

                        <div class="flex space-x-2 mt-4">
                            <div class="flex-1">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="deadline"
                                >
                                    Deadline Date
                                </label>
                                <input
                                    type="date"
                                    id="deadline"
                                    v-model="form.deadline"
                                />
                                <!-- class="w-full p-2 border rounded" -->
                            </div>

                            <div class="flex-1">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="status"
                                >
                                    Status
                                </label>
                                <select
                                    :class="statusClass(form.status)"
                                    v-model="form.status"
                                    id="status"
                                    class="w-full p-2 border rounded"
                                >
                                    <!-- class="w-full p-2 border rounded" style="background-color: white" -->
                                    <option
                                        v-for="option in statusOptions"
                                        :key="option.value"
                                        :value="option.value"
                                        :style="optionStyle(option.value)"
                                    >
                                        {{ option.text }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="flex space-x-2 mt-4">
                            <div class="flex-1" v-if="tasks">
                                <!-- <button
                            class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
                            type="submit"
                        > -->
                                <a :href="route('tasks.index')">
                                    <button
                                        class="mt-6 w-full p-2 bg-gray-500 text-white rounded"
                                        type="button"
                                    >
                                        Cancel
                                    </button></a
                                >
                            </div>

                            <div class="flex-1">
                                <!-- <button
                            class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
                            type="submit"
                        > -->
                                <button
                                    class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
                                    type="submit"
                                >
                                    Update Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div
            v-if="successMessage"
            class="mt-4 p-4 bg-green-200 border border-green-400 rounded"
        >
            {{ successMessage }}
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

export default {
    name: "Edit Task",

    components: {
        AuthenticatedLayout,
    },

    props: {
        task: {
            type: Object,
            required: true,
        },
    },

    setup(props) {
        const user = usePage().props.auth.user;

        const form = ref({
            user_id: user.id,
            title: props.task.title, // Initialize form with task data
            description: props.task.description,
            // deadline: props.task.deadline.split(" ")[0], //Format date
            deadline: props.task.deadline
                ? props.task.deadline.split(" ")[0]
                : "",
            status: props.task.status,
        });

        // Reactive variables for tasks and loading state
        const tasks = ref(props.task || []); // Use prop if provided, otherwise initialize as empty array
        const loading = ref(true);
        const error = ref({});
        const successMessage = ref(null);

        const statusClass = (status) => {
            switch (status) {
                case "done":
                    return "inline px-3 py-1 text-sm font-normal rounded-full text-green-500 gap-x-2 bg-green-100/60 dark:bg-gray-800";
                case "in progress":
                    return "inline px-3 py-1 text-sm font-normal rounded-full text-yellow-500 gap-x-2 bg-yellow-100/60 dark:bg-gray-800";
                case "open":
                    return "inline px-3 py-1 text-sm font-normal rounded-full text-blue-500 gap-x-2 bg-blue-100/60 dark:bg-gray-800";
                default:
                    return "inline px-3 py-1 text-sm font-normal rounded-full text-gray-500 gap-x-2 bg-gray-100/60 dark:bg-gray-800";
            }
        };

        // dropdown options color
        const statusOptions = ref([
            { value: "open", text: "Open" },
            { value: "in progress", text: "In Progress" },
            { value: "done", text: "Done" },
        ]);

        const optionStyle = (value) => {
            if (value === "open") {
                return { color: "blue" };
            } else if (value === "in progress") {
                return { color: "oklch(0.554 0.135 66.442)" };
            } else if (value === "done") {
                return { color: "green" };
            }
            return {};
        };

        const submitForm = async () => {

            try {
                // Ensure deadline is not null before sending data
                form.value.deadline = form.value.deadline || "";

                const response = await axios.put(
                    `/api/tasks/${props.task.id}`,
                    form.value
                );

                Swal.fire({
                    title: "Task updated successfully!",
                    icon: "success",
                    timer: 1000, // Show for 1 second
                    showConfirmButton: false, // No button
                    allowOutsideClick: false, // Prevent closing by clicking outside
                    didOpen: () => {
                        setTimeout(() => {
                            window.location.href = response.data.redirect; // Redirect after 1 second
                        }, 1000);
                    },
                });

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    error.value = error.response.data.errors;
                } else {
                    console.error("Error updating task!", error);
                }
            }
        };

        return {
            form,
            loading,
            tasks,
            optionStyle,
            statusClass,
            statusOptions,
            submitForm,
            successMessage,
        };
    },
};
</script>
