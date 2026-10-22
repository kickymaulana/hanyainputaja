<script setup lang="ts">
import { computed, ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ArrowLeft, ArrowRight, Save } from '@lucide/vue'

interface Option { id: number; name: string }
interface Asset { id: number; category_id: number; description: string; location_id: number; department_id: number; brand_id: number | null; processor_id: number | null; memory_id: number | null; user_name: string | null; position_id: number | null; asset_condition_id: number; serial_number: string | null; acquisition_date: string | null; notes: string | null }
const props = withDefaults(defineProps<{ asset?: Asset; categories: Option[]; locations: Option[]; departments: Option[]; brands: Option[]; processors: Option[]; memories: Option[]; positions: Option[]; conditions: Option[] }>(), { asset: undefined })
const step = ref(1)
const editing = Boolean(props.asset)
const form = useForm({ category_id: props.asset?.category_id ?? '', description: props.asset?.description ?? '', location_id: props.asset?.location_id ?? '', department_id: props.asset?.department_id ?? '', brand_id: props.asset?.brand_id ?? '', processor_id: props.asset?.processor_id ?? '', memory_id: props.asset?.memory_id ?? '', user_name: props.asset?.user_name ?? '', position_id: props.asset?.position_id ?? '', asset_condition_id: props.asset?.asset_condition_id ?? '', serial_number: props.asset?.serial_number ?? '', acquisition_date: props.asset?.acquisition_date?.slice(0, 10) ?? '', notes: props.asset?.notes ?? '' })
const progress = computed(() => `${Math.round((step.value / 3) * 100)}%`)
function uppercase(field: 'description' | 'user_name' | 'serial_number' | 'notes'): void { form[field] = form[field].toUpperCase() }
function submit(): void { if (editing && props.asset) form.put(route('assets.update', props.asset.id)); else form.post(route('assets.store')) }
</script>

<template>
  <div class="min-h-screen pb-28">
    <header class="sticky top-0 z-10 border-b bg-white/95 px-4 py-4 backdrop-blur"><div class="mx-auto flex max-w-3xl items-center gap-3"><Link :href="editing && asset ? route('assets.show', asset.id) : route('assets.index')" class="rounded-xl p-2 text-muted-foreground"><ArrowLeft class="size-5" /></Link><div><p class="text-xs uppercase tracking-wider text-primary">Data Aset · Langkah {{ step }} dari 3</p><h1 class="text-xl font-bold">{{ editing ? 'Edit Aset' : 'Tambah Aset' }}</h1></div></div><div class="mx-auto mt-3 h-1.5 max-w-3xl overflow-hidden rounded-full bg-muted"><div class="h-full rounded-full bg-primary transition-all" :style="{ width: progress }"></div></div></header>
    <main class="mx-auto max-w-3xl px-4 py-6"><form @submit.prevent="submit">
      <section v-show="step === 1" class="space-y-5 rounded-3xl border bg-card p-5"><h2 class="font-semibold">Identitas aset</h2>
        <div><label class="mb-2 block text-sm font-medium">Kategori</label><select v-model="form.category_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih kategori</option><option v-for="item in categories" :key="item.id" :value="item.id">{{ item.name }}</option></select><p v-if="form.errors.category_id" class="mt-1 text-sm text-red-600">{{ form.errors.category_id }}</p></div>
        <div><label class="mb-2 block text-sm font-medium">Deskripsi atau spesifikasi</label><textarea v-model="form.description" rows="5" class="w-full rounded-xl border px-4 py-3" placeholder="SPESIFIKASI ASET" @input="uppercase('description')"></textarea><p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p></div>
        <div class="grid grid-cols-2 gap-3"><div><label class="mb-2 block text-sm font-medium">Merek</label><select v-model="form.brand_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih merek</option><option v-for="item in brands" :key="item.id" :value="item.id">{{ item.name }}</option></select><p v-if="form.errors.brand_id" class="mt-1 text-sm text-red-600">{{ form.errors.brand_id }}</p></div><div><label class="mb-2 block text-sm font-medium">Nomor seri</label><input v-model="form.serial_number" class="w-full rounded-xl border px-4 py-3" @input="uppercase('serial_number')"><p v-if="form.errors.serial_number" class="mt-1 text-sm text-red-600">{{ form.errors.serial_number }}</p></div></div>
      </section>
      <section v-show="step === 2" class="space-y-5 rounded-3xl border bg-card p-5"><h2 class="font-semibold">Spesifikasi dan lokasi</h2>
        <div class="grid grid-cols-2 gap-3"><div><label class="mb-2 block text-sm font-medium">Processor <span class="font-normal text-muted-foreground">(opsional)</span></label><select v-model="form.processor_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih processor</option><option v-for="item in processors" :key="item.id" :value="item.id">{{ item.name }}</option></select></div><div><label class="mb-2 block text-sm font-medium">Memory/RAM <span class="font-normal text-muted-foreground">(opsional)</span></label><select v-model="form.memory_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih memory</option><option v-for="item in memories" :key="item.id" :value="item.id">{{ item.name }}</option></select></div></div>
        <div><label class="mb-2 block text-sm font-medium">Lokasi</label><select v-model="form.location_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih lokasi</option><option v-for="item in locations" :key="item.id" :value="item.id">{{ item.name }}</option></select><p v-if="form.errors.location_id" class="mt-1 text-sm text-red-600">{{ form.errors.location_id }}</p></div>
        <div><label class="mb-2 block text-sm font-medium">Departemen</label><select v-model="form.department_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih departemen</option><option v-for="item in departments" :key="item.id" :value="item.id">{{ item.name }}</option></select><p v-if="form.errors.department_id" class="mt-1 text-sm text-red-600">{{ form.errors.department_id }}</p></div>
        <div><label class="mb-2 block text-sm font-medium">Kondisi aset</label><select v-model="form.asset_condition_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih kondisi</option><option v-for="item in conditions" :key="item.id" :value="item.id">{{ item.name }}</option></select><p v-if="form.errors.asset_condition_id" class="mt-1 text-sm text-red-600">{{ form.errors.asset_condition_id }}</p></div>
      </section>
      <section v-show="step === 3" class="space-y-5 rounded-3xl border bg-card p-5"><h2 class="font-semibold">Pengguna dan catatan</h2>
        <div><label class="mb-2 block text-sm font-medium">Pengguna</label><input v-model="form.user_name" class="w-full rounded-xl border px-4 py-3" @input="uppercase('user_name')"></div>
        <div><label class="mb-2 block text-sm font-medium">Jabatan</label><select v-model="form.position_id" class="w-full rounded-xl border px-4 py-3"><option value="">Pilih jabatan</option><option v-for="item in positions" :key="item.id" :value="item.id">{{ item.name }}</option></select></div>

        <div><label class="mb-2 block text-sm font-medium">Tanggal perolehan</label><input v-model="form.acquisition_date" type="date" class="w-full rounded-xl border px-4 py-3"></div>
        <div><label class="mb-2 block text-sm font-medium">Catatan</label><textarea v-model="form.notes" rows="4" class="w-full rounded-xl border px-4 py-3" @input="uppercase('notes')"></textarea></div>
      </section>
      <div class="mt-6 flex gap-3"><button v-if="step > 1" type="button" class="flex flex-1 items-center justify-center gap-2 rounded-xl border px-4 py-3 font-semibold" @click="step--"><ArrowLeft class="size-4" />Kembali</button><button v-if="step < 3" type="button" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 font-semibold text-primary-foreground" @click="step++">Lanjut<ArrowRight class="size-4" /></button><button v-else type="submit" :disabled="form.processing" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 font-semibold text-primary-foreground"><Save class="size-4" />{{ form.processing ? 'Menyimpan...' : 'Simpan aset' }}</button></div>
    </form></main>
  </div>
</template>
