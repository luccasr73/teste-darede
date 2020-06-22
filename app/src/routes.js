import Cadastro from './components/Cadastro.vue'
import Login from './components/Login.vue'
import Home from './components/Home.vue'
import { isSignedIn } from './services/auth'
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    beforeEnter (_, __, next) {
      if (isSignedIn()) {
        next()
        return
      }
      next('/login')
    },
    meta: {
      title: 'Home - Teste Darede'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    beforeEnter (_, __, next) { // Impede usuários não assinados
      if (!isSignedIn()) { // de acessar a página Home.
        next()
        return
      }
      next('/')
    },
    meta: {
      title: 'Login - Teste Darede'
    }
  },
  {
    path: '/cadastro',
    name: 'cadastro',
    component: Cadastro,
    beforeEnter (_, __, next) { // Impede usuários não assinados
      if (!isSignedIn()) { // de acessar a página Home.
        next()
        return
      }
      next('/')
    },
    meta: {
      title: 'Cadastro - Teste Darede'
    }
  }
]
export default routes
