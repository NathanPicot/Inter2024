<template>
  <v-app>
    <v-main>
      <InscriptionForm/>
    </v-main>
  </v-app>
</template>

<script>
import InscriptionForm from "@/components/InscriptionForm.vue";

export default {
  name: 'App',

  components: {
    InscriptionForm,
  },

  data: () => ({
    //
  }),
}
</script>
