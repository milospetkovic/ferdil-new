<template>
    <div>
        <div v-if="isUserAuthenticated">
            <h1>Welcome {{ loggedUser.name }}</h1>
            <button @click="testApi">Test API</button>

            <div class="text-center">
                <button class="btn btn-primary" @click="logoutUser">Logout</button>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" @click="testApi">Test API (Logged!)</button>
            </div>

            <div class="companies">
                <template v-if="this.$store.getters.getUserCompanies">
                    <ul v-for="(company, index) in this.$store.getters.getUserCompanies">
                        <li>{{ index }} - {{ company }}</li>
                    </ul>
                    IMAAAA
                </template>
                <template v-else>
                    NEMAAA
                </template>
                Here companies
            </div>

        </div>

        <div v-else>

            <h2>You have to login first</h2>

            <router-link to="/login">Login</router-link>

            <div class="text-center">
                <button type="button" class="btn btn-primary" @click="testApi">Test API (not logged)</button>
            </div>
        </div>

    </div>
</template>
<script>
    const axios = require('axios');
    //import { VProgressCircular } from 'vuetify/lib'

    export default {
        name: 'Home',
        components: {
          //VProgressCircular
        },
        data() {
            return {
                companies: null
            }
        },
        mounted() {
            console.log('mounted Home view');
            if (this.$store.getters.isAuthenticated) {
                console.log('OK');
                this.companies = this.$store.dispatch('userCompanies');
            }
        },
        computed: {
            isUserAuthenticated() {
                console.log('called this.$store.getters.isAuthenticated from home page');
                return this.$store.getters.isAuthenticated;
            },
            loggedUser() {
                return this.$store.getters.user;
            }
        },
        methods: {
            async testApi() {
                const res = await axios.get('api/test');
                console.log(res.data);
            },
            async logoutUser() {
                return this.$store.dispatch('logout');
            }
        },
    };
</script>
