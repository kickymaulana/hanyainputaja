<script setup lang="ts">
import SimpleMasterIndex from '@/components/SimpleMasterIndex.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ conditions: Item[] }>()
</script>
<template><SimpleMasterIndex :items="conditions" resource="asset-conditions" title="Kondisi Aset" /></template>
