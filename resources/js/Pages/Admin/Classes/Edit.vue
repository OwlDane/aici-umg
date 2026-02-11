<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    classData: Object,
    programs: Array,
});

const form = useForm({
    program_id: props.classData.program_id,
    name: props.classData.name,
    description: props.classData.description,
    level: props.classData.level,
    price: props.classData.price,
    capacity: props.classData.capacity,
    is_active: props.classData.is_active === 1 || props.classData.is_active === true,
});

const submit = () => {
    form.put(route('admin.classes.update', props.classData.id));
};
</script>

<template>
    <Head title="Edit Class" />

    <AdminLayout>
        <template #header>
            Edit Class: {{ classData.name }}
        </template>

        <div class="max-w-2xl bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="program_id" value="Program" />
                    <select 
                        id="program_id"
                        v-model="form.program_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">Select Program</option>
                        <option v-for="program in programs" :key="program.id" :value="program.id">
                            {{ program.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.program_id" />
                </div>

                <div>
                    <InputLabel for="name" value="Class Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="level" value="Level" />
                    <select 
                        id="level"
                        v-model="form.level"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">Select Level</option>
                        <option value="beginner">Beginner</option>
                        <option value="elementary">Elementary</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.level" />
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
                        <InputLabel for="price" value="Price (IDR)" />
                        <TextInput
                            id="price"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.price"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>
                    <div>
                        <InputLabel for="capacity" value="Capacity (Students)" />
                        <TextInput
                            id="capacity"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.capacity"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.capacity" />
                    </div>
                </div>

                <div class="block">
                    <label class="flex items-center">
                        <Checkbox name="is_active" v-model:checked="form.is_active" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    <Link :href="route('admin.classes.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline mr-4">
                        Cancel
                    </Link>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update Class
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
