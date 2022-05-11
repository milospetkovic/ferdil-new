<template>
    <div class="login-page">

        <div class="card-header">
            <strong>~ Logovanje na aplikaciju ~</strong>
        </div>

        <div class="card-body">
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
    </div>
</template>

<script>
    import lodash from 'lodash';

    export default {
        name: 'Login',
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
                this.$toast.warning('You are already logged in');

                // Redirect user to home page.
                this.$router.push('/');
            }
        },
        methods: {
            login() {

                // Progress bar - show.
                this.$root.showProgressBar = true;

                this.$store.dispatch('login', this.form).then(result => {

                    // Show toast message.
                    this.$toast.success('You are successfully logged in');

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
                    this.$toast.error(errorMessage);

                }).finally(() => {

                    // Progress bar - hide.
                    this.$root.showProgressBar = false;

                });
            },
        }
    }
</script>
