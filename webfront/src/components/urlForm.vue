<!-- src/components/Form.vue -->

<template>
  <v-row justify="center">
    <v-col>
      <v-menu>
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
  <v-row justify="center">
    <v-col
        cols="12"
        sm="10"
        md="8"
        lg="6"
    >
      <v-card ref="form" id="urlForm">
        <v-form v-model="formValid">
          <v-card-text class="text-center">
            <div>
              <h1>ANALYSE</h1>
            </div>
            <v-text-field
              ref="url"
              :rules="[rules.required, rules.validGithubUrl]"
              label="Repository GitHub"
              placeholder="Saisissez une URL"
              required
              class="custom-background elevation-5"
            ></v-text-field>
            <v-select
              v-model="selectTools"
              clearable
              multiple
              chips
              :rules="[v => !!v || 'Veuillez sélectionner un outil !!']"
              label="Outils d'analyse"
              placeholder="Sélectionner un outil d'analyse"
              :items="tools"
              item-title="toolType"
              item-value="toolName"
              return-object
              required
              class="custom-background"
            >
            </v-select>
          
        </v-card-text>
        <v-card-actions class="justify-center mb-8">
          <v-btn
              rounded="lg"
              color="primary"
              style="background-color: white"
              variant="text"
              :disabled="!formValid"
              @click="submit"
              :loading="loading" 
          >
            Analyser
          </v-btn>

          <v-btn
              style="color: white"
              rounded="lg"
              variant="text"
              @click="resetForm">
              Annuler
          </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data () {
    return {
      formValid: false,
      rules: {
        required: value => !!value || 'Ce champ est requis !!',
      validGithubUrl: value => {
        const githubUrlRegex = /^https:\/\/github\.com\/[a-zA-Z0-9_-]+\/[a-zA-Z0-9_-]/;
        return githubUrlRegex.test(value) || 'Veuillez saisir une URL GitHub valide.';
      },
      },
      selectTools: [],
      tools: [
        { toolName: 'PHP_CodeSniffer', toolType: 'Détection des erreurs' },
        { toolName: 'php-reaper', toolType: 'Détection des Injections' },
        { toolName: 'phpmnd', toolType: 'Détection de nombres magiques' },
        { toolName: 'PhpDepreciationDetector', toolType: 'Détection des fonctions dépréciées' },
        { toolName: 'phpMetrics', toolType: 'Dashboard' }
      ],

      loading: false,
    }
  },

  computed: {
    form() {
      return {
        url: this.url,
      };
    },
  },

  methods: {
    resetForm() {
      this.$refs.url.value = '';
      
    },
  },


};
</script>

<style scoped>
/* Styles spécifiques au composant */
#urlForm{
  background-color: #022037;
  margin-top: 80px;
  border-radius: 20px;
  padding: 5px;
}

.custom-background{
  background-color: white;
  margin-bottom: 20px;
  border-radius: 10px;
  padding: 5px;
  width: 60%;
  margin-left: 20%;
}

body {
  overflow-y: hidden;
  background-color: white;
}

h1 {
  padding: 20px; 
  margin-top: 20px;
  margin-bottom: 20px; 
  color: white; 
}

v-btn{
  border-radius: 60px;
}
</style>