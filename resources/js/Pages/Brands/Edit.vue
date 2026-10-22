<script setup lang="ts">
import SimpleMasterForm from '@/components/SimpleMasterForm.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ brand: Item }>()
</script>
<template><SimpleMasterForm :item="brand" resource="brands" title="Merek" /></template>
