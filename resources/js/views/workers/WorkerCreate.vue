<template>
    <div class="customer-page">
        <div class="card-header">
            <strong>~ Unos radnika ~</strong>
        </div>
        <div class="card-body">
            <form @submit.prevent="createWorker">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">
                        Ime komitenta
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
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'WorkerCreate',
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
            createCustomer() {

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
