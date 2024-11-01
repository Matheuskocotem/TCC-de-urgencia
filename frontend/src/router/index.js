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
      component: () => import('../views/VizualiazarReunioes.vue'),
      meta: {
        title: 'VizualiazarReunioes'
      }
    },
    {
      path: '/reunioes',
      name: 'Reunioes',
      component: () => import('../views/reunioes.vue'),
      meta: {
        title: 'Reunioes'
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router
