<template>
  <div class="container">
    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>
    <div v-else class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-default">
            <div class="card-header">Example Component</div>

            <div class="card-body">
              I'm an example component
            </div>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    }
  }
</script>