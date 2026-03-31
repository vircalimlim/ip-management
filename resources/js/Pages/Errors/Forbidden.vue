<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 px-4">
    <div class="text-center">
      <h1 class="text-8xl font-extrabold text-red-600 mb-4">403</h1>
      <h2 class="text-3xl font-semibold text-gray-800 mb-2">Access Denied</h2>
      <p class="text-gray-600 mb-6">You don’t have permission to view this page.</p>
      <Link 
        href="/login" 
        class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition"
      >
        Back to Home
      </Link>
    </div>
  </div>
</template>