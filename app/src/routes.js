import Cadastro from './components/Cadastro.vue'
import Login from './components/Login.vue'
import Home from './components/Home.vue'
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    beforeEnter (to, from, next) {

    },
    meta: {
      auth: true,
      title: 'Teste Darede - Home'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false,
      title: 'Teste Darede - Login'
    }
  },
  {
    path: '/cadastro',
    name: 'cadastro',
    component: Cadastro,
    meta: {
      auth: false,
      title: 'Teste Darede - Cadastro'
    }
  }
]
export default routes
