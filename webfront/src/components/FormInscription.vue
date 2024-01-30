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
              :rules="[v => !!v || 'This field is required']"
              :error-messages="errorMessages"
              label="Username"
              placeholder="Username"
              required
              class="custom-background"></v-text-field>
            <v-text-field
                ref="mail"
                :rules="[v => !!v || 'This field is required', (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid']"
                :error-messages="errorMessages"
                label="E-mail"
                placeholder="Enter your e-mail"
                required
                class="custom-background"
            ></v-text-field>
            <v-text-field
                ref="verifmail"
                :rules="[v => !!v || 'This field is required', (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid']"
                :error-messages="errorMessages"
                label="Verification e-mail"
                placeholder="Enter your e-mail"
                required
                class="custom-background"
            ></v-text-field>
            <v-text-field
                ref="password"
                :rules="[v => !!v || 'Password is required', (v) => (v && v.length >= 8) || 'Password must be at least 8 characters']"
                :error-messages="errorMessages"
                label="Password"
                placeholder="Password"
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
//import {useCounterStore} from '../store/userStore';
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

      /*Object.keys(this.form).forEach((f) => {
        this.form[f] = '';
      });*/
    },

    submit() {
      console.log(this.$refs.username.value);
      this.formHasErrors = false

      //useCounterStore.increment()
      //console.log(useCounterStore.state.count)
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
  //border: solid black 2px;
  margin-bottom: 10px;
  border-radius: 10px;
  width: 60%;
  margin-left: 20%;

}

v-btn{
  border-radius: 60px;
}
</style>
