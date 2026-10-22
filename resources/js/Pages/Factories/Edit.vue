<script setup lang="ts">
import SimpleMasterForm from '@/components/SimpleMasterForm.vue'
interface Factory { id: number; name: string; is_active: boolean }
defineProps<{ factory: Factory }>()
</script>
<template><SimpleMasterForm :item="factory" resource="factories" title="Pabrik" /></template>
