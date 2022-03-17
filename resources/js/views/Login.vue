<template>
    <div class="container">
        <div class="row justify-content-center">
            <template v-if="!this.$store.getters.isLoggedIn">
                <div class="page-header">
                    <h2>Vue Laravel Auth Login</h2>
                </div>
                <div class="col-md-12 text-center">
                    <p v-if="errors.length">
                        <b>Please correct the following error(s):</b>
                        <ul class="list-group">
                            <li v-for="error in errors" class="list-group-item list-group-item-danger">
                                {{ error }}
                            </li>
                        </ul>
                    </p>
                </div>
                <div class="col-md-6" v-if="loginfalse = true">
                    <form @submit="checkForm" id="createAdministrator">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input v-model="password" type="password" class="form-control" id="password" placeholder="********" name="password">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </template>
            <template v-else>
                You are already logged in.
            </template>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Login component mounted.')
        },
        data() {
            return {
                errors: [],
                email: '',
                password: '',
                state: {
                    email: '',
                    password: ''
                }
            }
        },
        methods:{
            checkForm: function (e) {

                let self = this;

                this.errors = [];
                if (!this.email) {
                    this.errors.push('Email required.');
                }
                if (!this.password) {
                    this.errors.push('Password required.');
                }
                else
                {
                    var formContents = jQuery("#createAdministrator").serialize();


                    axios.post('/login', formContents).then(function(response, status, request) {

                        console.log('response after login: ', response);

                        // set authenticated user to the store.
                        self.$store.commit('setAuthUser', window.auth_user);

                        //self.$store.
                        self.$router.push('/');

                    }, function() {
                        console.log('failed login');
                    });
                }

                e.preventDefault();
            }
        }
    }
</script>
