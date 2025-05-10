import { createRouter, createWebHistory } from 'vue-router'

// 🟢 Vistas públicas
import DashboardView from '@/views/public/DashboardView.vue'
import AboutView from '@/views/public/AboutUsView.vue'
import ContactUsView from '@/views/public/ContactUsView.vue'
import BudgetRequestView from '@/views/public/BudgetRequestView.vue'
import RepairsView from '@/views/public/RepairsView.vue'

// 🔐 Vistas de autenticación
import LoginView from '@/views/auth/LoginView.vue'
import RegisterView from '@/views/auth/RegisterView.vue'
import ForgotPasswordView from '@/views/auth/ForgotPasswordView.vue'
import ResetPasswordView from '@/views/auth/ResetPasswordView.vue'
import ConfirmPasswordView from '@/views/auth/ConfirmPasswordView.vue'
import VerifyEmailView from '@/views/auth/VerifyEmailView.vue'
import TwoFactorChallengeView from '@/views/auth/TwoFactorChallengeView.vue'

// 👤 Vistas para usuario autenticado
import FavoritesView from '@/views/user/FavoritesView.vue'
import CartView from '@/views/user/CartView.vue'
import OrderHistoryView from '@/views/user/OrderHistoryView.vue'
import GuaranteeView from '@/views/user/GuaranteeView.vue'

// 🛠️ Vistas del panel de administración
import AdminPanelView from '@/views/admin/AdminPanelView.vue'
import ProductCrudView from '@/views/admin/ProductCrudView.vue'
import ProductListView from '@/views/admin/ProductListView.vue'
import OrderListView from '@/views/admin/OrderListView.vue'
import BudgetListView from '@/views/admin/BudgetListView.vue'
import GuaranteeListView from '@/views/admin/GuaranteeListView.vue'

const routes = [
  // 🟢 Públicas
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

  // 🔐 Autenticación
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

  // ✅ Rutas protegidas (requieren token JWT)
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

  { path: '/favorites', name: 'favorites', component: FavoritesView, meta: { requiresAuth: true } },
  { path: '/cart', name: 'cart', component: CartView, meta: { requiresAuth: true } },
  {
    path: '/orders',
    name: 'order-history',
    component: OrderHistoryView,
    meta: { requiresAuth: true },
  },
  { path: '/guarantee', name: 'guarantee', component: GuaranteeView, meta: { requiresAuth: true } },

  // 🛠️ Panel admin (puede usarse requiresAdmin más adelante)
  { path: '/admin', name: 'admin-panel', component: AdminPanelView, meta: { requiresAuth: true } },
  {
    path: '/admin/products',
    name: 'product-crud',
    component: ProductCrudView,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/product-list',
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
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

// ✅ Middleware global para controlar acceso
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  // 🔒 Rutas protegidas sin token → redirigir a login
  if (to.meta.requiresAuth && !token) {
    return next({ name: 'login' })
  }

  // 🚫 Rutas login/register con token → redirigir al dashboard
  if ((to.name === 'login' || to.name === 'register') && token) {
    const isAdmin = localStorage.getItem('role') === 'admin'
    return next({ name: isAdmin ? 'admin-panel' : 'home' })
  }

  // ✅ Permitir navegación
  next()
})

export default router
