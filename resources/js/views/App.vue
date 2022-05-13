<template>

    <v-app style="background-color: transparent !important;">

        <div class="container-progress-linear-bar">
            <v-progress-linear
                indeterminate
                v-if="visibleProgressBar"
            />
        </div>

        <header-component></header-component>

        <div class="card text-center">

            <router-view />

        </div>

    </v-app>

</template>

<script>
import Vue from 'vue';
import HeaderComponent from "../components/HeaderComponent";
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import { VProgressLinear } from 'vuetify/lib';

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
        HeaderComponent,
        VProgressLinear,
    },
    data() {
        return {
            showProgressBar: false,
        }
    },
    mounted() {
        console.log('Loaded App.vue');
    },
    computed: {
        visibleProgressBar() {
            return this.$root.showProgressBar;
        }
    },
    methods: {
        //
    },
};
</script>
