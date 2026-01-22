<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0B132B]">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-12 px-10 py-8 bg-[#F5F5DC] border border-[#D4AF37] shadow-lg overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
