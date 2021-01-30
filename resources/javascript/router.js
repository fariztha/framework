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

  router.beforeEach((to, from, next) => {
    const publicPages = ['/login'];
    const authRequired = publicPages.includes(to.path);
    const loggedIn = window.localStorage.getItem('token'); 
    // login
    if (!authRequired && !loggedIn) {
      console.log('not authorized')
      router.push({ path: 'login' })    
    }else if (authRequired && loggedIn){
      console.log('authorized')
      router.push({ path: 'dashboard' })     
    }else{
      //meta akses
      if (!to.meta.akses){
        next() 
      }else{  
        //var akses = jwt_decode(loggedIn);
        var akses = "superuser";
        if (akses.role == to.meta.akses || akses.role == "superuser" ) {
          console.log('authorized')      
          next()
        } else {
          console.log('not authorized')
          router.push({ path: 'dashboard' })
        }
      }
      //end next()
    }
  });
              
export default router