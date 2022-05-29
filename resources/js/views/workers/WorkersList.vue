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
        </div>
        <div class="card-body">
            <template v-if="showLoadingIcon">
                <v-progress-circular
                    indeterminate
                    color="primary" />
            </template>
            <template v-else>
                <template v-if="workers.length">
                    <v-data-table
                        :headers="workers_table_header"
                        :items="getWorkers"
                        :items-per-page="this.$store.getters.getNumberOfPaginationItems"
                        class="elevation-1"
                        :search="search"
                        :custom-filter="searchWorkers"
                        @click:row="showWorker"
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
                                v-if="getCountOfUnactiveWorkers > 0"
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
                        <strong>Nema unešenih radnika</strong>
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
        name: 'WorkersList',
        data() {
            return {
                search: '',
                showUnactiveWorkers: false,
                workers_table_header: [
                    {
                        text: 'Komitent',
                        align: 'start',
                        sortable: true,
                        value: 'customer_name',
                    },
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
                workers: {},
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
            let fetchedWorkers = this.workers;

            // Progress bar - show.
            rootComponent.showProgressBar = true;

            axios.get('sanctum/csrf-cookie');

            // Make a request.
            axios.get('api/workers').then(function(res) {

                fetchedWorkers = res.data;

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

                console.log('fetchedWorkers: ', fetchedWorkers);

                this.workers = fetchedWorkers;

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
            getWorkers() {
                if (!this.showUnactiveWorkers) {
                    // Get active workers only.
                    return this.workers.filter(worker => {
                        return (worker.inactive != 1) }
                    );
                }
                // Get all workers.
                return this.workers;
            },
            getCountOfAllWorkers() {
                return this.countOfAllWorkers();
            },
            getCountOfActiveWorkers() {
                return this.countOfActiveWorkers();
            },
            getCountOfUnactiveWorkers() {
                return this.getCountOfAllWorkers - this.getCountOfActiveWorkers;
            },
        },
        methods: {
            searchWorkers (value, search, item) {
                return value != null &&
                    search != null &&
                    typeof value === 'string' &&
                    value.toString().toLocaleLowerCase().indexOf(search.toString().toLocaleLowerCase()) !== -1
            },
            showWorker(row) {
                this.$router.push({ name: 'worker.show', params: { id: row.worker_id }})
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
            countOfAllWorkers() {
                if (this.workers.length) {
                    return this.workers[0].customer_count_all_workers;
                }
                return 0;
            },
            countOfActiveWorkers() {
                if (this.workers.length) {
                    return this.workers[0].customer_count_active_workers;
                }
                return 0;
            },
            goToHomePage() {
                // Redirect user to home page.
                this.$router.push('/');
            },
            goToCreateWorkerPage() {
                this.$router.push({ name: 'worker.create' });
            },
        }
    }
</script>
