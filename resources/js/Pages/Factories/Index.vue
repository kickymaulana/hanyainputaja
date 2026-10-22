<script setup lang="ts">
import SimpleMasterIndex from '@/components/SimpleMasterIndex.vue'
interface Factory { id: number; name: string; is_active: boolean }
defineProps<{ factories: Factory[] }>()
</script>
<template><SimpleMasterIndex :items="factories" resource="factories" title="Pabrik" /></template>
