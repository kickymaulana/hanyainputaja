<script setup lang="ts">
import SimpleMasterForm from '@/components/SimpleMasterForm.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ processor: Item }>()
</script>
<template><SimpleMasterForm :item="processor" resource="processors" title="Processor" /></template>
