<template>

    <v-app style="background-color: transparent !important;">

        <header-component></header-component>

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
    },
    methods: {
        //
    },
    computed: {
        //
    },
};
</script>
