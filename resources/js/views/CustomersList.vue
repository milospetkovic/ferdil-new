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
                    <v-data-table
                        :headers="customers_table_header"
                        :items="customers"
                        :items-per-page="15"
                        class="elevation-1"
                    ></v-data-table>
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
    import { VProgressCircular } from 'vuetify/lib';
    import { VDataTable } from 'vuetify/lib';

    export default {
        name: 'CustomersList',
        data() {
            return {
                customers_table_header: [
                    {
                        text: 'Ime komitenta',
                        align: 'start',
                        sortable: true,
                        value: 'name',
                    },
                    {
                        text: 'Broj radnika',
                        align: 'end',
                        sortable: false,
                        value: 'calories',
                    },
                ],
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
