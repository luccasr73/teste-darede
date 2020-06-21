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
                <v-text-field label="Email" name="email" v-model="email" prepend-icon="mdi-account" type="email">
                </v-text-field>
                <v-text-field label="Senha" name="password" v-model="password" prepend-icon="mdi-lock" type="password">
                </v-text-field>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" type="submit">Login</v-btn>
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

export default {

  name: 'Login',

  data: () => ({
    email: 'luccasrobert@hotmail.com',
    password: '12345678'
  }),

  methods: {
    async onSubmit () {
      try {
        const data = await signIn(this.email, this.password)
        // this.$router.push('/home')
        console.log(data)
        console.log(process.env.VUE_APP_NOT_SECRET_CODE)
      } catch (error) {
        const data = error.response.data.error
        console.log(data)
      }
    }
  }

}
</script>
