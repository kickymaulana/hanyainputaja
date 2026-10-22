<script setup lang="ts">
import Form from './Form.vue'
interface Option { id: number; name: string }
defineProps<{ categories: Option[]; locations: Option[]; factories: Option[]; departments: Option[]; positions: Option[]; statuses: Option[]; conditions: Option[] }>()
</script>
<template><Form :categories="categories" :locations="locations" :factories="factories" :departments="departments" :positions="positions" :statuses="statuses" :conditions="conditions" /></template>
