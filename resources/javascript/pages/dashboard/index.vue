<template>
    <div class="container">
        <h5>dashboard</h5>
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