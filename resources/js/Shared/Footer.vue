<script setup>
import {Link} from '@inertiajs/vue3'
</script>

<template>
<footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><Link href="/" class="nav-link px-2 text-body-secondary">Home</Link></li>
      <li class="nav-item"><Link href="/quiz" class="nav-link px-2 text-body-secondary">Quiz</Link></li>
      <li class="nav-item"><Link href="/questions" class="nav-link px-2 text-body-secondary">Questions</Link></li>
      
    </ul>
    <p class="text-center text-body-secondary">&copy; 2023 Company, Inc</p>
  </footer>
</template>