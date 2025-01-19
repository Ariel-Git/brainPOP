import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Feature from '../views/Feature.vue'

import { useUserStore } from '@/stores/user'
import SummaryScreen from '@/components/screens/features/quiz/summaryScreen/SummaryScreen.vue'

const isLoggedIn = () => {
  const store = useUserStore()
  return store.isLoggedIn
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      redirect: () => {
        if (isLoggedIn()) {
          return '/feature/quiz'
        } else {
          return '/login'
        }
      }
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/feature/:type?',
      name: 'feature',
      component: Feature,
      meta: { requiresAuth: true }
    },
    {
      path: '/summary',
      component: SummaryScreen,
      props: (route) => ({
        correct: parseInt(route.query.correct),
        total: parseInt(route.query.total),
        answers: JSON.parse(route.query.answers),
      }),
    }

  ]
})

router.beforeEach(to => {
  // BLOCK LOGIN FOR LOGGED IN USERS
  if (to.name === 'login' && isLoggedIn()) {
    return '/'
  }

  // REDIRECT TO LOGIN IF NOT LOGGED IN AND PAGE AUTH REQUIRED
  if (to.meta?.requiresAuth && !isLoggedIn()) {
    return '/login'
  }
})

export default router
