<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: ''
});

const submit = () => form.post('/admin/categorias-interes');
</script>

<template>
    <AdminLayout>

        <h2 class="text-2xl font-bold mb-6">Crear categoría</h2>

        <form @submit.prevent="submit" class="space-y-6">

            <div>
                <label class="font-semibold">Nombre</label>
                <input v-model="form.nombre"
                       class="w-full mt-1 p-2 border rounded border-[#D4AF37]" />
                <div class="text-red-600">{{ form.errors.nombre }}</div>
            </div>

            <button class="px-4 py-2 bg-[#D4AF37] text-[#0B132B] rounded hover:bg-[#c09a2f]">
                Guardar
            </button>
        </form>

    </AdminLayout>
</template>
