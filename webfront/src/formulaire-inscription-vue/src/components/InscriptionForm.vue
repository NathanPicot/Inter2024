<!-- src/components/Form.vue -->

<template>
  <h1 style="margin-left: 40%; margin-top: 10%">INSCRIPTION</h1>
  <v-form @submit.prevent="submitForm" style="width: 70%; margin-left: 15%;">
    <v-text-field v-model="formData.name" label="Pseudo" required style="width: 70%; margin-left: 15%;"></v-text-field>

    <v-text-field v-model="formData.email" label="Email" required type="email" style="width: 70%; margin-left: 15%;"></v-text-field>

    <v-text-field v-model="formData.password" label="Mot de passe" required type="password" style="width: 70%; margin-left: 15%;"></v-text-field>

    <v-btn type="submit" color="primary" style="margin-left: 40%;">Inscription</v-btn>
  </v-form>
</template>

<script>
export default {
  name: 'InscriptionForm',

  data() {
    return {
      formData: {
        name: '',
        email: ''
      }
    };
  },
  methods: {
    submitForm() {
      // Envoyer les données du formulaire au backend (vous devrez implémenter cela)
      console.log('Form submitted:', this.formData);
    }
  }
};
</script>

<style scoped>
/* Styles spécifiques au composant */
</style>
