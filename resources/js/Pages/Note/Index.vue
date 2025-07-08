<template>
    <AuthenticatedLayout>
        <div class="flex h-screen">
            <SideBar
                :notes="notes"
                :selected-note="selectedNote"
                @note-selected="handleNoteSelected"
                @add-note="addNewNote"
            />
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <NoteIndex
                    v-if="!selectedNote"
                    :notes="notes"
                    @select-note="handleNoteSelected"
                    @search="handleSearch"
                    @clear-search="handleClearSearch"
                />

                <NoteDetail
                    v-else
                    :note="selectedNote"
                    :is-updating="isUpdating"
                    @note-added="handleAddNote"
                    @note-updated="handleNoteUpdate"
                    @delete-note="deleteNote"
                    @go-back="handleGoBack"
                />
            </main>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import SideBar from "@/Components/Note/Sidebar.vue";
import NoteIndex from "@/Components/Note/NoteIndex.vue";
import NoteDetail from "@/Components/Note/NoteDetail.vue";

// ===== STATE MANAGEMENT (Parent handles all data) =====
const notes = ref([]);
const selectedNote = ref(null);
const loading = ref(true);
const user = usePage().props.auth.user;
const isUpdating = ref(false);

// ===== DATA FETCHING (Only in Parent) =====
const fetchNotes = async () => {
    try {
        const response = await axios.get("/api/notes"); // Call Laravel API

        notes.value = response.data; // Update notes with fetched data
    } catch (error) {
        console.error("Error fetching notes:", error); // Log errors
    } finally {
        loading.value = false;
    }
};

// ===== EVENT HANDLERS (Parent modifies state) =====
const handleNoteSelected = (note) => {
    // Replace or add the note in the notes list
    const index = notes.value.findIndex((n) => n.id === note.id);
    if (index !== -1) {
        notes.value[index] = note; // Update existing note
    } else {
        notes.value.unshift(note); // Add new note
    }

    selectedNote.value = note;
};

const handleAddNote = async (newNote) => {
    isUpdating.value = true;

    try {
        const response = await axios.post("/api/notes", newNote);
        const createdNote = response.data.data;

        console.log("newNote", createdNote);

        // notes.value.unshift(createdNote);

        const index = notes.value.findIndex(
            (n) => !n.id && n.user_id === user.id
        );
        if (index !== -1) {
            notes.value.splice(index, 1, createdNote); // Replace temporary note
        } else {
            notes.value.unshift(createdNote); // Fallback if temporary note not found
        }

        selectedNote.value = createdNote;

        Swal.fire({
            title: "Note added successfully!",
            icon: "success",
            timer: 1000, // Show for 1 second
            showConfirmButton: false, // No button
            allowOutsideClick: false, // Prevent closing by clicking outside
        });
    } catch (error) {
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
    } finally {
        isUpdating.value = false;
    }
};

const addNewNote = () => {
    if (isUpdating.value) {
        console.log("Skipped addNewNote because update is in progress");
        return;
    }

    const newNote = {
        title: "",
        content: "",
        date_created: new Date(),
        user_id: user.id,
    };
    // notes.value.unshift(newNote);
    selectedNote.value = newNote;
};

const handleNoteUpdate = async (updatedNote) => {
    isUpdating.value = true;

    try {
        // 1. Send update to server
        const response = await axios.put(
            `/api/notes/${updatedNote.id}`,
            updatedNote
        );

        // 2. Get server-verified data

        const getAllUpdatedNotes = await axios.get("/api/notes"); // Call Laravel API

        const notesFromServer = getAllUpdatedNotes.data; // Update notes with fetched data

        notes.value = notesFromServer;

        // 3. new process in finding the updated note in the list
        const updatedNoteFromServer = notesFromServer.find(
            (note) => note.id === updatedNote.id
        );

        // 4. New process in updating the local selected note reference
        if (updatedNoteFromServer) {
            const index = notes.value.findIndex((n) => n.id === updatedNote.id);

            if (index !== -1) {
                notes.value[index] = updatedNoteFromServer;
            } else {
                notes.value.unshift(updatedNoteFromServer);
            }

            selectedNote.value = updatedNoteFromServer;
        }

        // Show success message but stay on the same page
        Swal.fire("Updated!", "Your note has been updated.", "success");

        // 5. Update selected note reference
        selectedNote.value = updatedNoteFromServer;
    } catch (error) {
        console.error("Error updating note:", error);
        Swal.fire({
            icon: "error",
            title: "Error Updating Note",
            text: "Something went wrong while updating the note.",
        });
    } finally {
        isUpdating.value = false;
    }
};

const handleGoBack = () => {
    selectedNote.value = null;
};

const deleteNote = (note) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(`/api/notes/${note.id}`)
                .then(() => {
                    notes.value = notes.value.filter((n) => n.id !== note.id);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your note has been deleted.",
                        icon: "success",
                        timer: 1000, // Auto close after 1 second
                        showConfirmButton: false, // Hide the OK button
                    }).then(() => {
                        window.location.href = "/notes"; // Or your NoteIndex route
                    });
                })
                .catch((error) => console.error("Error deleting note", error));
        }
    });

    selectedNote.value = null;
};

// SEARCH NOTES
const searchTerm = ref("");
const error = ref(null);

const searchNotes = async () => {
    const response = await axios.get("/api/notes/search", {
        params: { search: searchTerm.value },
    });

    notes.value = response.data;
};

const handleSearch = async (term) => {
    try {
        loading.value = true;
        error.value = null;
        searchTerm.value = term;

        // Only search if term is not empty
        if (term.trim()) {
            await searchNotes();
        } else {
            // If empty search term, fetch all notes
            await fetchNotes();
        }
    } catch (err) {
        error.value = "Failed to search notes";
    } finally {
        loading.value = false;
    }
};

const handleClearSearch = async (term) => {
    try {
        loading.value = true;
        error.value = null;

        searchTerm.value = term;
        await fetchNotes();
        console.log("Notes after fetch:", notes.value); // Debug
    } catch (err) {
        error.value = "Failed to search notes";
    } finally {
        loading.value = false;
    }
};

// Fetch data when component loads
onMounted(fetchNotes);
</script>
