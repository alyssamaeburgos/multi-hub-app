<script setup>
import { ref, computed } from "vue";

// Define props and emits
const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:modelValue"]);

// Create a computed property for v-model binding
const dateValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});
</script>

<template>
    <div>
        <!-- <label for="datepicker" class="block text-sm font-medium text-gray-700"
            >Birthdate</label
        > -->
        <input
            id="datepicker"
            type="date"
            v-model="dateValue"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
    </div>
</template>
