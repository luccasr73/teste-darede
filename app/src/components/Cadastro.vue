
<template>
  <v-main>
    <v-container class="fill-height" fluid>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
          <v-card class="elevation-12">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>Teste Darede - Cadastro</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-form @submit.prevent="onSubmit()" ref="form">
                <v-text-field label="Email" name="email" v-model="email" prepend-icon="mdi-account" type="email" @input="validateEmail()" @blur="validateEmail()" :error-messages="emailErrors" :rules="errors.email">
                </v-text-field>
                <v-text-field label="Senha" name="password" v-model="password" prepend-icon="mdi-lock" type="password" @input="validatePass()" @blur="validatePass()" :error-messages="passwordErrors" :rules="errors.password" >
                </v-text-field>
                <v-text-field label="Confirmar senha" name="confirm_password" v-model="confirm_password" prepend-icon="mdi-lock" type="password" @input="validateConfirmPassword()" @blur="validateConfirmPassword()" :error-messages="confirmPasswordErrors" :rules="errors.confirmPassword">
                </v-text-field>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" type="submit" :loading="createLoading">Cadastrar</v-btn>
                </v-card-actions>
                <div class="text-center text-subtitle-1 mt-3">
                  <router-link to="/login" class="grey--text">Já possui cadastro? Clique aqui!</router-link>
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
/* eslint-disable no-prototype-builtins */
import {
  signUp
} from '../services/auth'
import { validationMixin } from 'vuelidate'
import { required, minLength, email, sameAs } from 'vuelidate/lib/validators'
export default {

  name: 'Cadastro',
  mixins: [validationMixin],
  validations: {
    email: {
      required,
      email
    },
    password: {
      required,
      minLength: minLength(8)
    },
    confirm_password: {
      sameAsPassword: sameAs('password')
    }
  },
  data: () => ({
    email: 'luccasrobert@hotmail.com',
    password: '12345678',
    confirm_password: '12345678',
    errors: { password: [], email: [], confirm_password: [] },
    createLoading: false
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
    },
    confirmPasswordErrors () {
      const errors = []
      if (!this.$v.confirm_password.$dirty) {
        return errors
      }
      !this.$v.confirm_password.sameAsPassword && errors.push('As senhas não são iguais!')
      return errors
    }
  },
  methods: {
    async validatePass () {
      this.$v.password.$touch()
      this.errors.password = []
    },
    async validateEmail () {
      this.$v.email.$touch()
      this.errors.email = []
    },
    async validateConfirmPassword () {
      this.$v.confirm_password.$touch()
      this.errors.confirm_password = []
    },
    async onSubmit () {
      this.createLoading = true
      this.$v.$touch()
      this.$refs.form.validate()
      if (this.$v.$invalid) {
        this.createLoading = false
        return
      }
      try {
        const data = await signUp(this.email, this.password, this.confirm_password)
        this.$router.push('/login')
        console.log(data)
        this.createLoading = false
      } catch (error) {
        this.createLoading = false
        const data = error.response.data.error
        if (data.hasOwnProperty('commom')) {
          this.errors.password = [data.commom]
          this.errors.email = [data.commom]
        }
        if (data.hasOwnProperty('email')) {
          this.errors.email = [data.email[0]]
        }
        if (data.hasOwnProperty('password')) {
          this.errors.password = [data.password[0]]
        }
        if (data.hasOwnProperty('confirm_password')) {
          this.errors.password = [data.confirm_password[0]]
        }
      }
    }
  }

}
</script>
