<template>
    <div>
        <div v-if="isUserAuthenticated">
            <h1>Welcome {{ loggedUser.name }}</h1>

            <div class="text-center">
                <button class="btn btn-primary" @click="logoutUser">Logout</button>
            </div>

            <div class="text-center my-2">
                <button type="button" class="btn btn-primary" @click="testApi">Test API (Logged!)</button>
            </div>

            <div class="companies">
                <template v-if="this.$store.getters.getUserCustomers">
                    <ul v-for="(customer, index) in this.$store.getters.getUserCustomers">
                        <li>{{ index }} - {{ customer }}</li>
                    </ul>
                </template>
                <template v-else>
                    <div class="text-warning">Nemate klijente.</div>
                </template>
            </div>

        </div>

        <div v-else>

            <h2>You have to login first</h2>

            <router-link to="/login" :class="'btn btn-primary'">Login</router-link>

<!--            <div class="text-center">-->
<!--                <button type="button" class="btn btn-primary" @click="testApi">Test API (not logged)</button>-->
<!--            </div>-->
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
                customers: null
            }
        },
        mounted() {
            console.log('mounted Home view');
            if (this.$store.getters.isAuthenticated) {
                this.customers = this.$store.dispatch('userCustomers');
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
            logoutUser() {

                // Progress bar - show.
                this.$root.showProgressBar = true;

                this.$store.dispatch('logout').then(res => {

                    // Show toast message.
                    this.$toast.success('You are successfully logged out');

                }).catch(error => {

                    // Show toast message.
                    this.$toast.error('Something is wrong during logout');

                }).finally(() => {

                    // Progress bar - hide.
                    this.$root.showProgressBar = false;

                });
            }
        },
    };
</script>
