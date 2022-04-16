<template>
    <div class="login-page">

<!--        <v-alert-->
<!--            dense-->
<!--            prominent-->
<!--            type="success"-->
<!--        ></v-alert>-->

        <form @submit.prevent="login">
            <div class="text-center mb-3">
                <label for="email">
                    <input type="email" id="email" class="form-control" placeholder="Email address" v-model="form.email" />
                </label>
            </div>

            <div class="text-center mb-3">
                <label for="password">
                    <input type="password" id="password" class="form-control" placeholder="Password" v-model="form.password" />
                </label>
            </div>

            <div class="text-center">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </form>
    </div>
</template>

<script>
    //import VAlert from 'vuetify/lib';
    import lodash from 'lodash';

    export default {
        name: 'Login',
        // components: {
        //     VAlert
        // },
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        mounted() {
            if (this.$store.getters.isAuthenticated) {

                // Show toast message.
                this.$toast.success(
                    'You are already logged in',
                    this.$store.getters.getToastOptions
                );

                // Redirect user to home page.
                this.$router.push('/');
            }
        },
        methods: {
            login: function () {
                this.$store.dispatch('login', this.form).then(result => {

                    // Show toast message.
                    this.$toast.success(
                        'You are successfully logged in',
                        this.$store.getters.getToastOptions
                    );

                    // Redirect user to home page.
                    this.$router.push('/');

                }).catch(error => {

                    // Get error message.
                    let errorMessage = '';

                    if (typeof (error.messages) === 'object') {
                        Object.entries(error.messages).forEach(([key, val]) => {
                            errorMessage += val + "\n";
                        });
                    } else {
                        errorMessage = error.messages;
                    }

                    // Show toast message.
                    this.$toast.error(
                        errorMessage,
                        this.$store.getters.getToastOptions
                    );
                });
            }
        }
    }
</script>
