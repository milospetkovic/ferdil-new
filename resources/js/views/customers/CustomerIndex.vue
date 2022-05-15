<template>
    <div class="customer-page">
        <div class="card-header">
            <template v-if="customerWorkers.length">
                <div class="position-absolute top-0 end-0 text-muted">
                    <span class="badge alert-info" title="Broj radnika za komitenta">
                        {{ customerWorkers[0].customer_count_all_workers }}
                        <span title="Broj aktivnih radnika">({{ customerWorkers[0].customer_count_active_workers }})</span>
                    </span>
                </div>
            </template>
            <strong>~ Komitent: {{ getCustomerName }} ~</strong>
        </div>
        <div class="card-body">
            <template v-if="showLoadingIcon">
                <v-progress-circular
                    indeterminate
                    color="primary" />
            </template>
            <template v-else>
                <template v-if="customerWorkers.length">

                    <v-data-table
                        :headers="customer_workers_table_header"
                        :items="customerWorkers"
                        :items-per-page="15"
                        class="elevation-1"
                        :search="search"
                        :custom-filter="searchCustomers"
                        @click:row="showCustomerWorker"
                    >
                        <template v-slot:top>
                            <v-text-field
                                v-model="search"
                                label="Pretraga radnika komitenta"
                                class="mx-4"
                            ></v-text-field>
                        </template>

                    </v-data-table>
                </template>
                <template v-else>
                    <div class="text-warning text-center">
                        <strong>Nema unešenih radnika za komitenta</strong>
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
        name: 'CustomerIndex',
        data() {
            return {
                search: '',
                customer_workers_table_header: [
                    {
                        text: 'Ime',
                        align: 'start',
                        sortable: true,
                        value: 'first_name',
                    },
                    {
                        text: 'Prezime',
                        align: 'start',
                        sortable: true,
                        value: 'last_name',
                    },
                    {
                        text: 'Broj radnika',
                        align: 'end',
                        sortable: false,
                        value: 'customer_workers_count',
                    },
                ],
                customerWorkers: {},
                showLoadingIcon: false,
            }
        },
        beforeMount() {
            this.showLoadingIcon = true;
        },
        mounted() {

            let rootComponent = this.$root;
            let requestToast = this.$toast;
            let fetchedCustomerWorkers = this.customerWorkers;

            // Progress bar - show.
            rootComponent.showProgressBar = true;

            axios.get('sanctum/csrf-cookie');

            // Make a request.
            axios.get('api/customer/' + this.$route.params.id).then(function(res) {

                fetchedCustomerWorkers = res.data;

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

                this.customerWorkers = fetchedCustomerWorkers;
                this.showLoadingIcon = false;
            });
        },
        computed: {
            getCustomerName() {
                return this.$store.getters.getCurrentCustomerName;
            }
        },
        methods: {
            searchCustomers (value, search, item) {
                return value != null &&
                    search != null &&
                    typeof value === 'string' &&
                    value.toString().toLocaleLowerCase().indexOf(search.toString().toLocaleLowerCase()) !== -1
            },
            showCustomerWorker() {
                alert('show worker full view');
            },
        }
    }
</script>
