<!-- src/components/Form.vue -->

<template>
  <v-row justify="center">
    <v-col
        cols="12"
        sm="10"
        md="8"
        lg="6"
    >
      <v-card ref="form" id="formInscription">
          <v-card-text class="text-center">
            <div>
              <h1 style="padding: 20px; margin-bottom: 20px">INSCRIPTION</h1>
            </div>

          <v-text-field
              ref="username"
              :rules="[v => !!v || 'Ce champ est requis !!']"
              :error-messages="errorMessages"
              label="Nom d'utilisateur"
              placeholder="Entrez votre nom d'utilisateur"
              required
              class="custom-background"></v-text-field>
            <v-text-field
                ref="mail"
                :rules="[v => !!v || 'Ce champ est requis !!', (v) => /.+@.+\..+/.test(v) || 'Le Mail doit etre valide !']"
                :error-messages="errorMessages"
                label="E-mail"
                placeholder="Entrez votre e-mail"
                required
                class="custom-background"
            ></v-text-field>
            <v-text-field
                ref="verifmail"
                :rules="[v => !!v || 'Ce champ est requis !!', (v) => /.+@.+\..+/.test(v) || 'Le mail doit etre le meme que celui au-dessus']"
                :error-messages="errorMessages"
                label="Verification E-mail"
                placeholder="Entrez votre E-mail"
                required
                class="custom-background"
            ></v-text-field>
            <v-text-field
                ref="password"
                :rules="[v => !!v || 'Un mot de passe est requis !', (v) => (v && v.length >= 8) || 'Le mot de passe doit avoir au moins 8 caractères !']"
                :error-messages="errorMessages"
                label="Mot de passe"
                placeholder="Entrez votre mot de passe"
                required
                type="password"
                class="custom-background"
            ></v-text-field>
        </v-card-text>
        <v-divider class="mt-1"></v-divider>
        <v-card-actions class="justify-center mb-5">
          <v-btn
              rounded="lg"
              @click="resetForm"
              variant="text">
            Cancel
          </v-btn>

          <v-btn
              rounded="lg"
              color="primary"
              style="background-color: white"
              variant="text"
              @click="submit"
          >
            S'inscrire
          </v-btn>
        </v-card-actions>
        <v-input__details v-if="!formHasErrors"></v-input__details>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
//import {Field} from "vee-validate";
export default {
  //components: {Field},

  computed: {
    form () {
      return {
        name: this.name,
        mail: this.mail,
        password: this.password,
      }
    },
  },

  methods: {

    resetForm() {
      this.$refs.username.value = '';
      this.$refs.mail.value = '';
      this.$refs.verifmail.value = '';
      this.$refs.password.value = '';
      this.errorMessages = '';
      this.formHasErrors = false;
    },
    submit() {
      console.log(this.$refs.username.value);
      this.formHasErrors = false

      Object.keys(this.form).forEach(f => {
        if (!this.form[f]) {
          this.formHasErrors = true
          this.errorMessages += `Hey! ${f.charAt(0).toUpperCase() + f.slice(1)} is required.\n`
        }

      })

      // Nouvelle logique pour supprimer tous les messages d'erreur
      this.errorMessages = ''
    },
  },
}
</script>

<style scoped>
/* Styles spécifiques au composant */
#formInscription{
  background-color: #5480D5;
  margin-top: 50px;
  border-radius: 20px;
  padding: 30px;
}

.custom-background{
  background-color: white;
  margin-bottom: 10px;
  border-radius: 10px;
  width: 60%;
  margin-left: 20%;

}

v-btn{
  border-radius: 60px;
}
</style>