<template>
    <form @submit.prevent="login">
        <input type="email" placeholder="Email address" v-model="form.email" />
        <input type="password" placeholder="Password" v-model="form.password" />
        <button type="submit">Login</button>
    </form>
</template>

<script>
    import axios from '../api/axios'

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            async login() {
                await axios.get('sanctum/csrf-cookie');
                const res = await axios.post('login', this.form);
                console.log(res.data);
            }
        }
    }
</script>
