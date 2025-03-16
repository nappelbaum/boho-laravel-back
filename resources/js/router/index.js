import { createRouter, createWebHistory } from 'vue-router'
import { getCookie } from '../utils/useCookie'
import { useUser } from '../stores/user'

const routes = [
  {
    path: '/',
    name: 'home.index',
    component: () => import('../pages/HomePage.vue'),
    meta: { title: 'Home' }
  },
  {
    path: '/fruits',
    name: 'fruit.index',
    component: () => import('../pages/FruitsList.vue'),
    meta: { title: 'Fruits' }
  },
  {
    path: '/users/login',
    name: 'user.login',
    component: () => import('../components/User/UserLogin.vue'),
    meta: { title: 'User.login' }
  },
  {
    path: '/users/signup',
    name: 'user.signup',
    component: () => import('../components/User/UserSignup.vue'),
    meta: { title: 'User.signup' }
  },
  {
    path: '/users/personal',
    name: 'user.personal',
    component: () => import('../components/User/UserPersonal.vue'),
    meta: { title: 'User.personal' }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const token = getCookie('access_token')
  const user = useUser()

  if (token) {
    if (to.name === 'user.login' || to.name === 'user.signup') {
      return next({ name: 'user.personal' })
    }

    if (to.name === 'user.personal') {
      window.location.replace('/admin')
    }
  }

  if (!token) {
    if (to.name === 'fruit.index' || to.name === 'user.personal') {
      return next({ name: 'user.login' })
    }
    if (user.isAuth) user.logout()
  }

  document.title = to.meta.title
  next()
})

export default router
