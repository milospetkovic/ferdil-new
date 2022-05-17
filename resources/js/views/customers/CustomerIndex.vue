<template>
    <div class="customer-page">
        <div class="card-header">
            <div class="position-absolute top-0 end-0 text-muted">
                <span class="badge alert-info" title="Broj radnika za komitenta">
                    {{ getCountOfAllCustomerWorkers }}
                    <span title="Broj aktivnih radnika">({{ getCountOfActiveCustomerWorkers }})</span>
                </span>
            </div>
            <strong>~ Komitent: {{ getCustomerName }} ~</strong>
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
                                label="Pretraga radnika komitenta"
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
    import {
        mdiAccount,
        mdiPencil,
        mdiShareVariant,
        mdiDelete,
    } from '@mdi/js';

    export default {
        name: 'CustomerIndex',
        data() {
            return {
                search: '',
                showUnactiveWorkers: false,
                customer_workers_table_header: [
                    {
                        text: 'Prezime',
                        align: 'start',
                        sortable: true,
                        value: 'last_name',
                    },
                    {
                        text: 'Ime',
                        align: 'start',
                        sortable: true,
                        value: 'first_name',
                    },
                    {
                        text: 'Početak ugovora',
                        align: 'start',
                        sortable: true,
                        value: 'contract_start',
                    },
                    {
                        text: 'Kraj ugovora',
                        align: 'start',
                        sortable: true,
                        value: 'contract_end',
                    },
                    {
                        text: 'JMBG',
                        align: 'start',
                        sortable: true,
                        value: 'jmbg',
                    },
                    {
                        text: 'Status',
                        align: 'start',
                        sortable: true,
                        value: 'inactive',
                    },
                    {
                        text: 'Aktivan do datuma',
                        align: 'start',
                        sortable: true,
                        value: 'active_until_date',
                    },
                    {
                        text: 'Šalji notifikaciju za istek ugovora',
                        align: 'start',
                        sortable: true,
                        value: 'send_contract_ended_notification',
                    },
                    {
                        text: 'Beleška',
                        align: 'start',
                        sortable: true,
                        value: 'description',
                    },
                ],
                customerWorkers: {},
                showLoadingIcon: false,
                options: {},
                icons: {
                    mdiAccount,
                    mdiPencil,
                    mdiShareVariant,
                    mdiDelete,
                },
                customer: {},
            }
        },
        beforeMount() {
            this.showLoadingIcon = true;
        },
        mounted() {
            let rootComponent = this.$root;
            let requestToast = this.$toast;
            let fetchedCustomerWorkers = this.customerWorkers;
            let fetchedCustomer = this.customer;

            // Progress bar - show.
            rootComponent.showProgressBar = true;

            axios.get('sanctum/csrf-cookie');

            // Make a request.
            axios.get('api/customer/' + this.$route.params.id + '/workers').then(function(res) {

                fetchedCustomerWorkers = res.data.customer_workers;
                fetchedCustomer = res.data.customer;

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

                this.customer = fetchedCustomer;
                this.customerWorkers = fetchedCustomerWorkers;

                this.showLoadingIcon = false;
            });
        },
        watch: {
            options: {
                handler () {
                    if (this.options.itemsPerPage != this.$store.getters.getNumberOfPaginationItems) {
                        this.$store.dispatch('setNumberOfPaginationItems', this.options.itemsPerPage);
                    }
                },
                deep: true,
            },
        },
        computed: {
            getCustomerName() {
                return this.customer.name;
            },
            getCustomerWorkers() {
                if (!this.showUnactiveWorkers) {
                    // Get active workers only.
                    return this.customerWorkers.filter(worker => {
                        return (worker.inactive != 1) }
                     );
                }
                // Get all workers.
                return this.customerWorkers;
            },
            getCountOfAllCustomerWorkers() {
                return this.countOfAllCustomerWorkers();
            },
            getCountOfActiveCustomerWorkers() {
                return this.countOfActiveCustomerWorkers();
            },
            getCountOfUnactiveCustomerWorkers() {
                return this.getCountOfAllCustomerWorkers - this.getCountOfActiveCustomerWorkers;
            },
        },
        methods: {
            searchCustomerWorkers (value, search, item) {
                return value != null &&
                    search != null &&
                    typeof value === 'string' &&
                    value.toString().toLocaleLowerCase().indexOf(search.toString().toLocaleLowerCase()) !== -1
            },
            showCustomerWorker() {
                alert('show worker full view');
            },
            getWorkerInactiveColor(inactive) {
                if (inactive == 1) return 'red';
                return 'green';
            },
            getWorkerInactiveStatus(inactive) {
                if (inactive == 1) return 'NEAKTIVAN';
                return 'Aktivan';
            },
            getWorkerSendContractEndNotificationColor(value) {
                if (value == 1) return 'green';
                return 'red';
            },
            getWorkerSendContractEndNotificationStatus(value) {
                if (value == 1) return 'DA';
                return 'NE';
            },
            countOfAllCustomerWorkers() {
                if (this.customerWorkers.length) {
                    return this.customerWorkers[0].customer_count_all_workers;
                }
                return 0;
            },
            countOfActiveCustomerWorkers() {
                if (this.customerWorkers.length) {
                    return this.customerWorkers[0].customer_count_active_workers;
                }
                return 0;
            },
            goToHomePage() {
                // Redirect user to home page.
                this.$router.push('/');
            },
            goToEditCustomerPage() {
                this.$router.push({ name: 'customer.edit', params: { id: this.customer.id }})
            }
        }
    }
</script>
