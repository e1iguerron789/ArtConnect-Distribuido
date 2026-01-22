<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    intereses: Array
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Información del usuario -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <!-- Intereses -->
                <div class="mt-10 bg-[#F5F5DC] border border-[#D4AF37] shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">🎨 Mis intereses artísticos</h2>

                    <div v-if="!intereses || intereses.length === 0">
                        <p class="text-gray-700 mb-4">Aún no has seleccionado tus intereses.</p>

                        <Link
                            :href="route('intereses.create')"
                            class="bg-[#D4AF37] text-white px-4 py-2 rounded hover:bg-[#b8922e]"
                        >
                            Completar ahora
                        </Link>
                    </div>

                    <div v-else>
                        <div class="space-y-4">
                            <div v-for="item in intereses" :key="item.id"
                                 class="border-b border-gray-300 pb-2">

                                <p><strong>Categoría:</strong> {{ item.opcion?.categoria?.nombre }}</p>
                                <p><strong>Opción:</strong> {{ item.opcion?.nombre }}</p>

                                <!-- Botón ELIMINAR -->
                                <Link
                                    as="button"
                                    method="delete"
                                    :href="route('intereses.destroy', item.id)"
                                    class="text-red-600 hover:underline ml-0"
                                >
                                    Eliminar
                                </Link>
                            </div>
                        </div>

                        <!-- Botón crear más -->
                        <Link
                            :href="route('intereses.create')"
                            class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        >
                            Agregar más intereses
                        </Link>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
