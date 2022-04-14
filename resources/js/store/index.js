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
        userCompanies: null,
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
        setUserCompanies(state, data) {
            state.userCompanies = data;
        }
    },
    actions: {
        async login({ commit }, credentials) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.post('login', credentials);
            console.log('res je: ', res);
            if (res.data.errors) {
                console.log('errors in store');
                alert('errors');
            } else {
                console.log('try to authenticate');
                commit('authenticateUser', res.data);
                console.log('authenticateUser response: ', res.data);
                await router.push('/');
            }
        },
        async logout({ commit }) {
            const res = await axios.post('logout');
            commit('logoutUser');
            console.log('logoutUser response: ', res.data);
        },
        async userCompanies({ commit }) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.post('api/user/companies');
            commit('setUserCompanies', res.data);
            console.log('setUserCompanies response: ', res.data);
            //await router.push('/');
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
        getUserCompanies(state) {
            return state.userCompanies;
        }
    },
    modules: {},
    plugins: [vuexLocal.plugin]
})
