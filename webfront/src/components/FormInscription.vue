<!-- src/components/Form.vue -->
<script>
import { useFormStore } from '@/stores/formStore';
import axios from "axios";
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
<<<<<<< HEAD
=======

>>>>>>> e4f0182f2f45a0dcf773045701b4ebc43c621a1d
   async submit() {
    if (this.$refs.password.value !== this.$refs.verifPassword.value) {
        return;
    } else {
        try {
            const formData = {
                username: this.username,
                mail: this.mail,
                password: this.modelPassword,
                verifPassword: this.modelVerifPassword
            };

            const register = await axios.post("register", formData);
            
            if (register.data.error_messages) {
                console.log(register.data.error_messages['danger']);
            }
        } catch (error) {
            console.log("Caught an error during registration:", error);
        }
        
        // Additional logic after successful registration
        useFormStore().logUsername(this.username);
        console.log(this.formValid);
    }
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
              <h1 style="padding: 20px; margin-bottom: 20px; color: white; margin-top: 20px">INSCRIPTION</h1>
            </div>
            <v-text-field
              ref="username"
              v-model="username"
              :rules="[v => !!v || 'Ce champ est requis !!']"
              label="Nom d'utilisateur"
              placeholder="Entrez votre nom d'utilisateur"
              required
              class="custom-background elevation-5"></v-text-field>
            <v-text-field
                ref="mail"
                v-model="mail"
                :rules="[v => !!v || 'Ce champ est requis !!', (v) => /.+@.+\..+/.test(v) || 'Le Mail doit etre valide !']"
                label="E-mail"
                placeholder="Entrez votre e-mail"
                required
                class="custom-background elevation-5"
            ></v-text-field>
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
            S'inscrire
          </v-btn>

          <v-btn
              style="color: white"
              rounded="lg"
              to="/"
              variant="text">
            Se connecter
          </v-btn>

<!--          <v-btn-->
<!--              style="color: white"-->
<!--              rounded="lg"-->
<!--              to="/FormChangeInfos"-->
<!--              variant="text">-->
<!--            MODIFIER INFOS-->
<!--          </v-btn>-->
        </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>



<style scoped>
/* Styles spécifiques au composant */
#formInscription{
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
  background-color: aliceblue;
}

v-btn{
  border-radius: 60px;
}
</style>