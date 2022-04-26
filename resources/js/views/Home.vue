<template>

    <div class="card text-center">

        <div class="card-header">
            <strong>~ Aplikacija za praćenje isteka ugovora radnika ~</strong>
        </div>

        <div class="card-body">

            <div v-if="isUserAuthenticated">

                <div class="my-2">
                    <a class="btn btn-info" href="#nogo">Unos novog komitenta</a>
                </div>

                <div class="my-2">
                    <a class="btn btn-info" href="#nogo">
                        Lista komitenata
                        <span class="badge bg-secondary" title="Ukupan broj komitenata">{{ userCustomersCount }}</span>
                    </a>
                </div>

                <div class="my-2">
                    <a class="btn btn-info" href="#nogo">
                        Lista radnika
                        <span class="badge bg-secondary" title="Ukupan broj i broj aktivnih radnika">
                            {{ userTotalWorkersCount }} ({{ userActiveWorkersCount }})
                        </span>
                    </a>
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
