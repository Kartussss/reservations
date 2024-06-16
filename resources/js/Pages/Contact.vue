<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Contact" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-red-500 leading-tight">Contact</h2>
        </template>

        <div class="py-12">
            <div class="w-1/3 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" grid grid-cols-1 gap-4 p-6 text-gray-900">
                         <div> Snadnee</div>
                         <div>Svatopetrská 35/7,</div>
                         <div>Budova C,</div>
                         <div>Brno, Czech Republic</div>
                    </div>
                </div>
            </div>
            <div class="w-1/3  py-12 mx-auto sm:px-6 lg:px-8" >
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" grid grid-cols-1 gap-4 p-6 text-gray-900">
                        <div>Martin Komora</div>
                        <div>komora.marti@gmail.com</div>
                        <div>Vejrostova 953/6,</div>
                        <div>Brno, Czech Republic</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
