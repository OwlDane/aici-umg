<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <div
        class="min-h-screen font-comfortaa text-foreground bg-background selection:bg-primary selection:text-white"
    >
        <!-- Navigation -->
        <nav
            class="fixed top-0 w-full z-50 bg-white shadow-sm border-b border-gray-100"
        >
            <div
                class="max-w-7xl mx-auto px-6 lg:px-12 py-4 flex justify-between items-center"
            >
                <!-- Logo -->
                <Link href="/" class="flex items-center">
                    <img
                        src="/images/logo/LogoAiCIColor.png"
                        alt="AICI Logo"
                        class="h-16 md:h-20 object-contain"
                    />
                </Link>

                <!-- Menu Links (Desktop) -->
                <div
                    class="hidden lg:flex items-center space-x-10 text-sm font-black text-gray-800"
                >
                    <Link
                        href="/"
                        class="hover:text-primary transition-colors"
                    >
                        Home
                    </Link>
                    <Link
                        href="/program"
                        class="hover:text-primary transition-colors"
                    >
                        Program
                    </Link>
                    <Link
                        href="/profile"
                        class="hover:text-primary transition-colors"
                    >
                        Profile
                    </Link>
                    <Link
                        href="/facility"
                        class="hover:text-primary transition-colors"
                    >
                        Facility
                    </Link>
                    <Link
                        href="/gallery"
                        class="hover:text-primary transition-colors"
                    >
                        Gallery
                    </Link>
                    <Link
                        href="/research"
                        class="hover:text-primary transition-colors"
                    >
                        Research
                    </Link>
                    <Link
                        href="/contact"
                        class="hover:text-primary transition-colors"
                    >
                        Contact
                    </Link>
                    <div class="relative group cursor-pointer flex items-center space-x-1 hover:text-primary transition-colors">
                        <Link
                            href="/articles"
                        >
                            Article
                        </Link>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    class="lg:hidden p-2 text-gray-800 hover:text-primary transition-colors"
                    @click="toggleMobileMenu"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
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

            <!-- Mobile Menu -->
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div
                    v-if="isMobileMenuOpen"
                    class="lg:hidden border-t border-gray-100 bg-white"
                >
                    <div class="px-6 py-4 space-y-3">
                        <Link
                            href="/"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Home
                        </Link>
                        <Link
                            href="/program"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Program
                        </Link>
                        <Link
                            href="/profile"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Profile
                        </Link>
                        <Link
                            href="/facility"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Facility
                        </Link>
                        <Link
                            href="/gallery"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Gallery
                        </Link>
                        <Link
                            href="/research"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Research
                        </Link>
                        <Link
                            href="/contact"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Contact
                        </Link>
                        <Link
                            href="/articles"
                            class="block py-2 text-sm font-black text-gray-800 hover:text-primary transition-colors"
                        >
                            Article
                        </Link>
                    </div>
                </div>
            </Transition>
        </nav>

        <!-- Page Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white pt-16 pb-8 px-4 md:px-12">
            <div
                class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12"
            >
                <!-- Branding & Contact -->
                <div class="space-y-6">
                    <img
                        src="/images/logo/LogoAiciWhite.png"
                        alt="AICI Logo"
                        class="h-16 object-contain"
                    />
                    <div class="text-sm font-semibold leading-relaxed">
                        <p class="mb-1">Artificial Intelligence Center Indonesia</p>
                        <p class="opacity-80 font-normal">
                            Pertamina Multidisciplinary Research Laboratory Building, 
                            Faculty of Mathematics and Natural Sciences, 
                            University of Indonesia, 4th Floor, Depok, West Java 16424
                        </p>
                        <p class="mt-4">Phone 0821-1010-3938</p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6 tracking-widest">PAGES</h4>
                    <ul class="space-y-4 text-sm font-semibold">
                        <li>
                            <Link href="/profile" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Profile
                            </Link>
                        </li>
                        <li>
                            <Link href="/facility" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Facility
                            </Link>
                        </li>
                        <li>
                            <Link href="/program" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Program
                            </Link>
                        </li>
                        <li>
                            <Link href="/contact" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Contact
                            </Link>
                        </li>
                        <li>
                            <Link href="/articles" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Latest Articles
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Programs -->
                <div>
                    <h4 class="text-lg font-bold mb-6 tracking-widest">DOWNLOAD</h4>
                    <ul class="space-y-4 text-sm font-semibold">
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Fun Learning
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Prompt Engineer Workshop
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                Extracurricular AI and Robotics
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                AI for Education
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                AI Day
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                AI Education Fair
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-center hover:text-accent transition-colors">
                                <span class="mr-2 opacity-50 transition-transform group-hover:translate-x-1">></span>
                                AI Talents
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div>
                    <h4 class="text-lg font-bold mb-6 tracking-widest">SOCIAL MEDIA</h4>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="text-white hover:text-accent transition-all hover:scale-110">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="text-white hover:text-accent transition-all hover:scale-110">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="#" class="text-white hover:text-accent transition-all hover:scale-110">
                            <span class="sr-only">Email</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12.713l-11.985-9.713h23.97l-11.985 9.713zm0 2.574l-12-9.725v15.438h24v-15.438l-12 9.725z"/></svg>
                        </a>
                        <a href="https://wa.me/6282110103938" target="_blank" class="text-white hover:text-accent transition-all hover:scale-110">
                            <span class="sr-only">WhatsApp</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .013 5.403.01 12.039c0 2.12.553 4.189 1.603 6.04L0 24l6.103-1.6c1.78.97 3.793 1.487 5.848 1.488 6.635 0 12.037-5.403 12.04-12.041a11.85 11.85 0 00-3.528-8.528z"/></svg>
                        </a>
                        <a href="tel:+6282110103938" class="text-white hover:text-accent transition-all hover:scale-110">
                            <span class="sr-only">Phone</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M2 3a1 1 0 0 1 1-1h2.153a1 1 0 0 1 .986.836l.74 4.435a1 1 0 0 1-.54 1.06l-1.548.773a11.037 11.037 0 0 0 4.739 4.74l.774-1.547a1 1 0 0 1 1.059-.54l4.435.74a1 1 0 0 1 .836.986V17a1 1 0 0 1-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div
                class="max-w-7xl mx-auto pt-8 border-t border-white/10 text-center text-xs opacity-60"
            >
                <p>
                    &copy; {{ new Date().getFullYear() }} AICI-UMG. All Rights
                    Reserved.
                </p>
            </div>
        </footer>

        <!-- Floating Action Buttons -->
        <div class="fixed bottom-8 left-8 z-40">
            <a
                href="https://wa.me/6282110103938"
                target="_blank"
                class="flex items-center space-x-2 bg-[#25D366] text-white p-3 rounded-full shadow-2xl hover:scale-110 transition-transform group"
            >
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .013 5.403.01 12.039c0 2.12.553 4.189 1.603 6.04L0 24l6.103-1.6c1.78.97 3.793 1.487 5.848 1.488 6.635 0 12.037-5.403 12.04-12.041a11.85 11.85 0 00-3.528-8.528z"/></svg>
                <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-500 text-xs font-bold whitespace-nowrap">
                    WhatsApp Us
                </span>
            </a>
        </div>
    </div>
</template>
