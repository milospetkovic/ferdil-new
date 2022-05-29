<template>
    <div class="home-page">

        <div class="card-header">
            <strong>~ Aplikacija za praćenje isteka ugovora radnika ~</strong>
        </div>

        <div class="card-body">

            <div v-if="isUserAuthenticated">

                <div class="my-2">
                    <router-link to="/customer" :class="'btn btn-info'">Unos novog komitenta</router-link>
                </div>

                <div class="my-2">
                    <router-link to="/customers" :class="'btn btn-info'">
                        Lista komitenata
                        <span class="badge bg-secondary" title="Ukupan broj komitenata">{{ userCustomersCount }}</span>
                    </router-link>
                </div>

                <div class="my-2">
                    <router-link to="/workers" :class="'btn btn-info'">
                        Lista radnika
                        <span class="badge bg-secondary" title="Broj aktivnih radnika i ukupan broj">
                            {{ userActiveWorkersCount }} ({{ userTotalWorkersCount }})
                        </span>
                    </router-link>
                </div>

                <div class="my-2">
                    <a class="btn btn-warning" href="#nogo">Pošalji notifikacije</a>
                </div>

                <div class="my-2">
                    <a class="btn btn-warning" href="#nogo">Pokreni deaktivaciju radnika</a>
                </div>

            </div>

            <div v-else>

                <h2>Morate da se ulogujete da biste imali pristup aplikaciji.</h2>

                <router-link to="/login" :class="'btn btn-primary'">Login</router-link>

            </div>

        </div>

        <div class="card-footer text-muted">
            <small>Show app version.</small>
            <!--                    <small>{{ vcs_info(false) }}</small>-->
        </div>

    </div>

</template>
<script>
    const axios = require('axios');

    export default {
        name: 'Home',
        components: {
          //
        },
        data() {
            return {
                //
            }
        },
        mounted() {
            console.log('mounted Home view');
            if (this.$store.getters.isAuthenticated) {
                this.$store.dispatch('userCustomers');
                this.$store.dispatch('userWorkers');
            }
        },
        computed: {
            isUserAuthenticated() {
                console.log('called this.$store.getters.isAuthenticated from home page');
                return this.$store.getters.isAuthenticated;
            },
            loggedUser() {
                return this.$store.getters.user;
            },
            userCustomersCount() {
                return this.$store.getters.getUserCustomersCount;
            },
            userTotalWorkersCount() {
                return this.$store.getters.getUserTotalWorkersCount;
            },
            userActiveWorkersCount() {
                return this.$store.getters.getUserActiveWorkersCount;
            },
        },
        methods: {
            async testApi() {
                const res = await axios.get('api/test');
                console.log(res.data);
            },

        },
    };
</script>
