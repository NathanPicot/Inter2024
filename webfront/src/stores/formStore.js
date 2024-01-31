// src/store/formStore.js
import { defineStore } from 'pinia';

export const useFormStore = defineStore('form', {
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
        resetForm() {
            this.username = '';
            this.email = '';
            this.password = '';
        },
    },
});
