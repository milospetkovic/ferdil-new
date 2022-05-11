<template>
    <div class="customer-page">
        <div class="card-header">
            <strong>~ Lista komitenata ~</strong>
        </div>
        <div class="card-body">
            <template v-if="showLoadingIcon">
                <v-progress-circular
                    indeterminate
                    color="primary" />
            </template>
            <template v-else>
                <template v-if="customers.length">
                    <ul v-for="customer in customers">
                        <li>{{ customer.name}}</li>
                    </ul>
                </template>
                <template v-else>
                    <div class="text-warning text-center">
                        <strong>Nema unešenih komitenata</strong>
                    </div>
                </template>
            </template>
        </div>
    </div>
</template>

<script>
    import { VProgressCircular } from 'vuetify/lib'

    export default {
        name: 'CustomersList',
        data() {
            return {
                customers: {},
                showLoadingIcon: false,
            }
        },
        beforeMount() {
            this.showLoadingIcon = true;
        },
        mounted() {
            let rootComponent = this.$root;
            let requestToast = this.$toast;
            let fetchedCustomers = this.customers;

            // Progress bar - show.
            rootComponent.showProgressBar = true;

            axios.get('sanctum/csrf-cookie');

            // Make a request.
            axios.get('api/customers').then(function(res) {

                //alert('success :)))');
                //console.log('success response', res);

                fetchedCustomers = res.data;

            }).catch(function(error) {

                // Get error message.
                let errorMessage = '';

                if (typeof(error.messages) === 'object') {
                    Object.entries(error.messages).forEach(([key, val]) => {
                        errorMessage += val + "\n";
                    });
                } else {
                    errorMessage = error.message;
                }

                // Show toast message.
                requestToast.error(errorMessage);

            }).finally(() => {

                // Progress bar - hide.
                rootComponent.showProgressBar = false;

                this.customers = fetchedCustomers;
                this.showLoadingIcon = false;
            });
        },
        computed: {
            //
        },
        methods: {
            //
        }
    }
</script>
