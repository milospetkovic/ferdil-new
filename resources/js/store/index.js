import Vue from 'vue'
import Vuex from 'vuex'
import axios from '../api/axios'
import router from '../router/index'
import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
    storage: window.localStorage
});

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        authenticated: false,
        user: null,
        token: null,
        userCustomers: [],
        userWorkers: [],
    },
    mutations: {
        authenticateUser(state, data) {
            state.authenticated = true;
            state.token = data.token;
            state.user = data.user;
        },
        logoutUser(state) {
            state.authenticated = false;
            state.token = null;
            state.user = null
        },
        setUserCustomers(state, data) {
            state.userCustomers = data;
        },
        setUserWorkers(state, data) {
            state.userWorkers = data;
        },
    },
    actions: {
        async login({ commit }, credentials) {
            await axios.get('sanctum/csrf-cookie');
            return new Promise((resolve, reject) => {
                axios.post('login', credentials).then(function (res) {
                    if (res.data.errors) {
                        console.log('rejected because of an errors');
                        reject(res.data);
                    } else {
                        console.log('authenticateUser response: ', res.data);
                        commit('authenticateUser', res.data);
                        resolve(res.data);
                    }
                }).catch(function (error) {
                    reject(error.response.data);
                })
            })
        },
        async logout({ commit }) {
            return new Promise((resolve, reject) => {
                axios.post('logout').then(res => {
                    commit('logoutUser');
                    resolve(res.data);
                }).catch(error => {
                    reject(error.response.data);
                });
            });
        },
        async userCustomers({ commit }) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.get('api/user/customers');
            commit('setUserCustomers', res.data.data);
            console.log('setUserCustomers response: ', res.data.data);
        },
        async userWorkers({ commit }) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.get('api/user/workers');
            commit('setUserWorkers', res.data.data);
            console.log('setUserWorkers response: ', res.data.data);
        },
    },
    getters: {
        isAuthenticated(state) {
            return state.authenticated;
        },
        user(state) {
            return state.user;
        },
        userToken(state) {
            return state.token;
        },
        getUserCustomers(state) {
            return state.userCustomers;
        },
        getUserCustomersCount(state) {
            return state.userCustomers.length;
        },
        getUserTotalWorkersCount(state) {
            return state.userWorkers.length;
        },
        getUserActiveWorkersCount(state) {
            let allUserWorkers = state.userWorkers;
            const activeUserWorkers = allUserWorkers.filter((item) => {
                return item.inactive != 1;
            });
            return activeUserWorkers.length;
        },
    },
    modules: {},
    plugins: [vuexLocal.plugin]
})
