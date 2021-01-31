import VueRouter from 'vue-router';
import LoginPage from './layouts/login.vue';
import HomePage from './layouts/dashboard.vue';
import DashboardPage from './pages/dashboard';
import DashboardSubIndexPage from './pages/dashboard/subindex';
import NotFoundPage from './layouts/notfound.vue';

const routes = [
    {
      path: '/login',
      name: 'login',
      component: LoginPage
    },
    { path: '/', redirect: { name: 'dashboard' } },
    {
      path: '/',  
      component: HomePage,
      children:[
        {
          path: 'dashboard',      
          component: DashboardPage,
          name: 'dashboard',
        },
        {
          path: 'dashboard/subindex',      
          component: DashboardSubIndexPage,
          name: 'subindex',
        },
      ]
    },    
    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFoundPage },
    // if you omit the last `*`, the `/` character in params will be encoded when resolving or pushing
    { path: '/:pathMatch(.*)', name: 'bad-not-found', component: NotFoundPage },
  ];
        
  const router = VueRouter.createRouter({
      // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
      history: VueRouter.createWebHashHistory(),
      routes, // short for `routes: routes`
  });
              
export default router