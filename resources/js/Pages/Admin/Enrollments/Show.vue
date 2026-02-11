<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    enrollment: Object,
});

const processing = ref(false);

const updateStatus = (status) => {
    if (confirm(`Are you sure you want to change status to ${status}?`)) {
        processing.value = true;
        router.post(route('admin.enrollments.update-status', props.enrollment.id), { status }, {
            onFinish: () => processing.value = false,
        });
    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(value);
};

const getStatusBadgeClass = (status) => {
    switch (status) {
        case 'confirmed':
        case 'completed':
            return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
        case 'cancelled':
            return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
    }
};
</script>

<template>
    <Head title="Enrollment Details" />

    <AdminLayout>
        <template #header>
            Enrollment Details: {{ enrollment.student_name }}
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">General Information</h3>
                        <span :class="getStatusBadgeClass(enrollment.status)" class="px-3 py-1 text-xs font-bold rounded-full uppercase">
                            {{ enrollment.status }}
                        </span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Student Name</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ enrollment.student_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Student Email</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ enrollment.student_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Program</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ enrollment.class?.program?.name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Class & Level</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ enrollment.class?.name }} ({{ enrollment.class?.level }})</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registration Date</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ new Date(enrollment.created_at).toLocaleString() }}</p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-500">Placement Test Suggested Level</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ enrollment.metadata?.suggested_level || 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payments -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Payment History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="pay in enrollment.payments" :key="pay.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ pay.invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ pay.payment_method }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                        {{ formatCurrency(pay.amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="pay.status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'" class="px-2 py-1 text-xs font-semibold rounded-full uppercase">
                                            {{ pay.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        {{ pay.paid_at ? new Date(pay.paid_at).toLocaleDateString() : 'Unpaid' }}
                                    </td>
                                </tr>
                                <tr v-if="enrollment.payments.length === 0">
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No payment records found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                    <div class="space-y-3">
                        <button 
                            @click="updateStatus('confirmed')"
                            :disabled="processing || enrollment.status === 'confirmed'"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Confirm Enrollment
                        </button>
                        
                        <button 
                            @click="updateStatus('completed')"
                            :disabled="processing || enrollment.status === 'completed'"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Mark as Completed
                        </button>

                        <button 
                            @click="updateStatus('cancelled')"
                            :disabled="processing || enrollment.status === 'cancelled'"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Cancel Enrollment
                        </button>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Student Meta</h3>
                    <div class="text-xs space-y-1 text-gray-600 dark:text-gray-400">
                        <p>User ID: {{ enrollment.user_id }}</p>
                        <p>Class ID: {{ enrollment.class_id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
