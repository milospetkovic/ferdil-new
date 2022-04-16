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

const toastOptions = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 3,
    newestOnTop: true,
    position: "top-right",
    timeout: 3500,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
};

Vue.use(Toast, toastOptions);

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
