<template>
        <div class="container text-center" style="margin-top:160px;">
          <h1> 404</h1>
          <button :disabled="disable" v-on:click="back()">
             kembali
          </button>
        </div>
</template>
<script type="application/javascript">
export default { 
 data () {
    return {
      disable:false,
    }
  }, 
  methods: {
    back: function () {      
      this.disable = true;
      this.$router.go(-1);   
    }
  }
// ...
}   
</script>