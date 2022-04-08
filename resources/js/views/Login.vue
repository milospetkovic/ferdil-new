<template>
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
