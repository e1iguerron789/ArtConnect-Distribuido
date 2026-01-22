<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    intereses: Array,
});
</script>

<template>
    <div class="p-6 text-white">

        <h1 class="text-xl font-bold mb-4">Mis intereses</h1>

        <!-- Si NO tiene intereses -->
        <div v-if="!intereses || intereses.length === 0">
            <p>No tienes intereses registrados.</p>

            <Link
                :href="route('intereses.create')"
                class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded"
            >
                Agregar intereses
            </Link>
        </div>

        <!-- Si SÍ tiene intereses -->
        <div v-else class="space-y-4">

            <!-- Botón agregar/editar -->
            <Link
                :href="route('intereses.create')"
                class="inline-block px-4 py-2 bg-green-600 text-white rounded mb-4"
            >
                Editar mis intereses
            </Link>

            <div
                v-for="i in intereses"
                :key="i.id"
                class="p-4 bg-gray-800 rounded shadow"
            >
                <p>
                    <strong>Categoría:</strong>
                    {{ i.opcion?.categoria?.nombre ?? 'Sin categoría' }}
                </p>

                <p>
                    <strong>Opción:</strong>
                    {{ i.opcion?.nombre ?? 'No especificado' }}
                </p>
            </div>

            <!-- Botón eliminar todos -->
            <Link
                as="button"
                method="delete"
                :href="route('intereses.destroyAll')"
                class="mt-4 px-4 py-2 bg-red-600 text-white rounded inline-block"
                onclick="return confirm('¿Seguro que deseas eliminar todos tus intereses?');"
            >
                Eliminar todos los intereses
            </Link>

        </div>

    </div>
</template>
