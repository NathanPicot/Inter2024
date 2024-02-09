// main.js ou un fichier similaire
import { createRouter, createWebHistory } from 'vue-router'
import FormInscription from "@/components/FormInscription.vue";
import FormConnexion from "@/components/FormConnexion.vue";
import FormChangeInfos from "@/components/FormChangeInfos.vue";
import urlForm from "@/components/urlForm.vue";
import UserProjects from "@/components/UserProjects.vue";

const routes = [
    { path: '/', component: FormConnexion },
    { path: '/FormInscription', component: FormInscription },
    { path: '/FormChangeInfos', component: FormChangeInfos },
    { path: '/Accueil', component: urlForm },
    { path: '/Mes Projets', component: UserProjects },

];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router