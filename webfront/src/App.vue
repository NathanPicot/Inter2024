
<script setup>
import UserMenu from "@/components/UserMenu.vue";
</script>


<template>
  <v-app>
    <UserMenu/>
    <v-main>
      <router-view/>
      <!--FormInscription/>-->
    </v-main>
  </v-app>
</template>

<style scoped>


</style>