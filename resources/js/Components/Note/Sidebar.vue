<template>
    <aside
        class="bg-gray-100 w-64 flex flex-col h-screen border-r border-gray-200"
    >
        <div class="p-4">
            <button
                @click="emit('add-note')"
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
                        @click="emit('note-selected', note)"
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
const props = defineProps({
    notes: Array,
    selectedNote: Object,
});

const emit = defineEmits(["note-selected", "add-note"]);
</script>
