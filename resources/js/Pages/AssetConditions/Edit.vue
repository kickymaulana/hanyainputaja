<script setup lang="ts">
import SimpleMasterForm from '@/components/SimpleMasterForm.vue'
interface Item { id: number; name: string; is_active: boolean }
defineProps<{ condition: Item }>()
</script>
<template><SimpleMasterForm :item="condition" resource="asset-conditions" title="Kondisi aset" /></template>
