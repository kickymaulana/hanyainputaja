<script setup lang="ts">
import SimpleMasterIndex from '@/components/SimpleMasterIndex.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ statuses: Item[] }>()
</script>
<template><SimpleMasterIndex :items="statuses" resource="asset-statuses" title="Status Aset" /></template>
