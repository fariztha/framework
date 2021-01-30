<template>
    <div class="container">
        <h1>dashboard</h1>
        <button type="button" @click="testCoba()">
        coba tombol
        </button>
    </div>
</template>
<script type="application/javascript">
export default {
    components : {  

    },
    data() {
        return {
            data:"wowo"
        }
    },
    created: function() {

    },
    watch: {

    },
    computed: {

    },
    methods: {
        testCoba = () => {
            alert("halooo apakabar");
        }
    }
//------- end file
}
</script>