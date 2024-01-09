<!-- src/components/Form.vue -->

<template>
  <form @submit.prevent="submitForm">
    <label for="pseudo">Pseudo:</label><br>
    <input v-model="formData.name" type="text" id="pseudo" required>

    <br><label for="email">Email:</label><br>
    <input v-model="formData.email" type="email" id="email" required>

    <br><label for="password">Mot de passe:</label><br>
    <input v-model="formData.password" type="password" id="password" required>

    <button type="submit">Submit</button>
  </form>
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
