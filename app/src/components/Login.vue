<template>
  <v-main>
    <v-container class="fill-height" fluid>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
          <v-card class="elevation-12">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>Teste Darede - Login</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-form @submit.prevent="onSubmit()">
                <v-text-field label="Email" name="email" v-model="email" prepend-icon="mdi-account" type="email"  @input="$v.email.$touch()" @blur="$v.email.$touch()" :error-messages="emailErrors" required>
                </v-text-field>
                <v-text-field label="Senha" name="password" v-model="password" prepend-icon="mdi-lock" type="password" :error-messages="passwordErrors" @input="$v.password.$touch()" @blur="$v.password.$touch()" required>
                </v-text-field>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" type="submit" :loading="loginLoading">Login</v-btn>
                </v-card-actions>
                <div class="text-center text-subtitle-1 mt-3">
                  <router-link to="/cadastro" class="grey--text">Não possui cadastro ainda? Clique aqui!</router-link>
                </div>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import {
  signIn
} from '../services/auth'
// import { validationMixin } from 'vuelidate'
import { required, minLength, email } from 'vuelidate/lib/validators'
export default {

  name: 'Login',
  // mixins: [validationMixin],
  validations: {
    email: {
      required,
      email
    },
    password: {
      required,
      minLength: minLength(8)
    }
  },
  data: () => ({
    email: 'luccasrobert@hotmail.com',
    password: '123456789',
    loginLoading: false
  }),
  computed: {
    passwordErrors () {
      const errors = []
      if (!this.$v.password.$dirty) {
        return errors
      }
      !this.$v.password.minLength && errors.push('A senha precisa ter ao menos 8 caractares!')
      !this.$v.password.required && errors.push('Você precisa digitar a sua senha!')
      return errors
    },
    emailErrors () {
      const errors = []
      if (!this.$v.email.$dirty) {
        return errors
      }
      !this.$v.email.email && errors.push('Digite um email valido!')
      !this.$v.email.required && errors.push('Você precisa digitar o seu email!')
      return errors
    }
  },
  methods: {
    async onSubmit () {
      this.loginLoading = true
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.loginLoading = false
        return
      }
      try {
        const data = await signIn(this.email, this.password)
        this.loginLoading = false
        // this.$router.push('/')
        console.log(data)
        console.log(process.env.VUE_APP_NOT_SECRET_CODE)
      } catch (error) {
        this.loginLoading = false
        const data = error.response.data.error
        // const errors = []
        // errors.push(data)
        // this.passwordErrors = errors
        console.log(data)
      }
    }
  }

}
</script>
