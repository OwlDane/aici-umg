<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    question_text: '',
    options: ['', '', '', ''],
    correct_answer: '',
    points: 10,
    level: 'beginner',
    is_active: true,
});

const addOption = () => {
    form.options.push('');
};

const removeOption = (index) => {
    if (form.options.length > 2) {
        form.options.splice(index, 1);
    }
};

const submit = () => {
    form.post(route('admin.questions.store'));
};
</script>

<template>
    <Head title="Create Question" />

    <AdminLayout>
        <template #header>
            Create New Question
        </template>

        <div class="max-w-3xl bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="question_text" value="Question Text" />
                    <textarea
                        id="question_text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        v-model="form.question_text"
                        rows="3"
                        required
                    ></textarea>
                    <InputError class="mt-2" :message="form.errors.question_text" />
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <InputLabel for="level" value="Target Level" />
                        <select 
                            id="level"
                            v-model="form.level"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="beginner">Beginner</option>
                            <option value="elementary">Elementary</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.level" />
                    </div>
                    <div>
                        <InputLabel for="points" value="Points" />
                        <TextInput
                            id="points"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.points"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.points" />
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <InputLabel value="Answe Options" />
                        <button type="button" @click="addOption" class="text-xs text-indigo-600 hover:text-indigo-500 font-bold">+ Add Option</button>
                    </div>
                    
                    <div v-for="(option, index) in form.options" :key="index" class="flex items-center space-x-2">
                        <input 
                            type="radio" 
                            v-model="form.correct_answer" 
                            :value="form.options[index]"
                            class="text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300"
                            required
                            title="Mark as correct answer"
                        />
                        <TextInput
                            type="text"
                            class="block w-full"
                            v-model="form.options[index]"
                            :placeholder="'Option ' + (index + 1)"
                            required
                        />
                        <button 
                            type="button" 
                            @click="removeOption(index)" 
                            v-if="form.options.length > 2"
                            class="text-red-500 hover:text-red-700"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 italic">Select the radio button next to the correct answer.</p>
                    <InputError class="mt-2" :message="form.errors.options" />
                    <InputError class="mt-2" :message="form.errors.correct_answer" />
                </div>

                <div class="block">
                    <label class="flex items-center">
                        <Checkbox name="is_active" v-model:checked="form.is_active" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    <Link :href="route('admin.questions.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline mr-4">
                        Cancel
                    </Link>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create Question
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
