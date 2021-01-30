<template>
    <div class="container">
        <h5>Halaman Subdashboard</h5>
        <a href="#/dashboard">Kembali</a>
        <hr />
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
        testCoba: function () {          
            alert("halooo apakabar");
        }
    }
//------- end file
}
</script>