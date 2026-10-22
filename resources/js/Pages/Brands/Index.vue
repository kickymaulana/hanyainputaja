<script setup lang="ts">
import SimpleMasterIndex from '@/components/SimpleMasterIndex.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ brands: Item[] }>()
</script>
<template><SimpleMasterIndex :items="brands" resource="brands" title="Merek" /></template>
