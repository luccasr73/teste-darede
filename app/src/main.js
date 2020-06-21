import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import VueRouter from 'vue-router'
import routes from './routes'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate)
Vue.use(VueRouter)
const router = new VueRouter({
  mode: 'history',
  routes
})

Vue.config.productionTip = false
new Vue({
  vuetify,
  render: h => h(App),
  router
}).$mount('#app')
