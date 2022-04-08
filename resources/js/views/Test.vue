<template>
    <div>
        <p>Test.vue included</p>

        <button type="button" class="btn btn-primary" @click="testApi">Test API</button>
    </div>
</template>
<script>
    const axios = require('axios');
    export default {
        name: 'Test',
        methods: {
            async testApi() {
                const res = await axios.get('http://ferdil-new.local/api/test');
                console.log(res.data);
            }
        }
    };
</script>
