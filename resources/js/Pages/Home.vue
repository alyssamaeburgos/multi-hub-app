<template>
    <Landing>
        <Main />
    </Landing>
</template>

<script>
import Landing from "../Layouts/Landing.vue";
import Main from "../Components/Landing/Main.vue";

export default {
    name: "home", // Corrected name format
    components: {
        Landing,
        Main,
    },
};
</script>
