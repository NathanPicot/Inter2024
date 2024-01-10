<!-- src/components/Form.vue -->

<template>
  <h1 class="d-flex justify-center mb-6 mt-10">INSCRIPTION</h1>
  <div class="d-flex justify-center mb-6">
    <v-form @submit.prevent="submitForm" class="w-25 justify-center mb-6">
      <v-text-field v-model="formData.email" label="Email" required type="email"></v-text-field>
      <v-text-field v-model="formData.name" label="Pseudo" required></v-text-field>
      <v-text-field v-model="formData.password" label="Mot de passe" required type="password"></v-text-field>
      <div class="d-flex justify-center mb-6">
        <v-btn type="submit" color="primary">S'inscrire</v-btn>
      </div>
    </v-form>
  </div>
</template>

<script>
export default {
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
