<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    categorias: Array,
    opciones: Array,
});

// Lista de opciones seleccionadas
const seleccionadas = ref([]);

const form = useForm({
    opciones: [],   // ← ahora enviamos un arreglo de ids
});

const categoriaSeleccionada = ref("");

const opcionesFiltradas = computed(() =>
    categoriaSeleccionada.value
        ? props.opciones.filter(
            o => o.categoria_interes_id == categoriaSeleccionada.value
        )
        : []
);

// Agregar opción seleccionada
const agregarOpcion = (opcion) => {
    if (!seleccionadas.value.find(o => o.id === opcion.id)) {
        seleccionadas.value.push(opcion);
        form.opciones.push(opcion.id);
    }
};

// Quitar opción de la lista
const eliminarOpcion = (id) => {
    seleccionadas.value = seleccionadas.value.filter(o => o.id !== id);
    form.opciones = form.opciones.filter(o => o !== id);
};

const submit = () => form.post(route('intereses.store'));
</script>

<template>
    <GuestLayout>
        <div class="w-full sm:max-w-2xl mt-8 px-10 py-8 bg-[#F5F5DC] border border-[#D4AF37] rounded-lg">

            <h1 class="text-2xl font-bold text-center text-[#0B132B] mb-6">
                Selecciona tus intereses
            </h1>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- Categoría -->
                <div>
                    <InputLabel value="Categoría artística" />

                    <select v-model="categoriaSeleccionada"
                        class="mt-1 block w-full p-2 border rounded">
                        <option value="">Selecciona categoría</option>

                        <option v-for="c in props.categorias" :key="c.id" :value="c.id">
                            {{ c.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Opciones dependientes -->
                <div v-if="categoriaSeleccionada">
                    <InputLabel value="Opciones disponibles" />

                    <div class="space-y-2 mt-2">

                        <button
                            v-for="op in opcionesFiltradas"
                            :key="op.id"
                            type="button"
                            @click="agregarOpcion(op)"
                            class="w-full text-left p-2 border rounded bg-white hover:bg-gray-200"
                        >
                            {{ op.nombre }}
                        </button>

                    </div>
                </div>

                <!-- Lista de seleccionados -->
                <div v-if="seleccionadas.length > 0" class="mt-4">
                    <h2 class="font-bold text-lg">Intereses seleccionados:</h2>

                    <div class="space-y-2 mt-2">
                        <div
                            v-for="s in seleccionadas"
                            :key="s.id"
                            class="flex justify-between items-center p-2 bg-white border rounded"
                        >
                            <span>{{ s.nombre }}</span>

                            <button type="button" @click="eliminarOpcion(s.id)"
                                class="text-red-600 hover:underline">
                                Quitar
                            </button>
                        </div>
                    </div>
                </div>

                <InputError :message="form.errors.opciones" />

                <div class="text-center mt-6">
                    <PrimaryButton
                        :disabled="form.processing || form.opciones.length === 0"
                    >
                        Guardar intereses
                    </PrimaryButton>
                </div>

            </form>

        </div>
    </GuestLayout>
</template>
