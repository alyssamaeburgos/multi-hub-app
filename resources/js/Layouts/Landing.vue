<template>
    <Navbar />

    <Main>
        <slot /> <!-- Content placeholder -->
    </Main>

    <Footer />
</template>

<script setup>
import Navbar from "../Components/Landing/NavBar.vue"; // Adjust the path
import Footer from "../Components/Landing/Footer.vue";
// import Main from "../Components/Landing/Main.vue";
</script>
