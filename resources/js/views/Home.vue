<template>
    <div>
        <div v-if="isAuthenticated">
            <h1>Welcome {{ user.name }}</h1>
            <button @click="testApi">Test API</button>

            <div class="text-center">
                <button class="btn btn-primary" @click="logOut">Logout</button>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" @click="testApi">Test API (Logged!)</button>
            </div>

        </div>

        <div v-else>
            <h2>You have to login first</h2>
<!--            <a class="btn btn-warning" href="/login">Login</a>-->
            <router-link to="/login">Login</router-link>

            <div class="text-center">
                <button type="button" class="btn btn-primary" @click="testApi">Test API (not logged)</button>
            </div>
        </div>

    </div>
</template>
<script>
    const axios = require('axios');

    export default {
        name: 'Home',
        mounted() {
            // this.isAuthenticated();
            // this.user();
        },
        computed: {
            isAuthenticated() {
                return this.$store.getters.isAuthenticated;
            },
            user() {
                return this.$store.getters.user;
            }
        },
        methods: {
            async testApi() {
                const res = await axios.get('api/test');
                console.log(res.data);
            },
            async logOut() {
                const res = await axios.get('api/test');
                console.log(res.data);
            }
        },
    };
</script>
