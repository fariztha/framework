import VueRouter from 'vue';
import router from './router';
/* bootstrap */
import 'popper.js';
import 'bootstrap';
import 'jquery';
/* sass include */
import '../sass/main.scss';

const app = VueRouter.createApp({})

app.use(router)
app.mount('#app')