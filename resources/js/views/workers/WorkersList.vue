<template>
    <div class="customer-page">
        <div class="card-header">
            <strong>~ Lista radnika ~</strong>
        </div>
        <div class="card-header bg-transparent clearfix">
            <div class="float-start">

                <v-btn
                    class="pull-left"
                    color="default"
                    small
                    @click="goToHomePage()"
                >
                    Početna
                    <v-icon
                        dark
                        right
                    >
                        mdi-home-outline
                    </v-icon>
                </v-btn>

                <v-btn
                    class="pull-left"
                    color="warning"
                    small
                    @click="goToEditCustomerPage()"
                >
                    Ažuriraj komitenta
                    <v-icon
                        dark
                        right
                    >
                        mdi-pencil-box-outline
                    </v-icon>
                </v-btn>

                <v-btn
                    class="pull-left"
                    color="accent"
                    small
                    @click="goToCreateWorkerPage()"
                >
                    Unesi radnika
                    <v-icon
                        dark
                        right
                    >
                        mdi-account-plus-outline
                    </v-icon>
                </v-btn>

            </div>

            <div class="mx-2"></div>

            <div class="float-end">
                <v-btn
                    class="pull-right"
                    color="error"
                    small
                    @click="deleteCustomer(customer.id)"
                >
                    Obriši komitenta
                    <v-icon
                        dark
                        right
                    >
                        mdi-trash-can-outline
                    </v-icon>
                </v-btn>
            </div>

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
                        :items="getCustomerWorkers"
                        :items-per-page="this.$store.getters.getNumberOfPaginationItems"
                        class="elevation-1"
                        :search="search"
                        :custom-filter="searchCustomerWorkers"
                        @click:row="showCustomerWorker"
                        item-key="worker_id"
                        :options.sync="options"
                        :footer-props="{
                           itemsPerPageText: 'Redova po strani',
                           itemsPerPageAllText: 'Sve',
                           itemsPerPageOptions: this.$store.getters.getDefaultPaginationOptions,
                        }"
                    >
                        <template v-slot:top>
                            <v-text-field
                                v-model="search"
                                label="Pretraga radnika"
                                class="mx-4"
                            ></v-text-field>

                            <v-checkbox
                                v-if="getCountOfUnactiveCustomerWorkers > 0"
                                dense
                                v-model="showUnactiveWorkers"
                                :label="'Prikaži i neaktivne radnike'"
                            >
                            </v-checkbox>

                        </template>

                        <template v-slot:item.contract_start="{ item }">
                            <span>
                                {{ $moment(item.contract_start).format('fullDate') }}
                            </span>
                        </template>

                        <template v-slot:item.contract_end="{ item }">
                            <span>
                                {{ $moment(item.contract_end).format('fullDate') }}
                            </span>
                        </template>

                        <template v-slot:item.inactive="{ item }">
                            <v-chip
                                :color="getWorkerInactiveColor(item.inactive)"
                                small
                                dark
                            >
                                {{ getWorkerInactiveStatus(item.inactive) }}
                            </v-chip>
                        </template>

                        <template v-slot:item.active_until_date="{ item }">
                            <template v-if="item.active_until_date">
                                <span>
                                    {{ $moment(item.active_until_date).format('fullDate') }}
                                </span>
                            </template>
                        </template>

                        <template v-slot:item.send_contract_ended_notification="{ item }">
                            <v-chip
                                :color="getWorkerSendContractEndNotificationColor(item.send_contract_ended_notification)"
                                small
                            >
                                {{ getWorkerSendContractEndNotificationStatus(item.send_contract_ended_notification) }}
                            </v-chip>
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
                this.$router.push({ name: 'customer.index', params: { id: customer.id, customerName: customer.name }})
            }
        }
    }
</script>
