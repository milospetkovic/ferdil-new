<template>



        <div class="card text-center">

            <div class="card-header">
                ~ Aplikacija za praćenje isticanje ugovora radnika ~
            </div>

            <div class="card-body">

                <div v-if="isUserAuthenticated">

                    <div class="my-2">
                        <a class="btn btn-info" href="#nogo">Unos novog komitenta</a>
                    </div>

                    <div class="my-2">
                        <a class="btn btn-info" href="#nogo">Lista komitenata</a>
                    </div>

                    <div class="my-2">
                        <a class="btn btn-info" href="#nogo">Lista radnika</a>
                    </div>

                    <div class="my-2">
                        <a class="btn btn-warning" href="#nogo">Pošalji notifikacije</a>
                    </div>

                    <div class="my-2">
                        <a class="btn btn-warning" href="#nogo">Pokreni deaktivaciju radnika</a>
                    </div>


                    <div class="mt-5">
                        <button class="btn btn-outline-warning" @click="logoutUser">Izloguj se</button>
                    </div>


<!--                    <h1>Welcome {{ loggedUser.name }}</h1>-->

<!--                    <div class="text-center">-->
<!--                        <button class="btn btn-primary" @click="logoutUser">Logout</button>-->
<!--                    </div>-->

<!--                    <div class="text-center my-2">-->
<!--                        <button type="button" class="btn btn-primary" @click="testApi">Test API (Logged!)</button>-->
<!--                    </div>-->

<!--                    <div class="companies">-->
<!--                        <template v-if="this.$store.getters.getUserCustomers">-->
<!--                            <ul v-for="(customer, index) in this.$store.getters.getUserCustomers">-->
<!--                                <li>{{ customer.id }} - {{ customer.name }}</li>-->
<!--                            </ul>-->
<!--                        </template>-->
<!--                        <template v-else>-->
<!--                            <div class="text-warning">Nemate klijente.</div>-->
<!--                        </template>-->
<!--                    </div>-->

                </div>

                <div v-else>

                    <h2>Morate da se ulogujete da biste imali pristup aplikaciji.</h2>

                    <router-link to="/login" :class="'btn btn-primary'">Login</router-link>

<!--                    <div class="text-center my-2">-->
<!--                        <button type="button" class="btn btn-primary" @click="testApi">Test API (not logged)</button>-->
<!--                    </div>-->

                </div>

<!--                <div class="row mrg-t-10 text-center clearfix">-->
<!--                    <a class="btn btn-info" href={{ action('App\Http\Controllers\Company\CompanyController@create') }}>Unos komitenata</a>-->
<!--                </div>-->

<!--                <div class="row mrg-t-10 text-center clearfix">-->
<!--                    <a class="btn btn-info" href={{ action('App\Http\Controllers\Company\CompanyController@listCompanies') }}>Lista komitenata <span class="badge">{{ $companies_count }}</span></a>-->
<!--                </div>-->

<!--                <div class="row mrg-t-10 text-center clearfix">-->
<!--                    <a class="btn btn-info" href={{ action('App\Http\Controllers\Worker\WorkerController@listWorkers') }}>Lista radnika <span class="badge">{{ $workers_count }}@if($active_workers_count) <span title="Broj aktivnih korisnika">({{ $active_workers_count }})</span>@endif</span></a>-->
<!--                </div>-->

<!--                <div class="row mrg-t-10 text-center clearfix">-->
<!--                    <a class="btn btn-warning" href={{ action('App\Http\Controllers\Firebase\FirebaseBrozotController@sendNotifications') }}>Testiraj slanje notifikacija</a>-->
<!--                </div>-->

<!--                <div class="row mrg-t-10 text-center clearfix">-->
<!--                    <a class="btn btn-warning" href={{ action('App\Http\Controllers\Worker\WorkerController@unactivateWorkers') }}>Pokreni deaktivaciju radnika</a>-->
<!--                </div>-->

<!--                <div class="row mrg-t-10 text-center clearfix">-->
<!--                    <p class="text-muted mrg-t-10">-->
<!--                        <small>{{ vcs_info(false) }}</small>-->
<!--                    </p>-->
<!--                </div>-->
            </div>

            <div class="card-footer text-muted">
                <small>Show app version.</small>
                <!--                    <small>{{ vcs_info(false) }}</small>-->
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
