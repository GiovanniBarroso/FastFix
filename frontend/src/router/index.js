import { createRouter, createWebHistory } from 'vue-router'
import api from '@/services/api'

// 🟢 Vistas públicas
import DashboardView from '@/views/public/DashboardView.vue'
import AboutView from '@/views/public/AboutUsView.vue'
import ContactUsView from '@/views/public/ContactUsView.vue'
import BudgetRequestView from '@/views/public/BudgetRequestView.vue'
import RepairsView from '@/views/public/RepairsView.vue'
import ProductsView from '@/views/public/ProductsView.vue'

// 🔐 Autenticación
import LoginView from '@/views/auth/LoginView.vue'
import RegisterView from '@/views/auth/RegisterView.vue'
import ForgotPasswordView from '@/views/auth/ForgotPasswordView.vue'
import ResetPasswordView from '@/views/auth/ResetPasswordView.vue'
import ConfirmPasswordView from '@/views/auth/ConfirmPasswordView.vue'
import VerifyEmailView from '@/views/auth/VerifyEmailView.vue'
import TwoFactorChallengeView from '@/views/auth/TwoFactorChallengeView.vue'

// 👤 Usuario
import FavoritesView from '@/views/user/FavoritesView.vue'
import CartView from '@/views/user/CartView.vue'
import OrderHistoryView from '@/views/user/OrderHistoryView.vue'
import GuaranteeView from '@/views/user/GuaranteeView.vue'
import HomeView from '@/views/user/HomeView.vue'

// 🛠️ Admin
import AdminPanelView from '@/views/admin/AdminPanelView.vue'
import ProductListView from '@/views/admin/ProductListView.vue'
import OrderListView from '@/views/admin/OrderListView.vue'
import BudgetListView from '@/views/admin/BudgetListView.vue'
import GuaranteeListView from '@/views/admin/GuaranteeListView.vue'
import UserListView from '@/views/admin/UserListView.vue'
import RepairListView from '@/views/admin/RepairListView.vue'

const routes = [
  // Públicas
  { path: '/', name: 'home', component: DashboardView, meta: { requiresAuth: false } },
  { path: '/about', name: 'about', component: AboutView, meta: { requiresAuth: false } },
  { path: '/contact', name: 'contact', component: ContactUsView, meta: { requiresAuth: false } },
  {
    path: '/budget',
    name: 'budget-request',
    component: BudgetRequestView,
    meta: { requiresAuth: false },
  },
  { path: '/repairs', name: 'repairs', component: RepairsView, meta: { requiresAuth: false } },
  { path: '/products', name: 'products', component: ProductsView, meta: { requiresAuth: false } },

  // Usuario
  { path: '/home', name: 'user-home', component: HomeView, meta: { requiresAuth: true } },
  { path: '/favorites', name: 'favorites', component: FavoritesView, meta: { requiresAuth: true } },
  { path: '/cart', name: 'cart', component: CartView, meta: { requiresAuth: true } },
  {
    path: '/orders',
    name: 'order-history',
    component: OrderHistoryView,
    meta: { requiresAuth: true },
  },
  { path: '/guarantee', name: 'guarantee', component: GuaranteeView, meta: { requiresAuth: true } },

  // Autenticación
  { path: '/login', name: 'login', component: LoginView, meta: { requiresAuth: false } },
  { path: '/register', name: 'register', component: RegisterView, meta: { requiresAuth: false } },
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

  // Admin
  { path: '/admin', name: 'admin-panel', component: AdminPanelView, meta: { requiresAuth: true } },
  {
    path: '/admin/products',
    name: 'product-list',
    component: ProductListView,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/orders',
    name: 'order-list',
    component: OrderListView,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/budgets',
    name: 'budget-list',
    component: BudgetListView,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/guarantees',
    name: 'guarantee-list',
    component: GuaranteeListView,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/users',
    name: 'users-list',
    component: UserListView,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/repairs',
    name: 'repair-list',
    component: RepairListView,
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

// 🧠 Middleware global
router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token')
  const role = localStorage.getItem('role')

  // 🔒 Protegidas sin token
  if (to.meta.requiresAuth && !token) {
    return next({ name: 'login' })
  }

  // 🔁 Login o register con token → redirige
  if ((to.name === 'login' || to.name === 'register') && token) {
    return next({ name: role === 'admin' ? 'admin-panel' : 'home' })
  }

  // 📧 Si tiene token pero no ha verificado correo
  if (token && to.meta.requiresAuth && to.name !== 'verify-email') {
    try {
      const response = await api.get('/me')
      const isVerified = response.data.user?.email_verified_at !== null

      if (!isVerified) {
        return next({ name: 'verify-email' })
      }
    } catch {
      localStorage.removeItem('token')
      localStorage.removeItem('role')
      return next({ name: 'login' })
    }
  }

  next()
})

export default router
