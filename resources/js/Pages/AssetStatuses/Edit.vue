<script setup lang="ts">
import SimpleMasterForm from '@/components/SimpleMasterForm.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ status: Item }>()
</script>
<template><SimpleMasterForm :item="status" resource="asset-statuses" title="Status aset" /></template>
