<template>
    <section class="app-header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <router-link :class="'navbar-brand glyphicon glyphicon-home'" :to="{name: '/'}">
                        FERDIL
                    </router-link>
                </div>

                <div class="collapsea navbar-collapse" id="app-navbar-collapse">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <template v-if="!isUserLoggedIn">
                            <li>
                                <router-link :to="{name: 'Login'}">
                                    Login
                                </router-link>
                            </li>
                        </template>
                        <template v-else>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="menu10">
                                    {{ this.$store.getters.getUser.name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu10">
                                    <li role="presentation">
                                        <a href="#"
                                           @click.stop="doLogout()">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </template>
                    </ul>
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
