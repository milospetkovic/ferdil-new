<template>
    <div class="customer-page">
        <div class="card-header">
            <strong>
                <template v-if="editWorker">
                     ~ Ažuriranje radnika ~
                 </template>
                <template v-else>
                    ~ Pregled radnika ~
                </template>
            </strong>
        </div>
        <div class="card-body">
            <form @submit.prevent="updateWorker">
                <div class="form-group row">

                    <v-select
                        v-model="customersSelect"
                        :class="'mt-2'"
                        :items="customers"
                        label="Radnik za komitenta"
                        item-text="name"
                        item-value="id"
                        outlined
                        dense
                        :disabled="lockFields"
                    ></v-select>

                    <v-text-field
                        v-model="first_name"
                        label="Ime radnika"
                        outlined
                        dense
                        :disabled="lockFields"
                    >
                    </v-text-field>

                    <v-text-field
                        v-model="last_name"
                        label="Prezime radnika"
                        outlined
                        dense
                        :disabled="lockFields"
                    >
                    </v-text-field>

                    <v-menu
                        ref="contract_startMenu"
                        v-model="contract_startMenu"
                        :close-on-content-click="false"
                        :return-value.sync="contract_start"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                :value="computedContractStart"
                                label="Datum početka ugovora"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                clearable
                                @click:clear="contract_start = null"
                                outlined
                                dense
                                :disabled="lockFields"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="contract_start"
                            first-day-of-week="1"
                            no-title
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="contract_startMenu = false"
                            >
                                Odustani
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.contract_startMenu.save(contract_start)"
                            >
                                OK
                            </v-btn>
                        </v-date-picker>
                    </v-menu>

                    <v-menu
                        ref="contract_endMenu"
                        v-model="contract_endMenu"
                        :close-on-content-click="false"
                        :return-value.sync="contract_end"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                :value="computedContractEnd"
                                label="Datum kraja ugovora"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                clearable
                                @click:clear="contract_end = null"
                                outlined
                                dense
                                :disabled="lockFields"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="contract_end"
                            first-day-of-week="1"
                            no-title
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="contract_endMenu = false"
                            >
                                Odustani
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.contract_endMenu.save(contract_end)"
                            >
                                OK
                            </v-btn>
                        </v-date-picker>
                    </v-menu>

                    <v-text-field
                        v-model="jmbg"
                        label="JMBG"
                        outlined
                        dense
                        :disabled="lockFields"
                    >
                    </v-text-field>

                    <v-menu
                        ref="active_until_dateMenu"
                        v-model="active_until_dateMenu"
                        :close-on-content-click="false"
                        :return-value.sync="active_until_date"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                :value="computedActiveUntilDate"
                                label="Aktivan do datuma"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                clearable
                                @click:clear="active_until_date = null"
                                outlined
                                dense
                                :disabled="lockFields"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="active_until_date"
                            first-day-of-week="1"
                            no-title
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="active_until_dateMenu = false"
                            >
                                Odustani
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.active_until_dateMenu.save(active_until_date)"
                            >
                                OK
                            </v-btn>
                        </v-date-picker>
                    </v-menu>

                    <v-checkbox
                        v-model="send_contract_ended_notification"
                        :label="`Šalji notifikaciju za istek ugovora`"
                        :disabled="lockFields"
                    ></v-checkbox>

                    <v-textarea
                        v-model="description"
                        name="description"
                        label="Beleška"
                        hint="Kratka beleška u vezi radnika"
                        outlined
                        dense
                        :disabled="lockFields"
                    >
                    </v-textarea>

                </div>

                <div class="form-group row mb-0">

                    <template v-if="editWorker">

                        <button type="submit" :disabled="disabledSave" class="btn btn-success mt-1">
                            Sačuvaj
                        </button>

                        <button class="btn btn-outline-secondary float-end mt-1" @click="cancel">
                            Prekini
                        </button>

                    </template>
                    <template v-else>

                        <button class="btn btn-warning mt-1" @click.prevent="goToEditWorkerMode">
                            Izmeni
                        </button>

                        <button class="btn btn-danger mt-1" @click.prevent="deleteWorker">
                            Obriši
                        </button>

                        <button class="btn btn-outline-secondary float-end mt-1" @click="$router.go(-1)">
                            Povratak
                        </button>
                    </template>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import {
        VTextField,
        VTextarea,
        VDatePicker,
    } from 'vuetify/lib';

    export default {
        name: 'WorkerCreate',
        props: ['customer_id', 'customer_name'],
        data() {
            return {
                editWorker: false,
                customers: [],
                customersSelect: {
                    id: this.customer_id,
                    name: this.customer_name
                },
                first_name: '',
                last_name: '',
                contract_startMenu: false,
                contract_start: '',
                contract_endMenu: false,
                contract_end: '',
                jmbg: '',
                active_until_dateMenu: false,
                active_until_date: '',
                send_contract_ended_notification: true,
                description: '',
                worker: {}
            }
        },
        mounted() {
            let rootComponent = this.$root;
            let requestToast = this.$toast;
            let fetchedCustomers = this.customers;
            let fetchedWorker = this.worker;

            // Progress bar - show.
            rootComponent.showProgressBar = true;

            axios.get('sanctum/csrf-cookie');

            const requestGetWorker = axios.get('api/worker/' +  this.$route.params.id);
            const requestGetCustomers = axios.get('api/user/customers');

            // Make a requests.
            axios.all([requestGetWorker, requestGetCustomers]).then(axios.spread((...responses) => {

                fetchedWorker = responses[0].data;
                fetchedCustomers = responses[1].data.data;
            }))
            .catch(function(error) {

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
                this.worker = fetchedWorker;
                this.populateData();
                this.showLoadingIcon = false;
            });
        },
        computed: {
            disabledSave() {
                return false;
            },
            computedContractStart() {
                return this.contract_start ? moment(this.contract_start).format('DD.MM.YYYY') : '';
            },
            computedContractEnd() {
                return this.contract_end ? moment(this.contract_end).format('DD.MM.YYYY') : '';
            },
            computedActiveUntilDate() {
                return this.active_until_date ? moment(this.active_until_date).format('DD.MM.YYYY') : '';
            },
            lockFields() {
                if (this.editWorker) {
                    return false;
                }
                return true;
            }
        },
        methods: {
            getDataForSave() {
                return {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    contract_start: this.contract_start,
                    contract_end: this.contract_end,
                    jmbg: this.jmbg,
                    active_until_date: this.active_until_date,
                    send_contract_ended_notification: this.send_contract_ended_notification,
                    description: this.description,
                    fk_customer: (this.customer_id) ? this.customer_id : this.customersSelect,
                };
            },
            updateWorker() {

                let rootComponent = this.$root;
                let requestToast = this.$toast;
                let successAction = false;

                // Progress bar - show.
                rootComponent.showProgressBar = true;

                axios.get('sanctum/csrf-cookie');

                let sendData = this.getDataForSave();

                console.log('data: ', sendData);

                // Make a request.
                axios.put('api/worker/' + this.worker.id, sendData).then(function(res) {

                    // Show toast message.
                    requestToast.success(`Uspešno ažuriran radnik: ${res.data.first_name} ${res.data.last_name}`);

                    successAction = true;

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

                    if (successAction) {
                        // Lock form for edit.
                        this.editWorker = false;
                    }
                });
            },
            deleteWorker() {
                let rootComponent = this.$root;
                let requestToast = this.$toast;

                // Progress bar - show.
                rootComponent.showProgressBar = true;

                axios.get('sanctum/csrf-cookie');

                // Make a request.
                axios.delete('api/worker/' + this.worker.id).then((res) => {

                    // Show toast message.
                    requestToast.success(`Uspešno obrisan radnik`);

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

                    // Redirect user to customer's list of workers.
                    this.$router.push({ name: 'customer.index', params: { id: this.worker.fk_customer } });
                });
            },
            cancel() {
                // Redirect user to home page.
                this.$router.push('/');
            },
            clearFormFields() {
                this.first_name = '';
                this.last_name = '';
                this.contract_start = '';
                this.contract_end = '';
                this.jmbg = '';
                this.active_until_date = '';
                this.description = ''
            },
            populateData() {
                this.customersSelect = this.worker.fk_customer;
                this.first_name = this.worker.first_name;
                this.last_name = this.worker.last_name;
                this.contract_start = this.worker.contract_start;
                this.contract_end = this.worker.contract_end;
                this.jmbg = this.worker.jmbg;
                this.active_until_date = this.worker.active_until_date;
                this.description = this.worker.description;
            },
            goToEditWorkerMode() {
                this.editWorker = !this.editWorker;
            }
        }
    }
</script>
