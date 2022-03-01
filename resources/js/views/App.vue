<template>

    <v-app style="background-color: transparent !important;">
        App.vue called

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
    export default {
        name: 'App',
        mounted() {
            this.$store.commit('setAuthUser', window.auth_user);

            console.log('Sta je sa ovim: ', this.$store.getters.isLoggedIn);
        }
    };
</script>
