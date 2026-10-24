<script setup lang="ts">
import Form from './Form.vue'
interface Option { id: number; name: string }
interface Asset { id: number; category_id: number; description: string; location_id: number; department_id: number; brand_id: number | null; processor_id: number | null; memory_id: number | null; user_name: string | null; position_id: number | null; asset_condition_id: number; serial_number: string | null; acquisition_date: string | null; notes: string | null; photo_path: string | null }
defineProps<{ asset: Asset; categories: Option[]; locations: Option[]; departments: Option[]; brands: Option[]; processors: Option[]; memories: Option[]; positions: Option[]; conditions: Option[] }>()
</script>
<template><Form :asset="asset" :categories="categories" :locations="locations" :departments="departments" :brands="brands" :processors="processors" :memories="memories" :positions="positions" :conditions="conditions" /></template>
