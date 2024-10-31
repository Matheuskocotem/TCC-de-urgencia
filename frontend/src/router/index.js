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
      name: 'home',
      component: () => import('../views/Home.vue'),
      meta: {
        title: 'home'
      }
    },
    {
      path: '/reunioes',
      name: 'reunioes',
      component: () => import('../views/reunioes.vue'),
      meta: {
        title: 'salreunioesas'
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router
