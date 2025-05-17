<template>
    <AuthenticatedLayout>
        <!-- <SideBar>
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <NoteIndex
                    v-if="!selectedNote"
                    :notes="notes"
                    @select-note="handleNoteSelected"
                />
                <NoteDetail v-else :note="selectedNote" />
            </main>
        </SideBar> -->

        <div class="flex h-screen">
            <SideBar @note-selected="handleNoteSelected" />
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <NoteIndex
                    v-if="!selectedNote"
                    :notes="notes"
                    @select-note="handleNoteSelected"
                />

                <!-- <NoteDetail
                    v-else
                    :note="selectedNote"
                    :updatedNote="handleNoteUpdate"
                    @note-updated="handleNoteUpdate"
                    @go-back="handleGoBack"
                /> -->

                <NoteDetail
                    v-else
                    :note="selectedNote"
                    :updatedNote="handleNoteUpdate"
                    @note-updated="handleNoteUpdate"
                    @go-back="handleGoBack"
                />

                <div v-if="loading">Loading...</div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref, onMounted, watch, reactive } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import SideBar from "@/Components/Note/Sidebar.vue";
import NoteIndex from "@/Components/Note/NoteIndex.vue";
import NoteDetail from "@/Components/Note/NoteDetail.vue";

export default {
    components: {
        AuthenticatedLayout,
        SideBar,
        NoteIndex,
        NoteDetail,
    },
    props: {},

    setup() {
        // const notes = ref([
        //     {
        //         id: 1,
        //         title: "Grocery List",
        //         content: "Milk, Eggs, Bread...",
        //         date_created: new Date(),
        //         date_modified: new Date(),
        //         user_id: "user123",
        //     },
        //     {
        //         id: 2,
        //         title: "Project Ideas",
        //         content: "- New feature X\n- Refactor Y...",
        //         date_created: new Date(),
        //         date_modified: new Date(),
        //         user_id: "user123",
        //     },
        //     {
        //         id: 3,
        //         title: "",
        //         content: "Just a quick thought.",
        //         date_created: new Date(),
        //         date_modified: new Date(),
        //         user_id: "user123",
        //     },
        // ]);

        const user = usePage().props.auth.user;

        const loading = ref(false);
        const notes = ref([]);

        const noted = async () => {
            try {
                const response = await axios.get("/api/notes"); // Call Laravel API

                // console.log("Fetched Tasks:", response.data); // Debugging: Check if API returns empty array

                notes.value = response.data; // Update notes with fetched data
            } catch (error) {
                console.error("Error fetching notes:", error); // Log errors
            } finally {
                loading.value = false;
                // console.log("Final tasks value:", tasks.value); // Check final value
            }
        };

        const selectedNote = ref(null);

        const handleNoteSelected = (note) => {
            // Replace or add the note in the notes list
            const index = notes.value.findIndex((n) => n.id === note.id);
            if (index !== -1) {
                notes.value[index] = note; // Update existing note
            } else {
                notes.value.unshift(note); // Add new note
            }

            console.log("handleNoteSelected triggered with:", note);
            selectedNote.value = note;
            console.log("selectedNote in parent:", selectedNote.value);
        };

        const handleNoteUpdate = async (updatedNote) => {
            try {
                const responses = await axios.put(
                    `/api/notes/${updatedNote.id}`,
                    updatedNote
                );

                // //////
                // Get the updated note from the response (ensure the API is returning the full updated note)
                // const updatedNoteFromServer = response.data.note;

                // Optionally, update the notes array locally to reflect the change immediately
                // Find the note in the array and replace it with the updated one
                const index = notes.value.findIndex(
                    (note) => note.id === updatedNote.id
                );

                if (index !== -1) {
                    // ````;
                    notes.value[index] = updatedNote;
                } else {
                    notes.value.unshift(updatedNote);
                }

                // Optionally, update the selected note to reflect the update in real time
                // selectedNote.value = updatedNoteFromServer;

                selectedNote.value = updatedNote;

                // console.log("Note updated successfully:", updatedNote);

                // // Optionally show a success message using SweetAlert
                // Swal.fire({
                //     icon: "success",
                //     title: "Note Updated!",
                //     showConfirmButton: false,
                //     timer: 1500,
                // });
            } catch (error) {
                console.error("Error updating note:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error Updating Note",
                    text: "Something went wrong while updating the note.",
                });
            }
        };

        // const handleNoteUpdate = async (updatedNote) => {
        //     try {
        //         const response = await axios.put(
        //             `/api/notes/${updatedNote.id}`,
        //             updatedNote
        //         );
        //         const serverUpdateNote = response.data;

        //         const index = notes.value.findIndex(
        //             (note) => note.id === serverUpdateNote.id
        //         );

        //         if (index !== -1) {
        //             notes.value = [
        //                 ...notes.value.slice(0, index),
        //                 serverUpdateNote,
        //                 ...notes.value.slice(index + 1),
        //             ];

        //             // notes.value[index] = updatedNote;
        //         } else {
        //             // notes.value.unshift(updatedNote);
        //             notes.value = [serverUpdateNote, ...notes.value];
        //         }

        //         selectedNote.value = serverUpdateNote;
        //     } catch (error) {
        //         console.error("Error updating note:", error);
        //         Swal.fire({
        //             icon: "error",
        //             title: "Error Updating Note",
        //             text: "Something went wrong while updating the note.",
        //         });
        //     }
        // };

        const handleGoBack = (note) => {
            selectedNote.value = null; // Set selectedNote to null to show NoteIndex

            // Check if it's a new note and not yet in the list
            const exists = notes.value.some((n) => n.id === note.id);
            if (!exists) {
                notes.value.unshift(note); // Add new note to the list
            }
        };

        // value of noted function is being sent to the child component - NoteIndex.vue to display the list of all notes.
        onMounted(noted);

        return {
            notes,
            noted,
            selectedNote,
            handleNoteSelected,
            handleNoteUpdate,
            handleGoBack,
            loading,
        };
    },
};
</script>
