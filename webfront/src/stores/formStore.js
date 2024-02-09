// src/store/formStore.js
import { defineStore } from 'pinia';

export const useFormStore = defineStore('formInscription', {
    state: () => ({
        username: '',
        email: '',
        modelPassword: '',
    }),
    actions: {
        setUsername(value) {
            this.username = value;
            console.log(this.username)
        },
        setEmail(value) {
            this.email = value;
        },
        setPassword(value) {
            this.modelPassword = value;
        },

        resetForm() {
            this.username = '';
            this.email = '';
            this.modelPassword = '';
        },
    },
    getters: {
        getUsernameUpperCase() {
            console.log(this.username);
            return this.username.toUpperCase();
        },

    }
});
