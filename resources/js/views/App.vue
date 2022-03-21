<template>

    <v-app style="background-color: transparent !important;">

        <header-component></header-component>

        <template
            v-if="this.$store.getters.isLoggedIn">
            Ulogovan je korisnik.
        </template>

        <template v-else>
            Korisnik NIJE ulogovan.
        </template>

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
    computed: {
        isUserLoggedIn() {
            return this.$store.getters.isLoggedIn;
        }
    },
};
</script>
