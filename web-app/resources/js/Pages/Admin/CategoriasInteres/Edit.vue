<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    categoria: Object
});

const form = useForm({
    nombre: props.categoria.nombre
});

const submit = () =>
    form.put(`/admin/categorias-interes/${props.categoria.id}`);
</script>

<template>
    <AdminLayout>

        <h2 class="text-2xl font-bold mb-6">Editar categoría</h2>

        <form @submit.prevent="submit" class="space-y-6">

            <div>
                <label class="font-semibold">Nombre</label>
                <input v-model="form.nombre"
                       class="w-full mt-1 p-2 border rounded border-[#D4AF37]" />
                <div class="text-red-600">{{ form.errors.nombre }}</div>
            </div>

            <button class="px-4 py-2 bg-[#D4AF37] text-[#0B132B] rounded hover:bg-[#c09a2f]">
                Guardar cambios
            </button>

        </form>

    </AdminLayout>
</template>
