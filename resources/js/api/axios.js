import axios from 'axios'

const instance = axios.create({
    baseURL: 'http://ferdil-new.local',
    withCredentials: true
});

export default instance;
