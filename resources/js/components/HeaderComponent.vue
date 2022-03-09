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
                    <a class="navbar-brand glyphicon glyphicon-home" href="#" @click.stop="this.navigate('test')">
                        FERDIL
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li>Test</li>
                        <!-- Authentication Links -->
                        <template v-if="!this.$store.getters.isLoggedIn">
                            <li><a href="#" @click.stop="this.navigate('test')">Login</a></li>
                        </template>
                        <template v-else>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu10" aria-expanded="false">
                                    {{ this.$store.getters.getUser }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu10">
                                    <li role="presentation">
                                        <a href="#"
                                           @click.stop="this.navigate('test')">
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
    methods: {

    }
}
</script>
