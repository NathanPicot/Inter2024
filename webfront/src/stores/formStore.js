// src/store/formStore.js
import { defineStore } from 'pinia';

export const useFormStore = defineStore('formInscription', {
    state: () => ({
        username: '',
        email: '',
        password: '',
    }),
    actions: {
        setUsername(value) {
            this.username = value;
        },
        setEmail(value) {
            this.email = value;
        },
        setPassword(value) {
            this.password = value;
        },
        logUsername() {
            console.log(this.password);
        },
        resetForm() {
            this.username = '';
            this.email = '';
            this.password = '';
        },
    },
    getters: {
        getUsernameUpperCase() {
            console.log(this.username);
            return this.username.toUpperCase();
        },

    }
});
