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
        path: '/customer/:id',
        name: 'customer.index',
        component: () => import('../views/customers/CustomerIndex.vue'),
    },
    {
        path: '/customer/:id/edit',
        name: 'customer.edit',
        component: () => import('../views/customers/CustomerEdit.vue'),
        props: true
    },
    {
        path: '/customers',
        name: 'customers.list',
        component: () => import('../views/customers/CustomersList.vue'),
    },
    {
        path: '/worker',
        name: 'worker.create',
        component: () => import('../views/workers/WorkerCreate.vue'),
        props: true,
    },
    {
        path: '/worker/:id/edit',
        name: 'worker.edit',
        component: () => import('../views/workers/WorkerViewAndEdit'),
        props: true,
    },
    {
        path: '/worker/:id',
        name: 'worker.show',
        component: () => import('../views/workers/WorkerViewAndEdit'),
        props: true,
    },
];

const router = new VueRouter({
    routes
});

export default router
