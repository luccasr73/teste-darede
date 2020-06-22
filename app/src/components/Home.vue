<template>
    <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
            <v-card class="mx-auto" outlined :loading="loading">
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="overline mb-4">Email</div>
                        <v-list-item-title class="headline mb-1">{{email}}</v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-avatar tile size="80" color="grey"></v-list-item-avatar>
                </v-list-item>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" :loading="loadingLogout" @click="logout">Sair</v-btn>
                </v-card-actions>
            </v-card>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios'
import {
  API
} from '../../env'
import {
  getUserId, signOut
} from '../services/auth'
export default {
  name: 'Home',
  data: () => ({
    email: '',
    loading: true,
    loadingLogout: false
  }),
  methods: {
    logout () {
      signOut()
      this.$router.push('/login')
    }
  },
  mounted: function () {
    axios.get(API + '/buscar/usuario/id/' + getUserId())
      .then(res => {
        const data = res.data.data
        this.email = data.email
        this.loading = false
      })
    // eslint-disable-next-line handle-callback-err
      .catch(err => {
        this.email = 'Erro ao coletar dados'
      })
  }
}
</script>
