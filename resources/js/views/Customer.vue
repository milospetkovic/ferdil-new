<template>
    <div class="customer-page">
        <div class="card-header">
            <strong>~ Unos komitenta ~</strong>
        </div>
        <div class="card-body">
            <form @submit.prevent="saveCustomer">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">
                        Ime klijenta
                    </label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" v-model="fields.name" autofocus>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4 text-left">
                        <button type="submit" :disabled="disabledSave" class="btn btn-success">
                            Sačuvaj
                        </button>

                        <button class="btn btn-outline-secondary float-end" @click="cancel">
                            Prekini
                        </button>
                    </div>
                </div>

<!--                <div class="form-group row">-->
<!--                    <label for="email" class="col-md-4 col-form-label text-md-right">Your E-Mail Address</label>-->

<!--                    <div class="col-md-6">-->
<!--                        <input id="email" type="email" class="form-control" name="email" v-model="fields.email" required autocomplete="email">-->
<!--                        <div class="alert alert-danger" v-if="errors && errors.email">-->
<!--                            {{ errors.email[0] }}-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </form>
        </div>
    </div>
</template>

<script>
    //import lodash from 'lodash';

    export default {
        name: 'Customer',
        data() {
            return {
                fields: {}
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
            }
        },
        methods: {
            saveCustomer() {

                let rootComponent = this.$root;

                // Progress bar - show.
                rootComponent.showProgressBar = true;

                let requestToast = this.$toast;

                axios.get('sanctum/csrf-cookie');

                let sendData = {
                    name: this.fields.name
                };

                // Make a request.
                axios.post('api/customers', sendData).then(function(res) {

                    //console.log('success response', res);

                    requestToast.success(`Uspešno unešen komitent: ${res.data.data.name}`);

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
