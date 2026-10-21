<script setup lang="ts">
import Form from './Form.vue'
interface Option { id: number; name: string }
defineProps<{ categories: Option[]; locations: Option[]; departments: Option[]; statuses: Option[]; conditions: Option[] }>()
</script>
<template><Form :categories="categories" :locations="locations" :departments="departments" :statuses="statuses" :conditions="conditions" /></template>
