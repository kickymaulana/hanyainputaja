<script setup lang="ts">
import SimpleMasterForm from '@/components/SimpleMasterForm.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ memory: Item }>()
</script>
<template><SimpleMasterForm :item="memory" resource="memories" title="Memory/RAM" /></template>
