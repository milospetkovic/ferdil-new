import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../views/Home.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/Login.vue'),
    },
    {
        path: '/customer',
        name: 'customer.create',
        component: () => import('../views/customers/CustomerCreate.vue'),
    },
    {
        path: '/customers',
        name: 'customers.list',
        component: () => import('../views/customers/CustomersList.vue'),
    },
];

const router = new VueRouter({
    routes
});

export default router
