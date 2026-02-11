<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const showingSidebar = ref(true);

const navItems = [
    {
        name: "Dashboard",
        href: route("admin.dashboard"),
        icon: "dashboard",
        active: route().current("admin.dashboard"),
    },
    { name: 'Programs', href: route('admin.programs.index'), icon: 'programs', active: route().current('admin.programs.*') },
    { name: 'Classes', href: route('admin.classes.index'), icon: 'classes', active: route().current('admin.classes.*') },
    { name: 'Questions', href: route('admin.questions.index'), icon: 'questions', active: route().current('admin.questions.*') },
    { name: 'Enrollments', href: route('admin.enrollments.index'), icon: 'enrollments', active: route().current('admin.enrollments.*') },
    { name: 'Articles', href: route('admin.content.articles.index'), icon: 'articles', active: route().current('admin.content.articles.*') },
    { name: 'Gallery', href: route('admin.content.gallery.index'), icon: 'gallery', active: route().current('admin.content.gallery.*') },
    { name: 'Facilities', href: route('admin.content.facilities.index'), icon: 'facilities', active: route().current('admin.content.facilities.*') },
];
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        <!-- Sidebar -->
        <aside
            :class="showingSidebar ? 'w-64' : 'w-20'"
            class="transition-all duration-300 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col fixed h-full z-50"
        >
            <div
                class="h-16 flex items-center justify-between px-4 overflow-hidden"
            >
                <Link
                    :href="route('admin.dashboard')"
                    class="flex items-center"
                >
                    <ApplicationLogo
                        class="h-8 w-auto fill-current text-indigo-600"
                    />
                    <span
                        v-if="showingSidebar"
                        class="ml-3 font-bold text-xl text-gray-800 dark:text-white whitespace-nowrap"
                        >Admin AICI</span
                    >
                </Link>
                <button
                    @click="showingSidebar = !showingSidebar"
                    class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <svg
                        class="h-6 w-6 text-gray-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 mt-4 px-2 space-y-1">
                <Link
                    v-for="item in navItems"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        item.active
                            ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400'
                            : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700',
                    ]"
                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors"
                    :title="!showingSidebar ? item.name : ''"
                >
                    <div class="w-6 h-6 flex-shrink-0 mr-3">
                        <!-- Simple placeholder icons using SVG -->
                        <svg
                            v-if="item.icon === 'dashboard'"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                stroke-width="2"
                            />
                        </svg>
                        <svg
                            v-else
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                stroke-width="2"
                            />
                        </svg>
                    </div>
                    <span v-if="showingSidebar" class="whitespace-nowrap">{{
                        item.name
                    }}</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <Dropdown align="top" width="48">
                    <template #trigger>
                        <button class="flex items-center w-full text-left">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold"
                            >
                                {{ $page.props.auth.user.name.charAt(0) }}
                            </div>
                            <div
                                v-if="showingSidebar"
                                class="ml-3 overflow-hidden"
                            >
                                <p
                                    class="text-xs font-medium text-gray-700 dark:text-gray-200 truncate"
                                >
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p class="text-[10px] text-gray-500 truncate">
                                    Administrator
                                </p>
                            </div>
                        </button>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('profile.edit')"
                            >Profile</DropdownLink
                        >
                        <DropdownLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                            >Log Out</DropdownLink
                        >
                    </template>
                </Dropdown>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main
            :class="showingSidebar ? 'ml-64' : 'ml-20'"
            class="flex-1 transition-all duration-300"
        >
            <header
                class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center px-8 justify-between sticky top-0 z-40"
            >
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    <slot name="header" />
                </h2>

                <div class="flex items-center space-x-4">
                    <!-- Notifications, search, etc could go here -->
                    <Link
                        href="/"
                        class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400"
                        >View Site</Link
                    >
                </div>
            </header>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>
