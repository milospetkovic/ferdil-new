import Vue from 'vue'
import Vuex from 'vuex'
import axios from '../api/axios'
import router from '../router/index'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        authenticated: false,
        user: null,
        token: null
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
        }
    },
    actions: {
        async login({ commit }, credentials) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.post('login', credentials);
            commit('authenticateUser', res.data);
            console.log('authenticateUser response: ', res.data);
            await router.push('/');
        },
        async logout({ commit }) {
            const res = await axios.post('logout');
            commit('logoutUser');
            console.log('logoutUser response: ', res.data);
        }
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
        }
    },
    modules: {}
})
