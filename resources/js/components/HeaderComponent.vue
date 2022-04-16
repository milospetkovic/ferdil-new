<template>
    <section class="app-header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <router-link :class="'navbar-brand glyphicon glyphicon-home'" :to="{name: 'Home'}">
                        Elitasoft - FerDil app
                    </router-link>
                </div>

            </div>
        </nav>
    </section>
</template>
<script>
export default {
    data() {
        return {

        }
    },
    computed: {
        isUserLoggedIn() {
            return this.$store.getters.isLoggedIn;
        }
    },
    methods: {
        goToLoginPage() {
            //this.navigate('Login')
            this.$router.load('/login')
        },
        doLogout() {
            let self = this;
            //alert('OK, sad logout');
            axios.post('/logout').then(function(response, status, request) {
                console.log('Logout response: ', response);
                //this.navigate('Test');
                self.$router.push('/');
            }, function() {
                console.log('Logout failed');
            });
        }
    }
}
</script>
