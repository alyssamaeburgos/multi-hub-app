<template>
    <div v-if="note" class="p-6">
        <p class="text-red-500 mt-2">note.id: {{ note.id }}</p>

        <input
            v-model="localNote.title"
            type="text"
            placeholder="Untitled note"
            class="w-full text-2xl font-semibold mb-4 border-b-2 border-gray-300 focus:outline-none focus:border-blue-500"
        />

        <div class="text-gray-600 mb-2">
            Created: {{ formatDate(note.date_created) }}
            <span
                v-if="
                    note.date_modified &&
                    note.date_modified !== note.date_created
                "
            >
                , Modified: {{ formatDate(note.date_modified) }}
            </span>
            <br />
            User ID: {{ note.user_id }}
        </div>

        <textarea
            v-model="localNote.content"
            placeholder="No content"
            class="w-full h-64 mt-4 border border-gray-300 rounded-md p-3 focus:outline-none focus:border-blue-500 resize-none"
        ></textarea>
    </div>

    <div v-else class="p-6 text-gray-500 italic">
        Select a note to view its details.
    </div>

    <button
        @click="handleSaveOrUpdate"
        :disabled="isUpdating"
        class="mt-6 w-full p-2 bg-blue-500 text-white rounded"
    >
        {{ isUpdating ? "Saving..." : note?.id ? "Update" : "Save" }}
    </button>

    <button
        @click="emit('delete-note', note)"
        class="mt-6 w-full p-2 bg-red-500 text-white rounded"
    >
        Delete
    </button>

    <button
        @click="emit('go-back')"
        class="mt-6 w-full p-2 bg-gray-500 text-white rounded"
    >
        Back
    </button>
</template>

<script setup>
import { ref, watch, reactive } from "vue";
import { format } from "date-fns";

const props = defineProps({
    note: {
        type: Object,
        default: null,
    },
    isUpdating: Boolean,
});

const emit = defineEmits([
    "note-added",
    "note-updated",
    "delete-note",
    "go-back",
]);

// Local copy to edit freely
const localNote = reactive({
    title: "",
    content: "",
    date_created: new Date().toISOString().slice(0, 10),
    date_modified: "",
});

// Watch incoming prop and update local copy
watch(
    () => props.note,
    (newNote) => {
        if (newNote) {
            localNote.title = newNote.title || "";
            localNote.content = newNote.content || "";
            // localNote.date_created = newNote.date_created || "" ;
            localNote.date_modified = newNote.date_modified || "";
        } else {
            localNote.title = "";
            localNote.content = "";
            localNote.date_modified = "";
        }
    },
    { immediate: true }
);

const formatDate = (date) => {
    if (!date) return "";
    return format(new Date(date), "yyyy-MM-dd HH:mm:ss");
};

const handleSaveOrUpdate = () => {
    const payload = {
        ...props.note,
        title: localNote.title,
        content: localNote.content,
        // date_modified: localNote.date_modified,
        date_modified: new Date().toISOString(), // Always update modified date
    };

    if (props.note?.id) {
        emit("note-updated", payload);
    } else {
        emit("note-added", payload);
    }
};
</script>
