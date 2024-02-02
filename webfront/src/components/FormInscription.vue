<!-- src/components/Form.vue -->
<script>
export default {
  data () {
    return {
      username: '',
      mail: '',
      modelPassword: '',
      modelVerifPassword: '',
      formValid: false,
      show1: false,
      show2: false,
      password: 'Password',
      rules: {
        required: value => !!value || 'Required.',
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
        mail: this.mail,
        password: this.password,
        verifPassword: this.verifPassword,
      };
    },
  },
  methods: {
    validatePasswordMatch() {
      return this.modelPassword === this.modelVerifPassword || 'Les mots de passe doivent être identiques !';
    },
    resetForm() {
      this.$refs.username.value = '';
      this.$refs.mail.value = '';
      this.$refs.password.value = '';
      this.$refs.verifPassword.value = '';
    },
    submit() {
      if (this.$refs.password.value !== this.$refs.verifPassword.value) {
        return
      }
      else {
        console.log(this.formValid)
      }
    },
    isFormValid() {
      return Object.keys(this.form).every(f => !!this.form[f]);
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
      <v-card ref="form" id="formInscription">
        <v-form v-model="formValid">
          <v-card-text class="text-center">

            <div>
              <h1 style="padding: 20px; margin-bottom: 20px">INSCRIPTION</h1>
            </div>
            <v-text-field
              ref="username"
              v-model="username"
              :rules="[v => !!v || 'Ce champ est requis !!']"
              label="Nom d'utilisateur"
              placeholder="Entrez votre nom d'utilisateur"
              required
              class="custom-background"></v-text-field>
            <v-text-field
                ref="mail"
                v-model="mail"
                :rules="[v => !!v || 'Ce champ est requis !!', (v) => /.+@.+\..+/.test(v) || 'Le Mail doit etre valide !']"
                label="E-mail"
                placeholder="Entrez votre e-mail"
                required
                class="custom-background"
            ></v-text-field>
            <v-text-field
                ref="password"
                v-model="modelPassword"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show1 ? 'text' : 'password'"
                name="input-10-1"
                :rules="[v => !!v || 'Un mot de passe est requis !', (v) => (v && v.length >= 8) || 'Le mot de passe doit avoir au moins 8 caractères !',rules.required, rules.min]"
                label="Mot de passe"
                placeholder="Entrez votre mot de passe"
                required
                counter
                @click:append="show1 = !show1"
                class="custom-background"
            ></v-text-field>
            <v-text-field
                ref="verifPassword"
                v-model="modelVerifPassword"
                :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[validatePasswordMatch]"
                label="Verification mot de passe"
                placeholder="Entrez votre mot de passe"
                required
                :type="show2 ? 'text' : 'password'"
                counter
                @click:append="show2 = !show2"
                class="custom-background"
            ></v-text-field>
        </v-card-text>
        <v-divider class="mt-1"></v-divider>
        <v-card-actions class="justify-center mb-5">
          <v-btn
              rounded="lg"
              @click="resetForm"
              variant="text">
            Annuler
          </v-btn>

          <v-btn
              rounded="lg"
              color="primary"
              style="background-color: white"
              variant="text"
              :disabled="!formValid"
              @click="submit"
          >
            S'inscrire
          </v-btn>
          <!-- Utilisation de v-if pour conditionner l'affichage sur l'erreur -->


        </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>



<style scoped>
/* Styles spécifiques au composant */
#formInscription{
  background-color: #5480D5;
  margin-top: 50px;
  border-radius: 20px;
  padding: 5px;
}

.custom-background{
  background-color: white;
  //border: solid black 2px;
  margin-bottom: 10px;
  border-radius: 10px;
  padding: 5px;
  width: 60%;
  margin-left: 20%;

}

v-btn{
  border-radius: 60px;
}

.error-text {
  width: 100%;
  color: red;
  margin-top: 40px;
  background-color: chartreuse;
}
</style>
