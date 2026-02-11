<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    program: Object,
});

const form = useForm({
    name: props.program.name,
    description: props.program.description,
    category: props.program.category,
    min_age: props.program.min_age,
    max_age: props.program.max_age,
    is_active: props.program.is_active === 1 || props.program.is_active === true,
});

const submit = () => {
    form.put(route('admin.programs.update', props.program.id));
};
</script>

<template>
    <Head title="Edit Program" />

    <AdminLayout>
        <template #header>
            Edit Program: {{ program.name }}
        </template>

        <div class="max-w-2xl bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="name" value="Program Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="category" value="Category" />
                    <select 
                        id="category"
                        v-model="form.category"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">Select Category</option>
                        <option value="robotics">Robotics</option>
                        <option value="coding">Coding</option>
                        <option value="ai">Artificial Intelligence</option>
                        <option value="iot">Internet of Things</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.category" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />
                    <textarea
                        id="description"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        v-model="form.description"
                        rows="4"
                        required
                    ></textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="min_age" value="Minimum Age" />
                        <TextInput
                            id="min_age"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.min_age"
                        />
                        <InputError class="mt-2" :message="form.errors.min_age" />
                    </div>
                    <div>
                        <InputLabel for="max_age" value="Maximum Age" />
                        <TextInput
                            id="max_age"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.max_age"
                        />
                        <InputError class="mt-2" :message="form.errors.max_age" />
                    </div>
                </div>

                <div class="block">
                    <label class="flex items-center">
                        <Checkbox name="is_active" v-model:checked="form.is_active" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    <Link :href="route('admin.programs.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline mr-4">
                        Cancel
                    </Link>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update Program
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
