<template>
    <AuthenticatedLayout>
        <section class="container px-4 mx-auto mb-5">
            <div class="flex flex-col mt-6">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                    >
                        <div
                            class="overflow-hidden border border-gray-200 md:rounded-lg"
                        >
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-150">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="py-3.5 px-4 text-sm font-bold text-left rtl:text-right text-blue-600/75"
                                        >
                                            <button
                                                class="flex items-center gap-x-3 focus:outline-none"
                                            >
                                                <span>Title</span>

                                                <svg
                                                    class="h-3"
                                                    viewBox="0 0 10 11"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                        fill="currentColor"
                                                        stroke="currentColor"
                                                        stroke-width="0.1"
                                                    />
                                                    <path
                                                        d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                        fill="currentColor"
                                                        stroke="currentColor"
                                                        stroke-width="0.1"
                                                    />
                                                    <path
                                                        d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                        fill="currentColor"
                                                        stroke="currentColor"
                                                        stroke-width="0.3"
                                                    />
                                                </svg>
                                            </button>
                                        </th>

                                        <th
                                            scope="col"
                                            class="py-3.5 px-4 text-sm font-bold text-left rtl:text-right text-blue-600/75"
                                        >
                                            About
                                        </th>

                                        <th
                                            scope="col"
                                            class="py-3.5 px-4 text-sm font-bold text-left rtl:text-right text-blue-600/75"
                                        >
                                            Users
                                        </th>

                                        <th
                                            scope="col"
                                            class="py-3.5 px-4 text-sm font-bold text-left rtl:text-right text-blue-600/75"
                                        >
                                            Deadline
                                        </th>

                                        <th
                                            scope="col"
                                            class="py-3.5 px-4 text-sm font-bold text-left rtl:text-right text-blue-600/75"
                                        >
                                            Status
                                        </th>

                                        <th
                                            scope="col"
                                            class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                        >
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr v-if="loading">
                                        <td colspan="6">Loading...</td>
                                    </tr>
                                    <tr v-else-if="tasks.length === 0">
                                        <td colspan="6">No tasks found.</td>
                                    </tr>
                                    <tr
                                        v-else
                                        v-for="task in tasks"
                                        :key="task.id"
                                    >
                                        <td
                                            class="px-4 py-4 text-sm font-medium whitespace-nowrap"
                                        >
                                            <div>
                                                <h2
                                                    class="font-medium text-gray-800"
                                                >
                                                    {{ task.title }}
                                                </h2>
                                            </div>
                                        </td>

                                        <td
                                            class="px-4 py-4 text-sm whitespace-nowrap"
                                        >
                                            <div>
                                                <h4 class="text-gray-700">
                                                    {{ task.description }}
                                                </h4>
                                            </div>
                                        </td>

                                        <td
                                            class="px-4 py-4 text-sm whitespace-nowrap"
                                        >
                                            <div>
                                                <h4
                                                    class="text-gray-700 dark:text-gray-500"
                                                >
                                                    {{
                                                        task.user
                                                            ? task.user.name
                                                            : ""
                                                    }}
                                                </h4>
                                            </div>
                                        </td>

                                        <td
                                            class="px-4 py-4 text-sm whitespace-nowrap"
                                        >
                                            <div>
                                                <h4
                                                    class="text-gray-700 dark:text-gray-500"
                                                >
                                                    {{ task.deadline }}
                                                </h4>
                                            </div>
                                        </td>

                                        <td
                                            class="px-12 py-4 text-sm font-medium whitespace-nowrap"
                                        >
                                            <select
                                                :class="
                                                    statusClass(task.status)
                                                "
                                                v-model="task.status"
                                                style="background-color: white"
                                            >
                                                <option
                                                    v-for="option in statusOptions"
                                                    :key="option.value"
                                                    :value="option.value"
                                                    :style="
                                                        optionStyle(
                                                            option.value
                                                        )
                                                    "
                                                >
                                                    {{ option.text }}
                                                </option>
                                            </select>
                                        </td>

                                        <td
                                            class="px-4 py-4 text-sm whitespace-nowrap"
                                        >
                                            <div
                                                class="flex items-center gap-x-6"
                                            >
                                                <!-- Edit button -->
                                                <button
                                                    @click="
                                                        goToEditPage(task.id)
                                                    "
                                                    class="text-gray-700 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-600 hover:text-yellow-500 focus:outline-none"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-5 h-5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                                        />
                                                    </svg>
                                                </button>

                                                <!-- delete button -->
                                                <button
                                                    @click="deleteTask(task.id)"
                                                    class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-500 hover:text-red-500 focus:outline-none"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-5 h-5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a
                    href="#"
                    class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 rtl:-scale-x-100"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"
                        />
                    </svg>

                    <span> previous </span>
                </a>

                <div class="items-center hidden md:flex gap-x-3">
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60"
                        >1</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100"
                        >2</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100"
                        >3</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100"
                        >...</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100"
                        >12</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100"
                        >13</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100"
                        >14</a
                    >
                </div>

                <a
                    href="#"
                    class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800"
                >
                    <span> Next </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 rtl:-scale-x-100"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                        />
                    </svg>
                </a>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

export default {
    name: "Show All Tasks",

    components: {
        AuthenticatedLayout,
    },

    props: {
        tasks: {
            type: Array,
            default: () => [],
        },
    },

    setup(props) {

        const loading = ref(true);
        const tasks = ref(props.tasks || []); // Use prop if provided, otherwise initialize as empty array


        const goToEditPage = (id) => {
            router.visit(route("tasks.update", { id }));
        };

        const deleteTask = async (id) => {

            if (!window.confirm("Are you sure you want to delete this task?")) {
                return;
            }

            axios
                .delete(`/api/tasks/${id}`)
                .then((response) => {
                    console.log(response.data.message);
                    tasks.value = tasks.value.filter((task) => task.id !== id);
                })
                .catch((error) => {
                    console.error(
                        "Error deleting task:",
                        error.response?.data || error.message
                    );
                });
        };

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

        // Function to fetch tasks from the API
        const tableLoading = async () => {
            try {
                const response = await axios.get("/api/tasks"); // Call Laravel API
                console.log("Fetched Tasks:", response.data); // Debugging: Check if API returns empty array
                tasks.value = response.data; // Update tasks with fetched data
            } catch (error) {
                console.error("Error fetching tasks:", error); // Log errors
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            tableLoading();
        });

        return {
            loading,
            statusOptions,
            tasks,
            deleteTask,
            goToEditPage,
            optionStyle,
            statusClass,
        };
    },
};
</script>
