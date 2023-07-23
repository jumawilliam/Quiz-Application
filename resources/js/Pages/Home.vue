<script setup>
  import Layout from '@/Shared/Layout.vue'
  import {Link} from '@inertiajs/vue3'
</script>
<template>
    <Layout>
      <div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis">Quiz Application</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Click the button below to start the quiz</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <Link href="/quiz" class="btn btn-primary btn-lg px-4 gap-3">Go to Quiz</Link>
      </div>
    </div>
  </div>
    </Layout>
</template>