<script setup>
import { ref, computed, onMounted } from "vue";
import { useForm, Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import L from "leaflet";
import "leaflet/dist/leaflet.css";

// Props que vienen del backend
const props = defineProps({
    categorias: Array,
    opciones: Array,
});

// Formulario del evento
const form = useForm({
    titulo: "",
    descripcion: "",
    fecha: "",
    hora_inicio: "",
    hora_fin: "",
    direccion_texto: "",
    latitud: "",
    longitud: "",
    categoria_interes_id: "",
    opcion_interes_id: "",
});

// Mapa y marcador
const mapa = ref(null);
const marcador = ref(null);

const iniciarMapa = () => {
    if (mapa.value) return; // evita que se inicialice dos veces

    mapa.value = L.map("mapaEvento").setView([-0.1807, -78.4678], 13); // Quito

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
    }).addTo(mapa.value);

    marcador.value = L.marker([-0.1807, -78.4678], { draggable: true }).addTo(mapa.value);

    marcador.value.on("dragend", function () {
        const pos = marcador.value.getLatLng();
        form.latitud = pos.lat;
        form.longitud = pos.lng;
    });
};

// Filtrar opciones según categoría elegida
const opcionesFiltradas = computed(() => {
    return form.categoria_interes_id
        ? props.opciones.filter(o => o.categoria_interes_id == form.categoria_interes_id)
        : [];
});

// Iniciar mapa cuando el componente carga
onMounted(() => {
    iniciarMapa();
});
</script>

<template>
    <Head title="Crear Evento" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Evento</h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-[#F5F5DC] border border-[#D4AF37] shadow-lg rounded-lg p-8">

                    <h1 class="text-2xl font-bold text-[#0B132B] mb-6">📍 Nuevo Evento</h1>

                    <form @submit.prevent="form.post(route('eventos.store'))" class="space-y-6">

                        <!-- Título -->
                        <div>
                            <InputLabel value="Título del evento" />
                            <input type="text" v-model="form.titulo" class="w-full p-2 border rounded" />
                            <InputError :message="form.errors.titulo" />
                        </div>

                        <!-- Descripción -->
                        <div>
                            <InputLabel value="Descripción" />
                            <textarea v-model="form.descripcion" class="w-full p-2 border rounded"></textarea>
                            <InputError :message="form.errors.descripcion" />
                        </div>

                        <!-- Categoría -->
                        <div>
                            <InputLabel value="Categoría artística" />
                            <select v-model="form.categoria_interes_id" class="w-full p-2 border rounded">
                                <option value="">Selecciona una categoría</option>
                                <option v-for="c in categorias" :key="c.id" :value="c.id">{{ c.nombre }}</option>
                            </select>
                            <InputError :message="form.errors.categoria_interes_id" />
                        </div>

                        <!-- Opción artística -->
                        <div v-if="form.categoria_interes_id">
                            <InputLabel value="Opciones disponibles" />
                            <select v-model="form.opcion_interes_id" class="w-full p-2 border rounded">
                                <option value="">Selecciona una opción</option>
                                <option v-for="o in opcionesFiltradas" :key="o.id" :value="o.id">
                                    {{ o.nombre }}
                                </option>
                            </select>
                            <InputError :message="form.errors.opcion_interes_id" />
                        </div>

                        <!-- Fecha -->
                        <div>
                            <InputLabel value="Fecha" />
                            <input type="date" v-model="form.fecha" class="w-full p-2 border rounded" />
                            <InputError :message="form.errors.fecha" />
                        </div>

                        <!-- Horario -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel value="Hora de inicio" />
                                <input type="time" v-model="form.hora_inicio" class="w-full p-2 border rounded" />
                                <InputError :message="form.errors.hora_inicio" />
                            </div>

                            <div>
                                <InputLabel value="Hora de fin" />
                                <input type="time" v-model="form.hora_fin" class="w-full p-2 border rounded" />
                                <InputError :message="form.errors.hora_fin" />
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div>
                            <InputLabel value="Dirección (texto)" />
                            <input type="text" v-model="form.direccion_texto" class="w-full p-2 border rounded"
                                   placeholder="Ej: Teatro Sucre, Quito" />
                            <InputError :message="form.errors.direccion_texto" />
                        </div>

                        <!-- Mapa -->
                        <div>
                            <InputLabel value="Ubicación en el mapa" />
                            <div id="mapaEvento" class="w-full h-80 rounded"></div>

                            <p class="text-sm text-gray-600 mt-2">Arrastra el marcador al lugar exacto.</p>

                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <InputLabel value="Latitud" />
                                    <input type="text" v-model="form.latitud" class="w-full p-2 border rounded" readonly />
                                </div>
                                <div>
                                    <InputLabel value="Longitud" />
                                    <input type="text" v-model="form.longitud" class="w-full p-2 border rounded" readonly />
                                </div>
                            </div>
                        </div>

                        <!-- BOTÓN -->
                        <div class="text-right">
                            <PrimaryButton :disabled="form.processing">
                                Crear evento
                            </PrimaryButton>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style>
#mapaEvento {
    height: 350px;
    border: 2px solid #D4AF37;
}
</style>
