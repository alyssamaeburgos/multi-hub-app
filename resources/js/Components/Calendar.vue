<!-- CALENDAR USED >>>>   https://antoniandre.github.io/vue-cal/ -->
<template>
    <!-- <pre v-if="events.length > 0">{{ events }}</pre> -->

    <vue-cal
        style="height: 600px"
        :events="events"
        default-view="month"
        :disable-views="['years', 'year']"
        :time="true"
        @cell-click="$emit('cell-click', $event)"
        @event-click="$emit('event-click', $event)"
        start-week-on-sunday
        twelve-hour
    />
</template>

<script setup>
import { watch } from "vue";
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
});

defineEmits(["cell-click", "event-click"]);

// Debugging
watch(
    () => props.events,
    (newVal) => {
        console.log("Received events:", newVal);
    },
    { immediate: true }
);
</script>

<style>
/* Main calendar styling */
.custom-vue-cal {
    --cell-height: 80px;
    --border-color: #e0e0e0;
    --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    --border-radius: 8px;
    --header-bg-color: #f8f9fa;
    --header-text-color: #333;
    --today-cell-bg-color: #e6f7ff;
    --selected-cell-bg-color: #f0f0f0;

    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
}

/* Header styling */
.custom-vue-cal .vuecal__header {
    background-color: var(--header-bg-color);
    color: var(--header-text-color);
    padding: 15px 0;
    border-bottom: 1px solid var(--border-color);
}

.custom-vue-cal .vuecal__title-bar {
    font-size: 1.2em;
    font-weight: 600;
}

.custom-vue-cal .vuecal__arrow {
    color: var(--header-text-color);
    font-size: 1.5em;
}

/* Cell styling */
.custom-vue-cal .vuecal__cell {
    height: var(--cell-height);
    border-right: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    transition: background-color 0.2s;
}

.custom-vue-cal .vuecal__cell:hover {
    background-color: #f9f9f9;
}

.custom-vue-cal .vuecal__cell.today {
    background-color: var(--today-cell-bg-color);
}

.custom-vue-cal .vuecal__cell.selected {
    background-color: var(--selected-cell-bg-color);
}

/* Day header (date number) */
.custom-vue-cal .vuecal__cell-date {
    padding: 4px;
    font-size: 0.9em;
    font-weight: 500;
}

.custom-vue-cal .vuecal__cell-date--day {
    font-size: 1.2em;
    font-weight: bold;
}

/* Events styling */
.custom-vue-cal .vuecal__event {
    background-color: #4a90e2;
    color: white;
    border-radius: 4px;
    padding: 2px 4px;
    margin-bottom: 2px;
    font-size: 0.8em;
    cursor: pointer;
    transition: all 0.2s;
}

.custom-vue-cal .vuecal__event:hover {
    opacity: 0.9;
    transform: translateX(2px);
}

/* Special class for task events */
.custom-vue-cal .vuecal__event.task-event {
    background-color: #6c5ce7;
}

/* Time labels */
.custom-vue-cal .vuecal__time-cell {
    font-size: 0.8em;
    color: #666;
}

/* Current time indicator */
.custom-vue-cal .vuecal__now-line {
    background-color: #ff4757;
    height: 2px;
}

.custom-vue-cal .vuecal__now-line::before {
    background-color: #ff4757;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    top: -4px;
}
</style>
