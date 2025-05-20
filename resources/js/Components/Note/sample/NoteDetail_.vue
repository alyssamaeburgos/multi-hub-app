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
        @click="note.id ? goSave() : goUpdate()"
        class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
        type="submit"
    >
        {{ note.id ? "Save" : "Update" }}
    </button> -->

    <button
        @click="note.id ? goUpdate() : goSave()"
        class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
    >
        {{ note.id ? "Update" : "Save" }}
    </button>

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
import { ref, watch, reactive } from "vue";
import { format } from "date-fns";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const props = defineProps({
    note: {
        type: Object,
        default: null,
    },
    // updatedNote: {
    //     type: Function,
    //     required: true,
    // },
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
]);

// console.log("NoteDetail received prop:", props.note);

const formatDate = (date) => {
    if (!date) return "";
    return format(new Date(date), "yyyy-MM-dd HH:mm:ss");
};

const goBack = () => {
    emit("go-back", props.note); // Emit the 'go-back' event when the button is clicked
};

const goSave = async () => {
    console.log("hello goSave!");

    try {
        // note.value.user_id = user.id; // Ensure user_id before sending

        const response = await axios.post("/api/notes", note);

        console.log("Sending:", note);

        // Emit to parent so it updates the list and sets this as selected
        // emit("note-selected", response.data);

        // Update the note with the response data
        Object.assign(note, response.data);

        // Emit the updated note to parent
        emit("note-updated", response.data);

        Swal.fire({
            title: "Note added successfully!",
            icon: "success",
            timer: 1000, // Show for 1 second
            showConfirmButton: false, // No button
            allowOutsideClick: false, // Prevent closing by clicking outside
        });
    } catch (error) {
        // console.error("Error:", error); // Log the entire error object

        if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.error("Error Response Data:", error.response.data);
            console.error("Error Response Status:", error.response.status);
            console.error("Error Response Headers:", error.response.headers);
            alert("Failed to add task: " + error.response.data.message); // or a more specific message
        } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.error("Error Request:", error.request);
            alert("Failed to add task: No response from server.");
        } else {
            // Something happened in setting up the request that triggered an Error
            console.error("Error Message:", error.message);
            alert("Failed to add note: " + error.message);
        }
    }
};

const goUpdate = async () => {
    try {
        isUpdating.value = true;
        // Ensure the note exists before attempting to update it
        if (!note) {
            console.error("Note is undefined or null");
            return;
        }

        // Perform the PUT request to update the note
        const response = await axios.put(
            `/api/notes/${note.id}`, // Use `note.id` for PUT request
            note
        );

        // Update the local note object with the response data
        // This assumes the API returns the updated note in `response.data.notes`
        // const updatedNote = response.data.note;
        const updatedNote = response.data;

        // console.log("Updated note from API:", updatedNote);

        // ✅ Update frontend reactive state from backend response
        note.date_modified = response.data.date_modified;

        // Emit the updated note so parent can re-render sidebar and selection
        // emit("note-selected", response.data.note);
        // Emit updated note so parent can update its state
        emit("note-updated", updatedNote);
        // emit("update-note",  updatedNote);

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
    } finally {
        isUpdating.value = false;
    }
};

// Watch for changes in the note object and emit an update event

////////////////////

// const goUpdate = async () => {
//     try {
//         if (!note) {
//             console.error("Note is undefined or null");
//             return;
//         }

//         // If you have separate draft state (updatedNote), use that instead:
//         const dataToUpdate = updatedNote || note; // Fallback to note if no updatedNote

//         const response = await axios.put(
//             `/api/notes/${note.id}`,
//             dataToUpdate // Use the appropriate data source
//         );

//         const updatedNoteFromServer = response.data;

//         // Don't directly modify props - emit and let parent handle it
//         emit("note-updated", updatedNoteFromServer);

//         Swal.fire({
//             title: "Note updated successfully!",
//             icon: "success",
//             timer: 1000,
//             showConfirmButton: false,
//             allowOutsideClick: false,
//         });
//     } catch (error) {
//         console.error("Update error:", error);
//         alert("Failed to update note.");
//     }
// };

// watch(
//     () => props.note,
//     (newNote) => {
//         if (newNote) {
//             Object.assign(note, {
//                 id: newNote.id,
//                 user_id: newNote.user_id,
//                 title: newNote.title || "",
//                 content: newNote.content || "",
//                 date_created: newNote.date_created,
//                 date_modified: newNote.date_modified,
//             });
//         }
//     },
//     { immediate: true }
// );

// watch(
//     () => props.note,
//     (newNote) => {
//         console.log("Note prop changed:", newNote);
//         if (newNote) {
//             Object.assign(note, {
//                 id: newNote.id,
//                 user_id: newNote.user_id,
//                 title: newNote.title || "",
//                 content: newNote.content || "",
//                 date_created: newNote.date_created,
//                 date_modified: newNote.date_modified,
//             });
//         } else {
//             console.log("Resetting note to new state");
//             Object.assign(note, {
//                 id: null,
//                 user_id: user.id,
//                 title: "",
//                 content: "",
//                 date_created: new Date().toISOString().slice(0, 10),
//                 date_modified: null,
//             });
//         }
//     },
//     { immediate: true }
// );

const isUpdating = ref(false);

watch(
    () => props.note,
    (newNote) => {
        if (isUpdating.value) return;

        // Only sync when a new note is selected (ignore null/undefined)
        if (newNote?.id && newNote.id !== note.id) {
            Object.assign(note, {
                id: newNote.id,
                title: newNote.title,
                content: newNote.content,
                // Keep your local date_created if editing
                date_modified: newNote.date_modified,
            });
        }
    },
    { deep: true }
);

// watch(
//     () => props.note,
//     (newNote) => {
//         if (newNote) {
//             // Existing note - update all fields
//             Object.assign(note, {
//                 id: newNote.id,
//                 user_id: newNote.user_id,
//                 title: newNote.title,
//                 content: newNote.content,
//                 date_created: newNote.date_created,
//                 date_modified: newNote.date_modified,
//             });
//         }
//         // else {
//         //     // New note - reset to empty state
//         //     Object.assign(note, {
//         //         id: null,
//         //         user_id: user.id,
//         //         title: "",
//         //         content: "",
//         //         date_created: new Date().toISOString().slice(0, 10),
//         //         date_modified: null,
//         //     });
//         // }
//     },
//     { immediate: true, deep: true }
// );
</script>
