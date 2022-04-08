<template>

    <v-app style="background-color: transparent !important;">

        <header-component></header-component>

<!--        <template-->
<!--            v-if="this.$store.getters.isLoggedIn">-->
<!--            Ulogovan je korisnik.-->
<!--        </template>-->

<!--        <template v-else>-->
<!--            Korisnik NIJE ulogovan.-->
<!--        </template>-->
        <router-view />

    </v-app>
</template>

<script>
import HeaderComponent from "../components/HeaderComponent";

export default {
    name: 'App',
    components: {
      HeaderComponent
    },
    mounted() {
        console.log('Loaded App.vue');
        // this.$store.commit('setAuthUser', window.auth_user);
        // console.log('Da li je korisnik logovan (getter iz store-a): ', this.$store.getters.isLoggedIn);
    },
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
