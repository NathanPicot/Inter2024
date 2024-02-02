
<script setup>
// import { useCounterStore } from "@/stores/userStore";
import FormInscription from '@/components/FormInscription.vue'


// const store = useCounterStore();
// store.count++;
// store.increment(2);

// export default {
//   name: 'App',
//
//   components: {
    FormInscription;
  // },

// }
</script>


<template>
  <v-app>
    <v-main>
<!--      <h1>count is : {{ store.count }}</h1>-->
<!--      <button @click="store.increment(1)">increment</button>-->
      <FormInscription/>
    </v-main>
  </v-app>
</template>