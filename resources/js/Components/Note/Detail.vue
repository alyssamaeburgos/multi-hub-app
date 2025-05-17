<template>
    <div v-if="note" class="p-6">
        <p class="text-red-500 mt-2">note.id: {{ note.id }}</p>
        <input
            v-model="note.title"
            type="text"
            placeholder="Untitled note"
            class="w-full text-2xl font-semibold mb-4 border-b-2 border-gray-300 focus:outline-none focus:border-blue-500"
        />

        <!-- <h2 class="text-2xl font-semibold mb-4">
            {{ note.title || "Untitled Note" }}
        </h2> -->

        <div class="text-gray-600 mb-2">
            Created: {{ formatDate(note.date_created) }}
            <span
                v-if="
                    note.date_modified &&
                    note.date_modified !== note.date_created
                "
                >, Modified: {{ formatDate(note.date_modified) }}</span
            >
            <br />
            User ID: {{ note.user_id }}
        </div>

        <textarea
            v-model="note.content"
            placeholder="No content"
            class="w-full h-64 mt-4 border border-gray-300 rounded-md p-3 focus:outline-none focus:border-blue-500 resize-none"
        >
        </textarea>

        <!-- <div class="mt-4 whitespace-pre-wrap">
            {{ note.content || "No content." }}
        </div> -->
    </div>

    <div v-else class="p-6 text-gray-500 italic">
        Select a note to view its details.
    </div>

    <!-- <button
        @click="note.id ? goUpdate() : goSave()"
        class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
    >
        {{ note.id ? "Update" : "Save" }}
    </button> -->

    <button v-if="hasId" @click="goUpdate">Update</button>
    <button v-else @click="goSave">Save</button>

    <button class="mt-6 w-full p-2 bg-red-500 text-white rounded" type="submit">
        Delete
    </button>

    <button
        @click="goBack"
        class="mt-6 w-full p-2 bg-gray-500 text-white rounded"
        type="submit"
    >
        Back
    </button>
</template>

<script setup>
import { ref, watch, reactive, computed } from "vue"; // defineProps,
import { format } from "date-fns"; // You might want to use a date formatting library
import axios from "axios";
import { usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { onMounted } from "vue";

const props = defineProps({
    note: {
        type: Object,
        default: null,
    },
    updatedNote: {
        type: Function,
        required: true,
    },
});

const user = usePage().props.auth.user;

const note = reactive({
    // id: props.note?.id || null,
    id: props.note?.id ?? null,
    user_id: user.id,
    title: props.note?.title || "",
    content: props.note?.content || "",
    date_created: new Date().toISOString().slice(0, 10),
    date_modified: props.note?.date_modified || null,
});

const emit = defineEmits([
    // "update-note",
    "go-back",
    // "noteUpdated",
    "note-updated",
    "note-saved",
]);

// Computed property to check if note has an id
const hasId = computed(() => {
    return (
        props.note &&
        props.note.id !== null &&
        props.note.id !== undefined &&
        props.note.id !== ""
    );
});

// console.log("NoteDetail received prop:", props.note);

const formatDate = (date) => {
    if (!date) return "";
    return format(new Date(date), "yyyy-MM-dd HH:mm:ss");
};

const goBack = () => {
    emit("go-back", props.note); // Emit the 'go-back' event when the button is clicked
};

// Update existing note
const goUpdate = async () => {
    try {
        if (!props.note) {
            console.error("Note is undefined or null");
            return;
        }

        const response = await axios.put(
            `/api/notes/${props.note.id}`,
            props.note
        );
        const updatedNote = response.data;

        // Update local date_modified in note (if needed)
        props.note.date_modified = updatedNote.date_modified;

        emit("note-updated", updatedNote);

        Swal.fire({
            title: "Note updated successfully!",
            icon: "success",
            timer: 1000,
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    } catch (error) {
        console.error("Update error:", error);
        alert("Failed to update note.");
    }
};

// Save new note
const goSave = async () => {
    try {
        if (!props.note) {
            console.error("Note is undefined or null");
            return;
        }

        const response = await axios.post("/api/notes", props.note);
        const newNote = response.data;

        emit("note-saved", newNote);

        Swal.fire({
            title: "Note saved successfully!",
            icon: "success",
            timer: 1000,
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    } catch (error) {
        console.error("Save error:", error);
        alert("Failed to save note.");
    }
};

watch(
    () => props.note,
    (newNote) => {
        console.log("Note prop changed:", newNote);
        if (newNote) {
            Object.assign(note, {
                id: newNote.id,
                user_id: newNote.user_id,
                title: newNote.title || "",
                content: newNote.content || "",
                date_created: newNote.date_created,
                date_modified: newNote.date_modified,
            });
        } else {
            console.log("Resetting note to new state");
            Object.assign(note, {
                id: null,
                user_id: user.id,
                title: "",
                content: "",
                date_created: new Date().toISOString().slice(0, 10),
                date_modified: null,
            });
        }
    },
    { immediate: true }
);
</script>
