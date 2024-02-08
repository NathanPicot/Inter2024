// main.js ou un fichier similaire
import { createRouter, createWebHistory } from 'vue-router'
import FormInscription from "@/components/FormInscription.vue";
import FormConnexion from "@/components/FormConnexion.vue";

const routes = [
    { path: '/', component: FormConnexion },
    { path: '/FormInscription', component: FormInscription },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router