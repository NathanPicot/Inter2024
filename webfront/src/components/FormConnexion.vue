<!-- src/components/Form.vue -->
<script>
export default {
  data () {
    return {
      username: '',
      modelPassword: '',
      formValid: false,
      show1: false,
      show2: false,
      password: 'Password',
      rules: {
        required: value => !!value || 'Ce champ est requis !',
        min: v => v.length >= 8 || 'Min 8 characters',
        // verifPassword: v => this.modelPassword.value !== v || 'Les mots de passes doivent être identiques !',
      },
    }
  },
  // created() {
  //   this.rules.verifPassword= v => this.modelPassword.value !== v || 'Les mots de passes doivent être identiques !'
  // },
  computed: {
    form() {
      return {
        name: this.name,
        password: this.password,
      };
    },
  },
  methods: {
    submit() {
      // Vérifiez si le champ username est un e-mail
      const isEmail = /.+@.+\..+/.test(this.username);

      if (isEmail) {
        console.log('Connexion avec l\'e-mail:', this.username);
        // Traitez la connexion par e-mail
      } else {
        console.log('Connexion avec le nom d\'utilisateur:', this.username);
        // Traitez la connexion par nom d'utilisateur
      }

      console.log('Mot de passe:', this.modelPassword);
      console.log('Form Valide:', this.formValid);
    },
  },
};
</script>


<template>
  <v-row justify="center">
    <v-col
        cols="12"
        sm="10"
        md="8"
        lg="6"
    >
      <v-card ref="form" id="formConnexion">
        <v-form v-model="formValid">
          <v-card-text class="text-center">

            <div>
              <h1 style="padding: 20px; margin-bottom: 20px; color: white; margin-top: 20px">CONNEXION</h1>
            </div>
            <v-text-field
                ref="username"
                v-model="username"
                :rules="[v => !!v || 'Ce champ est requis !']"
                label="Nom d'utilisateur ou E-mail"
                placeholder="Entrez votre nom d'utilisateur ou E-mail"
                required
                class="custom-background elevation-5"></v-text-field>
            <v-text-field
                ref="password"
                v-model="modelPassword"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show1 ? 'text' : 'password'"
                name="input-10-1"
                :rules="[rules.required, rules.min]"
                label="Mot de passe"
                placeholder="Entrez votre mot de passe"
                required
                counter
                @click:append="show1 = !show1"
                class="custom-background elevation-5"
            ></v-text-field>
          </v-card-text>
          <v-card-actions class="justify-center mb-8">
            <v-btn
                rounded="lg"
                color="primary"
                style="background-color: white"
                variant="text"
                :disabled="!formValid"
                @click="submit"
            >
              Connexion
            </v-btn>

            <v-btn
                style="color: white"
                rounded="lg"
                to="/FormInscription"
                variant="text">
              S'inscrire
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>



<style scoped>
/* Styles spécifiques au composant */
#formConnexion{
  background-color: #022037;
  margin-top: 80px;
  border-radius: 20px;
  padding: 5px;
}

.custom-background{
  background-color: white;
  //border: solid black 2px;
  margin-bottom: 20px;
  border-radius: 10px;
  padding: 5px;
  width: 60%;
  margin-left: 20%;

}

body {
  overflow-y: hidden;
  background-color: aliceblue;
}

v-btn{
  border-radius: 60px;
}

</style>
