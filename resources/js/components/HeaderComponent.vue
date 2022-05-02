<template>
    <section class="app-header mt-1 position-sticky">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <div class="navbar-brand">
                    <!-- Branding Image -->
                    <router-link :class="'navbar-brand glyphicon glyphicon-home'" :to="{name: 'Home'}">
                        <img src="images/elitasoft-small.png" alt="Elitasoft" />
                    </router-link>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Glavni meni</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Zatvori"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                            <template v-if="!this.$store.getters.isAuthenticated">
                                <li>
                                    <router-link to="/login" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">Login</router-link>
                                </li>
<!--                                <li><a href="/register">Register</a></li>-->
                            </template>

                            <template v-else>

                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="">
                                        <strong>Korisnik:</strong> {{ this.$store.getters.user.name }}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <button class="btn btn-outline-warning" @click="logoutUser">
                                        Izloguj se
                                    </button>
                                </li>

                            </template>
                        </ul>
                    </div>
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
        //
    },
    methods: {
        logoutUser() {

            // Progress bar - show.
            this.$root.showProgressBar = true;

            this.$store.dispatch('logout').then(res => {

                // Show toast message.
                this.$toast.success('You are successfully logged out');

            }).catch(error => {

                // Show toast message.
                this.$toast.error('Something is wrong during logout');

            }).finally(() => {

                // Progress bar - hide.
                this.$root.showProgressBar = false;

                // Go to home page.
                this.$router.push('/');

            });
        }
    }
}
</script>
