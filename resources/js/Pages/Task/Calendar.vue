<template>
    <AuthenticatedLayout>
        <Calendar
            :events="eventTask"
            @cell-click="onCellClick"
            @event-click="onEventClick"
        >
        </Calendar>

        <div v-if="modal.show" class="modal">
            <div class="modal-content">
                <h3>
                    {{ modal.mode === "edit" ? "Edit Task" : "Add Task" }}
                </h3>

                <input v-model="modal.event.title" placeholder="Task" />
                <input
                    v-model="modal.event.description"
                    placeholder="Task description"
                />
                <input type="datetime-local" v-model="modal.event.start" />
                <input type="datetime-local" v-model="modal.event.deadline" />

                <div class="modal-actions">
                    <button @click="saveEvent">💾 Save</button>
                    <button v-if="modal.mode === 'edit'" @click="deleteEvent">
                        🗑️ Delete
                    </button>
                    <button @click="closeModal">❌ Cancel</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

// Components
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Calendar from "@/Components/Calendar.vue";

const eventTask = ref([]);

const modal = ref({
    show: false,
    mode: "create",
    event: {
        id: null,
        title: "",
        description: "",
        start: "",
        deadline: "",
    },
});

const calendarLoad = async () => {
    try {
        const tasks = await axios.get("/api/tasks");

        eventTask.value = tasks.data.map((task) => ({
            id: task.id,
            title: task.title,
            description: task.description,
            start: task.created_at || new Date().toISOString(), // change created_at to start and start_time
            end: task.deadline,
            deadline: task.deadline,
            class: "task-event",
        }));

        console.log(eventTask.value);

        console.log(tasks.data);
    } catch {
        console.error("Error loading tasks:", error);
    }
};

const closeModal = () => {
    modal.value.show = false;
};

const deleteEvent = async () => {
    // events.value = events.value.filter((e) => e.id !== modal.value.event.id);
    eventTask.value = eventTask.value.filter(
        (e) => e.id !== modal.value.event.id
    );

    const deleteTask = modal.value.event.id;

    try {
        const response = await axios.delete(`/api/tasks/${deleteTask}`);
    } catch (e) {
        console.error("Error deleting task: ", e.response.data);
    }

    console.log(deleteTask);

    closeModal();
};

const formatDateTime = (date, plusHour = 0) => {
    if (!date) return "";

    // Handle both string dates and Date objects
    const d = date instanceof Date ? date : new Date(date);
    if (isNaN(d.getTime())) return "";

    if (plusHour) d.setHours(d.getHours() + plusHour);
    return d.toISOString().slice(0, 16);
};

const onCellClick = ({ startDate }) => {
    modal.value = {
        show: true,
        mode: "create",
        event: {
            id: null,
            title: "",
            start: formatDateTime(startDate),
            end: formatDateTime(startDate, 1),
        },
    };
};

const onEventClick = (event) => {
    modal.value = {
        show: true,
        mode: "edit",
        event: {
            ...event,
            deadline: event.deadline || event.end, // Support both field names
        },
    };
};

const saveEvent = async () => {
    try {
        const e = modal.value.event;
        const taskData = {
            title: e.title,
            description: e.description,
            deadline: e.deadline || e.end, // Use deadline if available, otherwise fallback to end
        };

        if (modal.value.mode === "edit") {
            // Update existing task
            await axios.put(`/api/tasks/${e.id}`, taskData);

            // Update local state
            const index = eventTask.value.findIndex((task) => task.id === e.id);
            if (index !== -1) {
                eventTask.value[index] = {
                    ...eventTask.value[index],
                    ...taskData,
                    end: taskData.deadline, // Ensure end date is synced with deadline
                };
            }
        } else {
            // Create new task
            const response = await axios.post("/api/tasks", taskData);

            // Add to local state with the ID from backend
            eventTask.value.push({
                ...taskData,
                id: response.data.id,
                start: new Date().toISOString(), // Use current time as start
                end: taskData.deadline,
                class: "task-event",
            });
        }

        closeModal();
        // Optional: refresh the task list from server
        // await calendarLoad();
    } catch (error) {
        console.error("Error saving task:", error);
        // You could add error notification here
    }
};

onMounted(() => {
    calendarLoad();
});
</script>

<style scoped>
/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 50;
    background: rgba(0, 0, 0, 0.4);
    width: 100%;
    height: 100%;
}
.modal-content {
    background: white;
    width: 400px;
    margin: 100px auto;
    padding: 20px;
    border-radius: 8px;
}
.modal-content input {
    display: block;
    margin-bottom: 10px;
    width: 100%;
    padding: 6px;
}
.modal-actions {
    display: flex;
    justify-content: space-between;
}

.vuecal__event {
    height: 8px !important;
    width: 8px !important;
    min-height: 0 !important;
    padding: 0 !important;
    margin: 2px auto !important;
    border-radius: 50% !important;
    transform: translateX(-50%);
    left: 50% !important;
}

/* Hide time labels */
.vuecal__event-time {
    display: none !important;
}

/* Custom event dot colors */
.vuecal__event.point-event {
    background-color: #4a90e2;
}
.vuecal__event.point-event.high-priority {
    background-color: #ff6b6b;
}

/* Show deadline on hover */
.vuecal__event-title {
    display: none;
}
.vuecal__event:hover:after {
    content: attr(data-deadline);
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 2px 5px;
    border-radius: 3px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    font-size: 12px;
    white-space: nowrap;
    z-index: 1;
}
</style>
