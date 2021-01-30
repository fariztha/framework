import VueRouter from 'vue';
import router from './router';
/* sass include */
import '../sass/main.scss';

const app = VueRouter.createApp({})

app.use(router)
app.mount('#app')