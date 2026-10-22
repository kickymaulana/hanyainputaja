<script setup lang="ts">
import Form from './Form.vue'
interface Option { id: number; name: string }
defineProps<{ categories: Option[]; locations: Option[]; departments: Option[]; brands: Option[]; processors: Option[]; memories: Option[]; positions: Option[]; conditions: Option[] }>()
</script>
<template><Form :categories="categories" :locations="locations" :departments="departments" :brands="brands" :processors="processors" :memories="memories" :positions="positions" :conditions="conditions" /></template>
