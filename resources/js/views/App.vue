<template>

    <v-app style="background-color: transparent !important;">

        <header-component></header-component>

        <router-view />

    </v-app>

</template>

<script>
import Vue from 'vue';
import HeaderComponent from "../components/HeaderComponent";
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

Vue.use(Toast, {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true
});

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
