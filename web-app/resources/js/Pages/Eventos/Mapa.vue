<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import axios from "axios";

// ================================
// PROPS DESDE LARAVEL
// ================================
const props = defineProps({
    eventos: Array,
    interesesUsuarioNombres: Array,
});

// Usamos copia modificable (porque props es readonly)
const eventosMapa = ref([...props.eventos]);

// ================================
// REFERENCIA AL MAPA
// ================================
const mapa = ref(null);

// ================================
// NORMALIZAR TEXTO
// ================================
function limpiarTexto(txt) {
    return String(txt)
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .trim()
        .toLowerCase();
}

// ================================
// INTERESES NORMALIZADOS
// ================================
const interesesNormalizados = ref([]);

// ================================
// ICONOS
// ================================
const iconoInteres = L.icon({
    iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png",
    shadowUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
});

const iconoOtro = L.icon({
    iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png",
    shadowUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
});

const iconoCercano = L.icon({
    iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png",
    shadowUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
});

// ================================
// DIBUJAR EVENTOS
// ================================
function dibujarEventos() {
    const map = mapa.value;
    if (!map) return;

    eventosMapa.value.forEach((ev) => {
        if (!ev?.latitud || !ev?.longitud) return;

        const opcion = ev?.opcion?.nombre
            ? limpiarTexto(ev.opcion.nombre)
            : null;

        const esDeInteres =
            opcion && interesesNormalizados.value.includes(opcion);

        const esCercano =
            typeof ev.distancia === "number" && ev.distancia < 5;

        // Selección de icono
        let iconoUsar = iconoOtro;
        if (esDeInteres) iconoUsar = iconoInteres;
        else if (esCercano) iconoUsar = iconoCercano;

        L.marker([ev.latitud, ev.longitud], { icon: iconoUsar })
            .addTo(map)
            .bindPopup(`
                <b>${ev.titulo}</b><br>
                🎭 ${ev?.categoria?.nombre ?? "Sin categoría"} - ${ev?.opcion?.nombre ?? "N/A"}<br>
                📅 ${ev.fecha ?? "Sin fecha"}<br>
                ⏰ ${ev.hora_inicio ?? ""} - ${ev.hora_fin ?? ""}<br>
                📍 ${ev.direccion_texto ?? ""}<br>
                📏 Distancia: ${
                    ev.distancia == null
                        ? "N/A"
                        : (Math.round(Number(ev.distancia) * 100) / 100) + " km"
                }<br><br>

                ${
                    esDeInteres
                        ? "<span style='color:#1e88e5;'>⭐ Relacionado con tus intereses</span>"
                        : esCercano
                        ? "<span style='color:#2e7d32;'>🟢 Evento cercano no relacionado con tus intereses</span>"
                        : "<span style='color:#c62828;'>Evento no relacionado con tus intereses ni tu ubicación</span>"
                }
            `);

    });
}

// ================================
// MOUNTED
// ================================
onMounted(() => {
    // Normalizar intereses del usuario
    interesesNormalizados.value = props.interesesUsuarioNombres.map((i) =>
        limpiarTexto(i)
    );

    // Crear mapa
    const map = L.map("mapaGeneral").setView([-0.1807, -78.4678], 13);
    mapa.value = map;

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "© OpenStreetMap",
    }).addTo(map);

    // Obtener ubicación del usuario
    if (navigator?.geolocation) {
        navigator.geolocation.getCurrentPosition(async (pos) => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            const iconoUsuario = L.icon({
                iconUrl: "https://cdn-icons-png.flaticon.com/512/6129/6129385.png",
                iconSize: [40, 40],
                iconAnchor: [20, 40],
            });

            L.marker([lat, lng], { icon: iconoUsuario })
                .addTo(map)
                .bindPopup("📍 Estás aquí");

            map.setView([lat, lng], 14);

            // Enviar coordenadas al backend
            try {
                  const res = await axios.post(route("eventos.mapa.post"), {

                    lat_usuario: lat,
                    lng_usuario: lng,
                });

                console.log("📦 EVENTOS ACTUALIZADOS:", res.data.eventos);

                eventosMapa.value = res.data.eventos;

                // Redibujar
                dibujarEventos();
            } catch (e) {
                console.error("Error enviando ubicación:", e);
            }
        });
    }

    // Dibujar eventos iniciales
    dibujarEventos();
});
</script>

<template>
    <Head title="Mapa de Eventos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-xl">Mapa de eventos</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white border shadow-md rounded-lg p-4">
                    <div id="mapaGeneral" class="w-full h-[600px] rounded-lg"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
#mapaGeneral {
    height: 600px;
}
</style>
