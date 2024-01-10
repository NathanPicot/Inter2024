<!-- src/components/Form.vue -->

<template>
  <div class="d-flex justify-center mb-6 mt-6">
  <h1>INSCRIPTION</h1>
  </div>
  <v-form @submit.prevent="submitForm" style="width: 70%; margin-left: 15%;">
    <v-text-field v-model="formData.email" label="Email" required type="email" style="width: 70%; margin-left: 15%;"></v-text-field>

    <v-text-field v-model="formData.name" label="Pseudo" required style="width: 70%; margin-left: 15%;"></v-text-field>

    <v-text-field v-model="formData.password" label="Mot de passe" required type="password" style="width: 70%; margin-left: 15%;"></v-text-field>
<div class="d-flex justify-center mb-6">
    <v-btn type="submit" color="primary">Inscription</v-btn>
</div>
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
