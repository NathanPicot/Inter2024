<!-- src/components/Form.vue -->

<template>
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
              ref="selection"
              chips
              :rules="[v => !!v || 'Veuillez sélectionner un outil !!',]"
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
          <v-dialog width="500">
            <template v-slot:activator="{ props }">
              <v-btn 
                v-bind="props" 
                rounded="lg"
                variant="text"
                style="background-color: white"
                color="primary"
                :disabled="!formValid"
                @click="submit"
              >Analyser</v-btn>
            </template>

            <template v-slot:default="{ isActive}">
              <v-card title="Télécharger">
                <v-card-text>
                  Vous pouvez télécharger votre rapport
                </v-card-text>
                <v-card-actions>
                  <v-btn

                  >Télécharger</v-btn>
                  <v-btn
                    @click="isActive.value = false"
                  >Fermer</v-btn>
                </v-card-actions>
              </v-card>
            </template>
          </v-dialog>
          <v-btn
              style="color: white"
              rounded="lg"
              variant="text"
              type="reset"
              >
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
    console.log(this)
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
    }
  },

  computed: {
    form() {
      console.log(this.$refs.selection.value, this.$refs.selection)
      return {
        url: this.url,
        selection: this.selection,
      };
    },
  },

  methods: {
  
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