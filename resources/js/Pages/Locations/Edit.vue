<script setup lang="ts">
import Form from './Form.vue'
interface Location { id: number; name: string; description: string | null; is_active: boolean }
defineProps<{ location: Location }>()
</script>
<template><Form :location="location" /></template>
