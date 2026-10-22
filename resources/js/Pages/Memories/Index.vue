<script setup lang="ts">
import SimpleMasterIndex from '@/components/SimpleMasterIndex.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ memories: Item[] }>()
</script>
<template><SimpleMasterIndex :items="memories" resource="memories" title="Memory/RAM" /></template>
