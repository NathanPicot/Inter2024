<template>
  <v-app>
    <v-main>
      <FormInscription/>
    </v-main>
  </v-app>
</template>

<script>
import FormInscription from '@/components/FormInscription.vue'

export default {
  name: 'App',

  components: {
    FormInscription
  },

  data: () => ({
    //
  }),
}
</script>
