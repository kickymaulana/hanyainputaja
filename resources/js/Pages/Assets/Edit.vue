<script setup lang="ts">
import Form from './Form.vue'
interface Option { id: number; name: string }
interface Asset { id: number; asset_code: string; category_id: number; description: string; location_id: number; factory_id: number | null; department_id: number; user_name: string | null; user_position: string | null; position_id: number | null; asset_status_id: number; asset_condition_id: number; serial_number: string | null; brand: string | null; acquisition_date: string | null; notes: string | null }
defineProps<{ asset: Asset; categories: Option[]; locations: Option[]; factories: Option[]; departments: Option[]; positions: Option[]; statuses: Option[]; conditions: Option[] }>()
</script>
<template><Form :asset="asset" :categories="categories" :locations="locations" :factories="factories" :departments="departments" :positions="positions" :statuses="statuses" :conditions="conditions" /></template>
