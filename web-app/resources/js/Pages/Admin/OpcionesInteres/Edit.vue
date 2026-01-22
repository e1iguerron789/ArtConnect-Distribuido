<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    categorias: Array
});

const form = useForm({
    nombre: '',
    categoria_interes_id: ''
});

const submit = () => form.post('/admin/opciones-interes');
</script>

<template>
    <AdminLayout>

        <h2 class="text-2xl font-bold mb-6">Crear opción</h2>

        <form @submit.prevent="submit" class="space-y-6">

            <!-- Nombre -->
            <div>
                <label class="font-semibold">Nombre de la opción</label>
                <input v-model="form.nombre"
                       class="w-full mt-1 p-2 border rounded border-[#D4AF37]" />
                <div class="text-red-600">{{ form.errors.nombre }}</div>
            </div>

            <!-- Categoría -->
            <div>
                <label class="font-semibold">Categoría</label>
                <select v-model="form.categoria_interes_id"
                        class="w-full mt-1 p-2 border rounded border-[#D4AF37]">
                    <option value="">Selecciona categoría</option>

                    <option v-for="c in categorias" :key="c.id" :value="c.id">
                        {{ c.nombre }}
                    </option>
                </select>
                <div class="text-red-600">{{ form.errors.categoria_interes_id }}</div>
            </div>

            <!-- Botón -->
            <button class="px-4 py-2 bg-[#D4AF37] text-[#0B132B] rounded hover:bg-[#c09a2f]">
                Guardar
            </button>

        </form>

    </AdminLayout>
</template>
