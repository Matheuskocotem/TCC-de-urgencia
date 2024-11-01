import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/login.vue'),
      meta: {
        title: 'login'
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Register.vue'),
      meta: {
        title: 'register'
      }
    },
    {
      path: '/salas',
      name: 'salas',
      component: () => import('../views/EscolherSala.vue'),
      meta: {
        title: 'salas'
      }
    },
    {
      path: '/',
      name: 'VizualiazarReunioes',
      component: () => import('../views/reunioes.vue'),
      meta: {
        title: 'caleendario'
      }
    },
    {
      path: '/reunioes',
      name: 'Reunioes',
      component: () => import('../views/VizualiazarReunioes.vue'),
      meta: {
        title: 'VizualiazarReunioes'
      }
    },
    {
      path: '/admin',
      name: 'admin',
      component: () => import('../views/AdminDashboard.vue'),
      meta: {
        title: 'admin'
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router
