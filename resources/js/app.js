import "../css/app.css";
import "./bootstrap";

// Import Flowbite correctly
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { initFlowbite } from 'flowbite';
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// Element Plus
import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

// SweetAlert2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appName = import.meta.env.VITE_APP_NAME || "M-shping";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
     setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // استخدام البلجنات
        app.use(plugin);
        app.use(ZiggyVue);
        app.use(ElementPlus);

        // تهيئة SweetAlert2 بشكل صحيح
        app.use(VueSweetalert2);
        app.config.globalProperties.$swal = app.config.globalProperties.$Swal;

        app.mount(el);

        // تهيئة Flowbite بعد تحميل التطبيق
        initFlowbite();
    },
    progress: {
        color: "#4B5563",
    },
});
