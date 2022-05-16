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
                        :search="search"
                        :custom-filter="searchCustomers"
                        @click:row="showCustomer"
                    >
                        <template #item.customer_workers_count="{ item }">
                            <span class="badge alert-info" title="Broj radnika za komitenta">
                                {{ item.customer_count_all_workers }}
                                <span title="Broj aktivnih radnika">({{ item.customer_count_active_workers }})</span>
                            </span>
                        </template>

                        <template v-slot:top>
                            <v-text-field
                                v-model="search"
                                label="Pretraga komitenata"
                                class="mx-4"
                            ></v-text-field>
                        </template>

                    </v-data-table>
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
                search: '',
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
                        value: 'customer_workers_count',
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
            axios.get('api/user/customers/list').then(function(res) {

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
            searchCustomers (value, search, item) {
                return value != null &&
                    search != null &&
                    typeof value === 'string' &&
                    value.toString().toLocaleLowerCase().indexOf(search.toString().toLocaleLowerCase()) !== -1
            },
            showCustomer(customer) {
                this.$store.dispatch('setCurrentCustomerName', customer.name);
                this.$router.push({ name: 'customer.index', params: { id: customer.id, customerName: customer.name }})
            }
        }
    }
</script>
