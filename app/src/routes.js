import Cadastro from './components/Cadastro.vue'
import Login from './components/Login.vue'
import Home from './components/Home.vue'
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/cadastro',
    name: 'cadastro',
    component: Cadastro
  }
]
export default routes
