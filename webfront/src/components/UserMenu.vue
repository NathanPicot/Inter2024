<script setup>
//import FormInscription from '@/components/FormInscription.vue'
import { useFormStore } from '@/stores/formStore.js'

// this will ensure reactivity
const store = useFormStore();
</script>

<template>
  <v-row justify="center" class="fixed-menu">
    <v-col>
      <v-menu v-if="store.getIsConnected">
        <template v-slot:activator="{ props }">
          <v-icon size="64" class="ma-8" v-bind="props">mdi-account-circle</v-icon>
        </template>
        <v-list>
          <v-list-subheader>MENU</v-list-subheader>
          <v-list-item
              prepend-icon="mdi-account"
              to="/FormChangeInfos"
          >
            Mon compte
          </v-list-item>
          <v-list-item
              prepend-icon="mdi-archive"
              to="/Mes Projets"
          >
            Mes projets
          </v-list-item>
          <v-list-item
              prepend-icon="mdi-arrow-left-bold"
              to="/"
          >
            Se déconnecter
          </v-list-item>
        </v-list>
      </v-menu>
    </v-col>
  </v-row>
</template>

<style scoped>
.fixed-menu {
  position: fixed;
  z-index: 10;
  width: 100%;
}
</style>