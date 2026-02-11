<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    galleries: Object,
});

const deleteGallery = (id) => {
    if (confirm('Are you sure you want to delete this gallery item?')) {
        // Placeholder
    }
};
</script>

<template>
    <Head title="Gallery Management" />

    <AdminLayout>
        <template #header>
            Gallery Management
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Add New Card -->
            <button class="bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-8 flex flex-col items-center justify-center hover:border-indigo-500 transition-colors group">
                <svg class="h-12 w-12 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">Add New Item</span>
            </button>

            <!-- Gallery Items -->
            <div v-for="item in galleries.data" :key="item.id" class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden group relative">
                <img :src="item.image_url" :alt="item.title" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h4 class="font-bold text-gray-900 dark:text-white truncate">{{ item.title }}</h4>
                    <p class="text-xs text-gray-500 mt-1 capitalize">{{ item.category }}</p>
                </div>
                <!-- Actions Hover Overlay -->
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center space-x-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button class="p-2 bg-white rounded-full text-gray-900 hover:bg-indigo-600 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </button>
                    <button @click="deleteGallery(item.id)" class="p-2 bg-white rounded-full text-gray-900 hover:bg-red-600 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center" v-if="galleries.links.length > 3">
            <nav class="flex space-x-2">
                <Link 
                    v-for="link in galleries.links" 
                    :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    :class="[
                        link.active ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700',
                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                    ]"
                    class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm transition-colors"
                />
            </nav>
        </div>
    </AdminLayout>
</template>
