import { createRouter, createWebHistory } from 'vue-router'

// Vistas protegidas
import DashboardView from '@/views/DashboardView.vue'

// Vistas públicas
import HomeView from '@/views/HomeView.vue'
import AboutView from '@/views/AboutView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ForgotPasswordView from '@/views/ForgotPasswordView.vue'
import ResetPasswordView from '@/views/ResetPasswordView.vue'
import ConfirmPasswordView from '@/views/ConfirmPasswordView.vue'
import VerifyEmailView from '@/views/VerifyEmailView.vue'
import TwoFactorChallengeView from '@/views/TwoFactorChallengeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { requiresAuth: false },
  },
  {
    path: '/about',
    name: 'about',
    component: AboutView,
    meta: { requiresAuth: false },
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: { requiresAuth: false },
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    meta: { requiresAuth: false },
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: ForgotPasswordView,
    meta: { requiresAuth: false },
  },
  {
    path: '/reset-password',
    name: 'reset-password',
    component: ResetPasswordView,
    meta: { requiresAuth: false },
  },
  {
    path: '/confirm-password',
    name: 'confirm-password',
    component: ConfirmPasswordView,
    meta: { requiresAuth: true },
  },
  {
    path: '/verify-email',
    name: 'verify-email',
    component: VerifyEmailView,
    meta: { requiresAuth: true },
  },
  {
    path: '/two-factor-challenge',
    name: 'two-factor-challenge',
    component: TwoFactorChallengeView,
    meta: { requiresAuth: true },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView,
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  // 🔐 Si la ruta requiere login y no hay token, redirige a login
  if (to.meta.requiresAuth && !token) {
    return next({ name: 'login' })
  }

  // 🚫 Si ya hay token y vas a login/register, redirige al dashboard
  if ((to.name === 'login' || to.name === 'register') && token) {
    return next({ name: 'dashboard' })
  }

  next()
})

export default router
