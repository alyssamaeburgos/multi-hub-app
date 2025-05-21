<template>
    <div class="flex items-center">
        <div class="relative flex-grow">
            <MagnifyingGlassIcon
                v-if="withIcon"
                class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
            />
            <input
                type="text"
                v-model="searchTerm"
                :placeholder="placeholder"
                :class="[
                    'w-full py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500',
                    withIcon ? 'pl-10 pr-4 rounded-l-md' : 'px-4 rounded-l-md',
                ]"
                @input="emitSearch"
                @keyup.enter="emitSearch"
            />
        </div>
        <button
            @click="clearSearch"
            :disabled="disabled"
            :class="[
                'px-4 py-2 bg-gray-400 text-white rounded-r-md hover:bg-gray-600',
                disabled ? 'opacity-50 cursor-not-allowed' : '',
            ]"
        >
            Clear
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    placeholder: {
        type: String,
        default: "Search...",
    },
    buttonText: {
        type: String,
        default: "Search",
    },
    disabled: Boolean,
    withIcon: {
        type: Boolean,
        default: true,
    },
    modelValue: {
        // Add this to support v-model
        type: String,
        default: "",
    },
});

const emit = defineEmits(["search", "clear-search", "update:modelValue"]);

const searchTerm = ref(props.modelValue);

// Sync external modelValue changes
watch(
    () => props.modelValue,
    (newVal) => {
        searchTerm.value = newVal;
    }
);

const emitSearch = () => {
    emit("update:modelValue", searchTerm.value);
    emit("search", searchTerm.value);
};

const clearSearch = () => {
    searchTerm.value = "";
    emit("update:modelValue", "");
    emit("clear-search");
    // emit("search", ""); // Also emit empty search to trigger refresh
};
</script>
