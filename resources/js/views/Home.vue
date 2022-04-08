<template>
    <div>
        <div v-if="isAuthenticated">
            <h1>Welcome {{ user.name }}</h1>
            <button @click="testApi">Test API</button>
        </div>

        <div v-else>
            <h2>You have to login first</h2>
<!--            <a class="btn btn-warning" href="/login">Login</a>-->
            <router-link to="/login">Login</router-link>
        </div>

    </div>
</template>
<script>
    const axios = require('axios');

    export default {
        name: 'Home',
        methods: {
            async testApi() {
                const res = await axios.get('api/test');
                console.log(res.data);
            }
        },
        computed: {
            isAuthenticated() {
                return this.$store.getters.isAuthenticated;
            },
            user() {
                return this.$store.getters.user;
            }
            // isUserLoggedIn() {
            //     return this.$store.getters.isLoggedIn;
            // }
        },
    };
</script>
