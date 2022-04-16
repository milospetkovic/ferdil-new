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
        toastOptions: {
            position: "top-right",
            timeout: 3500,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: "button",
            icon: true,
            rtl: false
        }
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
            const res = await axios.post('logout');
            commit('logoutUser');
            console.log('logoutUser response: ', res.data);
        },
        async userCompanies({ commit }) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.post('api/user/companies');
            commit('setUserCompanies', res.data);
            console.log('setUserCompanies response: ', res.data);
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
        },
        getToastOptions(state) {
            return state.toastOptions;
        },
    },
    modules: {},
    plugins: [vuexLocal.plugin]
})
