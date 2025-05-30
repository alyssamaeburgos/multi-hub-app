<template>
    <div class="max-w-md mx-auto p-4">
        <SearchInput
            placeholder="Search notes..."
            button-text="Find"
            @search="onSearch"
            @clear-search="handleClearSearch"
        />
    </div>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6"
    >
        <div
            v-for="note in notes"
            :key="note.id"
            class="bg-yellow-100 border border-yellow-300 rounded-md shadow-md p-4 cursor-pointer hover:shadow-lg transition duration-200"
            @click="$emit('select-note', note)"
        >
            <h3 class="font-semibold text-lg mb-2 truncate">
                {{ note.title || "Untitled Note" }}
            </h3>
            <p class="text-gray-700 text-sm truncate-lines-3">
                {{ note.content || "No content." }}
            </p>
        </div>
        <div v-if="notes.length === 0" class="text-gray-500 italic">
            No notes to display.
        </div>
    </div>
</template>

<script setup>
import SearchInput from "@/Components/SearchInput.vue";

const props = defineProps({
    notes: Array,
    modelValue: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "Search...",
    },
    buttonText: {
        type: String,
        default: "Search",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    withIcon: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["select-note", "search", "clear-search"]);

const onSearch = (term) => {
    emit("search", term);
};

const handleClearSearch = (term) => {
    emit("clear-search", term);
};
</script>

<style scoped>
.truncate-lines-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Number of lines to show */
    -webkit-box-orient: vertical;
}
</style>
