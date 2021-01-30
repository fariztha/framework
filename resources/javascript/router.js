import VueRouter from 'vue-router';
import HomePage from './layouts/dashboard.vue';
import LoginPage from './layouts/login.vue';
import NotFoundPage from './layouts/notfound.vue';

const routes = 
  [
    {
      path: '/login',
      name: 'login',
      component: LoginPage
    },
    {
      path: '/',
      name: 'dashboard',
      component: HomePage
    },    
    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFoundPage },
    // if you omit the last `*`, the `/` character in params will be encoded when resolving or pushing
    { path: '/:pathMatch(.*)', name: 'bad-not-found', component: NotFoundPage },
  ]
        
  const router = VueRouter.createRouter({
      // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
      history: VueRouter.createWebHashHistory(),
      routes, // short for `routes: routes`
  });
              
export default router