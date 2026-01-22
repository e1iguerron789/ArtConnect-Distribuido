<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    intereses: Object,
    categorias: Array,
    opciones: Array,
});

// Valores iniciales
const categoriaSeleccionada = ref(props.intereses.opcion.categoria_interes_id);

const form = useForm({
    categoria_interes_id: categoriaSeleccionada.value,
    opcion_interes_id: props.intereses.opcion_interes_id,
});

// Filtrar opciones dependientes
const opcionesFiltradas = computed(() =>
    form.categoria_interes_id
        ? props.opciones.filter(o => o.categoria_interes_id == form.categoria_interes_id)
        : []
);

const submit = () => {
    form.patch(route('intereses.update', props.intereses.id));
};
</script>

<template>
    <GuestLayout>
        <div class="w-full sm:max-w-xl mt-8 px-10 py-8 bg-[#F5F5DC] border border-[#D4AF37] rounded-lg">

            <h1 class="text-2xl font-bold text-center">Editar interés</h1>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- Categoría -->
                <div>
                    <InputLabel value="Categoría artística" />
                    <select v-model="form.categoria_interes_id" class="mt-1 block w-full p-2 border rounded">
                        <option value="">Selecciona categoría</option>
                        <option v-for="c in props.categorias" :key="c.id" :value="c.id">
                            {{ c.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Opción -->
                <div>
                    <InputLabel value="Opción" />
                    <select v-model="form.opcion_interes_id" class="mt-1 block w-full p-2 border rounded">
                        <option value="">Selecciona opción</option>
                        <option v-for="op in opcionesFiltradas" :key="op.id" :value="op.id">
                            {{ op.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <Link :href="route('profile.edit')" class="px-4 py-2 bg-gray-600 text-white rounded">
                        Cancelar
                    </Link>

                    <PrimaryButton :disabled="form.processing">Guardar cambios</PrimaryButton>
                </div>

            </form>
        </div>
    </GuestLayout>
</template>
