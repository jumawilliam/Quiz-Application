<script setup>
 import Layout from '@/Shared/Layout.vue'
 defineProps({
    percentage:Number,
    comment:String
 })
</script>
<template>
<Layout>
    <div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis">{{comment}}</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Your score is {{ percentage }}%</p>
      
    </div>
  </div>
</Layout>
</template>