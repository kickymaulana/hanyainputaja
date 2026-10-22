<script setup lang="ts">
import SimpleMasterIndex from '@/components/SimpleMasterIndex.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ processors: Item[] }>()
</script>
<template><SimpleMasterIndex :items="processors" resource="processors" title="Processor" /></template>
