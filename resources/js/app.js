import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// import axios from "axios"; // Import Axios

// import * as bootstrap from "bootstrap";
// import "bootstrap/dist/css/bootstrap.min.css";
// import "bootstrap";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// // ✅ Configure Axios
// axios.defaults.baseURL =
//     import.meta.env.VITE_APP_URL || "http://127.0.0.1:8000"; // Ensure API base URL is correct
// axios.defaults.withCredentials = true; // Enable Laravel Sanctum session authentication
// axios.defaults.headers.common["Accept"] = "application/json"; // Ensure JSON responses
// axios.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem(
//     "authToken"
// )}`; // Attach token if available

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
