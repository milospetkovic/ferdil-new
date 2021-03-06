import axios from 'axios'
import store from '../store/index'

const instance = axios.create({
    baseURL: 'http://ferdil-new.local',
    withCredentials: true
});

instance.interceptors.request.use(
    config => {
        if(store.getters.userToken) {
            config.headers['Authorization'] = `Bearer ${store.getters.userToken}`;
        }
        return config;
    },
    error => {
        Promise.reject(error);
    }
);

export default instance;
