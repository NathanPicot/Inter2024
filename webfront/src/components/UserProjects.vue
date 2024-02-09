<!-- src/components/Form.vue -->

<template>
  <v-row justify="center">
    <v-col
        cols="12"
        xs="6"
        sm="10"
        md="8"
        lg="10"
        xl="8"
    >
      <v-card id="projects">
          <v-card-text class="text-center">
            <div>
              <h1>MES PROJETS</h1>
            </div>

            <!-- Intégrer bouton pour tout ouvrir et tout fermer? -->
      
            <v-expansion-panels
              class="custom-background"
            >
              <v-expansion-panel>
              <v-expansion-panel-title>
                Projet 
              </v-expansion-panel-title>
              <v-expansion-panel-text>
                  <v-data-table
                  v-if="showTable" 
                  :headers="headers"
                  :items="links"
                  item-key="name"
                ><template v-slot:[`item.actions`]="{ item }">
                  <v-icon
                    @click="deleteItem(item)"
                    icon="mdi-delete"
                  ></v-icon>
                </template>
              </v-data-table>
              </v-expansion-panel-text>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-card-text>
        <v-card-actions class="justify-center mb-8">
          <v-btn
              rounded="lg"
              color="primary"
              style="background-color: white"
              variant="text"
              to="/Accueil">
            Retour
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data () {
    return {
      showTable: true,
      headers: [
          {
            text: 'links',
            align: 'start',
            value: 'name',
            groupable: false,
          },
          { text: 'Category', value: 'category', align: 'right' },
          { text: 'Actions', value: 'actions', sortable: false}
         
        ],
        links: [
          {
            name: 'Lien 1',
            category: '22/02/24',
          },
          {
            name: 'Lien 2',
            category: '01/03/24',
          },
        ], 
    }
  },

  methods: {
    deleteItem(item) {
      const index = this.links.indexOf(item);

      if (index !== -1) {
        this.links.splice(index, 1);
      }
    },
  },
};
</script>

<style scoped>
/* Styles spécifiques au composant */
#projects{
  background-color: #022037;
  margin-top: 80px;
  border-radius: 20px;
  padding: 5px;
}

.custom-background{
  margin-bottom: 20px;
  border-radius: 10px;
  padding: 5px;
  width: 80%;
  margin: auto;
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