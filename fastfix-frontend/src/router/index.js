import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AboutView from '../views/AboutView.vue'

import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import ForgotPasswordView from '../views/ForgotPasswordView.vue'
import ResetPasswordView from '../views/ResetPasswordView.vue'
import VerifyEmailView from '../views/VerifyEmailView.vue'
import ConfirmPasswordView from '../views/ConfirmPasswordView.vue'
import TwoFactorChallengeView from '../views/TwoFactorChallengeView.vue'

const routes = [
  { path: '/', name: 'home', component: HomeView },
  { path: '/about', name: 'about', component: AboutView },

  // Fortify-style Auth routes
  { path: '/login', name: 'login', component: LoginView },
  { path: '/register', name: 'register', component: RegisterView },
  { path: '/forgot-password', name: 'forgot-password', component: ForgotPasswordView },
  { path: '/reset-password/:token', name: 'reset-password', component: ResetPasswordView, props: true },
  { path: '/email/verify/:id/:hash', name: 'verify-email', component: VerifyEmailView, props: true },
  { path: '/confirm-password', name: 'confirm-password', component: ConfirmPasswordView },
  { path: '/two-factor-challenge', name: 'two-factor-challenge', component: TwoFactorChallengeView },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
