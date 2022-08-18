<template>
  <div class="full-width q-pa-lg items-start">
    <q-card>
      <q-card-section>
        <calls-form />
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import CallsForm from '../../components/calls/CallsFormComponent.vue'
</script>

<style scoped>
  .full-width {
    width: 100%;
  }
</style>
