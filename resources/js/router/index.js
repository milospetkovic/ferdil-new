import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue')
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login.vue'),
    },
    {
        path: '/customer',
        name: 'Customer',
        component: () => import('../views/Customer.vue'),
    },
    {
        path: '/customers/list',
        name: 'Customers list',
        component: () => import('../views/CustomersList.vue'),
    },
];

const router = new VueRouter({
    routes
});

export default router
