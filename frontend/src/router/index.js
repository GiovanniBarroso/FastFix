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
import ProfileView from '@/views/auth/ProfileView.vue'
import ChangePasswordView from '@/views/auth/ChangePasswordView.vue'
import ForbiddenView from '@/views/errors/ForbiddenView.vue'

// 👤 Usuario
import UserPanelView from '@/views/user/UserPanelView.vue'
import OrderHistoryView from '@/views/user/OrderHistoryView.vue'
import FavoritesView from '@/views/user/FavoritesView.vue'
import RepairsUserView from '@/views/user/RepairsView.vue'
import AddressView from '@/views/user/AddressView.vue'
import BudgetsView from '@/views/user/BudgetsView.vue'
import InvoicesView from '@/views/user/InvoicesView.vue'
import CartView from '@/views/user/CartView.vue'

// 🛠️ Admin
import AdminPanelView from '@/views/admin/AdminPanelView.vue'
import ProductListView from '@/views/admin/ProductListView.vue'
import OrderListView from '@/views/admin/OrderListView.vue'
import BudgetListView from '@/views/admin/BudgetListView.vue'
import UserListView from '@/views/admin/UserListView.vue'
import RepairListView from '@/views/admin/RepairListView.vue'
import AdminCalendarView from '@/views/admin/AdminCalendarView.vue'
import AdminNotificationCenter from '@/views/admin/AdminNotificationCenter.vue'

// 💰 Pasarela de pago
import CheckoutConfirmView from '@/views/checkout/CheckoutConfirm.vue'
import CheckoutSuccess from '@/views/checkout/CheckoutSuccess.vue'
import CheckoutError from '@/views/checkout/CheckoutError.vue'
import CheckoutCancel from '@/views/checkout/CheckoutCancel.vue'

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

  // Usuario autenticado
  {
    path: '/user-panel',
    name: 'user-panel',
    component: UserPanelView,
    meta: { requiresAuth: true },
  },
  {
    path: '/user/orders',
    name: 'user-orders',
    component: OrderHistoryView,
    meta: { requiresAuth: true },
  },
  {
    path: '/user/favorites',
    name: 'user-favorites',
    component: FavoritesView,
    meta: { requiresAuth: true },
  },
  {
    path: '/user/repairs',
    name: 'user-repairs',
    component: RepairsUserView,
    meta: { requiresAuth: true },
  },
  {
    path: '/user/address',
    name: 'user-address',
    component: AddressView,
    meta: { requiresAuth: true },
  },
  {
    path: '/user/budgets',
    name: 'user-budgets',
    component: BudgetsView,
    meta: { requiresAuth: true },
  },
  {
    path: '/user/invoices',
    name: 'user-invoices',
    component: InvoicesView,
    meta: { requiresAuth: true },
  },
  { path: '/cart', name: 'cart', component: CartView, meta: { requiresAuth: true } },

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
    path: '/checkout-confirm',
    name: 'CheckoutConfirm',
    component: CheckoutConfirmView,
    meta: { requiresAuth: true },
  },
  {
    path: '/checkout/success',
    name: 'CheckoutSuccess',
    component: CheckoutSuccess,
    meta: { requiresAuth: true },
  },
  {
    path: '/checkout/error',
    name: 'CheckoutError',
    component: CheckoutError,
    meta: { requiresAuth: true },
  },
  {
    path: '/checkout/cancel',
    name: 'CheckoutCancel',
    component: CheckoutCancel,
    meta: { requiresAuth: true },
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
    meta: { requiresAuth: false },
  },
  { path: '/profile', name: 'profile', component: ProfileView, meta: { requiresAuth: true } },
  {
    path: '/change-password',
    name: 'change-password',
    component: ChangePasswordView,
    meta: { requiresAuth: true },
  },
  {
  path: '/forbidden',
  name: 'forbidden',
  component: ForbiddenView,
  meta: { requiresAuth: true }
},


  {
  path: '/admin',
  name: 'admin-panel',
  component: AdminPanelView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/products',
  name: 'product-list',
  component: ProductListView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/orders',
  name: 'order-list',
  component: OrderListView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/budgets',
  name: 'budget-list',
  component: BudgetListView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/users',
  name: 'users-list',
  component: UserListView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/repairs',
  name: 'repair-list',
  component: RepairListView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/calendar',
  name: 'admin-calendar',
  component: AdminCalendarView,
  meta: { requiresAuth: true, requiresAdmin: true }
},
{
  path: '/admin/notifications',
  name: 'admin-notifications',
  component: AdminNotificationCenter,
  meta: { requiresAuth: true, requiresAdmin: true }
},
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

// 🧠 Middleware global
router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    return next({ name: 'login' })
  }

  // Ya autenticado
  if (token && to.meta.requiresAuth) {
    try {
      const res = await api.get('/me')
      const user = res.data.user
      const isVerified = user?.email_verified_at !== null
      const userRole = user?.role?.nombre

      // Redirigir a verificación si no está verificado
      if (!isVerified && to.name !== 'verify-email') {
        return next({ name: 'verify-email' })
      }

      // ❌ Bloquear acceso a /admin si no es admin
      if (to.path.startsWith('/admin') && userRole !== 'admin') {
        return next({ name: 'forbidden' })
      }

      // ✅ Todo OK
      return next()
    } catch {
      localStorage.removeItem('token')
      localStorage.removeItem('role')
      return next({ name: 'login' })
    }
  }

  // Usuario autenticado intenta entrar a login/register → redirigir
  if ((to.name === 'login' || to.name === 'register') && token) {
    const res = await api.get('/me')
    const userRole = res.data.user?.role?.nombre
    return next({ name: userRole === 'admin' ? 'admin-panel' : 'user-panel' })
  }

  return next()
})



export default router
