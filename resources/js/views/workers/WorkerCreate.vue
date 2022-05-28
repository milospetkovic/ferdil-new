<template>
    <div class="customer-page">
        <div class="card-header">
            <strong>~ Unos radnika ~</strong>
        </div>
        <div class="card-body">
            <form @submit.prevent="createWorker">
                <div class="form-group row">

                    <v-text-field
                        :class="'mt-1'"
                        label="Ime radnika"
                        outlined
                        dense
                    >
                    </v-text-field>

                    <v-text-field
                        label="Prezime radnika"
                        outlined
                        dense
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
                        label="JMBG"
                        outlined
                        dense
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
                        :label="`Šalji notifikaciju za istek ugovora: ${send_contract_ended_notification.toString()}`"
                    ></v-checkbox>

                    <v-textarea
                        name="description"
                        label="Beleška"
                        hint="Kratka beleška u vezi radnika"
                        outlined
                        dense
                    >
                    </v-textarea>

                </div>

                <div class="form-group row mb-0">

                    <button type="submit" :disabled="disabledSave" class="btn btn-success">
                        Sačuvaj
                    </button>

                    <button class="btn btn-outline-secondary float-end" @click="cancel">
                        Prekini
                    </button>

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
        data() {
            return {
                fields: {},
                send_contract_ended_notification: '',
                contract_startMenu: false,
                contract_start: '',
                contract_end: '',
                active_until_date: '',
            }
        },
        mounted() {
            //
        },
        computed: {
            disabledSave() {
                if (this.fields.name && this.fields.name.length > 0) {
                    return false;
                }
                return true;
            },
            computedContractStart() {
                return this.contract_start ? moment(this.contract_start).format('DD.MM.YYYY') : '';
            },
            computedContractEnd() {
                return this.contract_end ? moment(this.contract_end).format('DD.MM.YYYY') : '';
            },
        },
        methods: {
            createWorker() {

                let rootComponent = this.$root;
                let requestToast = this.$toast;
                let currentModels = this.fields;

                // Progress bar - show.
                rootComponent.showProgressBar = true;

                axios.get('sanctum/csrf-cookie');

                let sendData = {
                    id: -1,
                    name: this.fields.name
                };

                // Make a request.
                axios.post('api/customer', sendData).then(function(res) {

                    //console.log('success response', res);

                    // Show toast message.
                    requestToast.success(`Uspešno unešen komitent: ${res.data.data.name}`);

                    // Clear field.
                    currentModels.name = '';

                }).catch(function(error) {

                    //console.log('error saving customer', error);

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
                });
            },
            cancel() {
                // Redirect user to home page.
                this.$router.push('/');
            },
        }
    }
</script>
