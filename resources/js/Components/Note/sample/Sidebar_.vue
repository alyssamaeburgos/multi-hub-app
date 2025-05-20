<template>
    <aside
        class="bg-gray-100 w-64 flex flex-col h-screen border-r border-gray-200"
    >
        <div class="p-4">
            <button
                @click="addNewNote"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
                + Add Note
            </button>
        </div>

        <div class="flex-grow overflow-y-auto p-4">
            <h2 class="text-lg font-semibold mb-2">Notes</h2>
            <ul class="space-y-1">
                <li v-for="note in notes" :key="note.id">
                    <button
                        @click="selectNote(note)"
                        class="w-full text-left py-2 px-3 rounded hover:bg-gray-200 focus:outline-none focus:shadow-outline"
                        :class="{
                            'bg-gray-200 font-semibold':
                                selectedNote && selectedNote.id === note.id,
                        }"
                    >
                        {{ note.title || "Untitled Note" }}
                    </button>
                </li>
            </ul>
            <div v-if="notes.length === 0" class="text-gray-500 italic mt-4">
                No notes yet.
            </div>
        </div>
    </aside>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    notes: {
        type: Array,
        required: true,
    },
});

const user = usePage().props.auth.user;
const notes = ref([]);
const selectedNote = ref(null);

// Simulate fetching notes (replace with your actual data fetching)
// const fetchNotes = () => {
//     // ... your API call or local storage retrieval
//     setTimeout(() => {
//         notes.value = [
//             { id: 1, title: "Grocery List", content: "Milk, Eggs, Bread..." },
//             {
//                 id: 2,
//                 title: "Project Ideas",
//                 content: "- New feature X\n- Refactor Y...",
//             },
//             { id: 3, title: "", content: "Just a quick thought." },
//         ];
//     }, 500);
// };

const fetchNotes = async () => {
    const response = await axios.get("/api/notes");

    notes.value = response.data;
    console.log(notes.value);
};

const addNewNote = () => {
    const newNote = {
        // id: Date.now(), // reason why the update button is shown istead of save button since it is new.
        title: "",
        content: "",
        date_created: new Date(),
        // date_modified: new Date(),
        user_id: user.id, // Replace with actual user ID
    };
    notes.value.unshift(newNote); // Add to the beginning of the array
    selectedNote.value = newNote; // Automatically select the new note
    // In a real app, you'd likely persist this new note immediately
    emit("note-selected", newNote);
};

const selectNote = (note) => {
    selectedNote.value = note;
    // Emit an event to the content section to display the selected note
    emit("note-selected", note);
};

onMounted(() => {
    fetchNotes();
});

const emit = defineEmits(["note-selected"]);
</script>
