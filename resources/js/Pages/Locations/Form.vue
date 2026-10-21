<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { ArrowLeft, Save } from '@lucide/vue'

interface Location { id: number; name: string; description: string | null; is_active: boolean }
interface LocationForm { name: string; description: string; is_active: boolean }
const props = withDefaults(defineProps<{ location?: Location }>(), { location: undefined })
const editing = Boolean(props.location)
const form = useForm<LocationForm>({ name: props.location?.name ?? '', description: props.location?.description ?? '', is_active: props.location?.is_active ?? true })
function submit(): void { if (editing && props.location) form.put(route('locations.update', props.location.id)); else form.post(route('locations.store')) }
</script>

<template>
  <div class="min-h-screen"><header class="border-b bg-white/95 px-4 py-4"><div class="mx-auto flex max-w-3xl items-center gap-3"><Link :href="route('locations.index')" class="rounded-xl p-2 text-muted-foreground hover:bg-muted"><ArrowLeft class="size-5" /></Link><div><p class="text-xs uppercase tracking-wider text-primary">Data Master</p><h1 class="text-xl font-bold">{{ editing ? 'Edit Lokasi' : 'Tambah Lokasi' }}</h1></div></div></header><main class="mx-auto max-w-3xl px-4 py-6"><form class="space-y-5 rounded-3xl border bg-card p-5 shadow-sm" @submit.prevent="submit"><div><label for="name" class="mb-2 block text-sm font-medium">Nama lokasi</label><input id="name" v-model="form.name" class="w-full rounded-xl border bg-background px-4 py-3 outline-none ring-primary focus:ring-2" placeholder="Contoh: OFFICE"><p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p></div><div><label for="description" class="mb-2 block text-sm font-medium">Deskripsi <span class="font-normal text-muted-foreground">(opsional)</span></label><textarea id="description" v-model="form.description" rows="4" class="w-full rounded-xl border bg-background px-4 py-3 outline-none ring-primary focus:ring-2" placeholder="Keterangan lokasi"></textarea><p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p></div><label class="flex items-center gap-3 rounded-xl border p-3"><input v-model="form.is_active" type="checkbox" class="size-5 accent-primary"><span class="text-sm">Lokasi aktif dan dapat dipilih saat input aset</span></label><button type="submit" :disabled="form.processing" class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 font-semibold text-primary-foreground disabled:opacity-60"><Save class="size-4" />{{ form.processing ? 'Menyimpan...' : 'Simpan lokasi' }}</button></form></main></div>
</template>
