import VueRouter from 'vue';
import router from './router';

const app = VueRouter.createApp({})

app.use(router)
app.mount('#app')