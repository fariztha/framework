import Vue from 'vue';
import VueRouter from 'vue-router';
import HomePage from './layouts/dashboard.vue';
import LoginPage from './layouts/login.vue';
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
          component: require('./pages/dashboard/index.vue').default,
          name: 'dashboard',
        },
        {
          path: 'dashboard/subindex',      
          component: require('./pages/dashboard/subindex.vue').default,
          name: 'subindex',          
        }      
      ]
    },
    { path: "*", component: NotFoundPage  }
    ]
    
    const router = new VueRouter({ routes });
    
    router.beforeEach((to, from, next) => {
      // redirect to login page if not logged in and trying to access a restricted page
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
            console.log("gak ada akses");
        //   var akses = jwt_decode(loggedIn);              
        //   if (akses.role == to.meta.akses || akses.role == "superuser" ) {
        //     console.log('authorized')      
        //     next()
        //   } else {           
        //     console.log('not authorized')
        //     router.push({ path: 'dashboard' })
        //   }
        }
        //end next()
      }
      
    })
    
    
    export default router