<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Home - AICI-UMG" />

    <MainLayout>
        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center pt-20 pb-16 overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4 md:px-12 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-6 text-center lg:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-primary">
                            Indonesian<br />
                            <span class="text-secondary">Artificial Intelligence</span><br />
                            Center
                        </h1>
                        <p class="text-base md:text-lg text-gray-700 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Lembaga yang didirikan atas kerjasama FMIPA Universitas Indonesia dengan UMG IdeaLab Indonesia yang berfokus pada pengembangkan sumber daya manusia dalam bidang artificial intelligence (kecerdasan artifisial).
                        </p>
                        <div class="pt-4">
                            <Link
                                href="/program"
                                class="inline-block bg-secondary text-white px-8 py-4 rounded-lg font-bold hover:bg-secondary/90 transition-all shadow-lg"
                            >
                                Jelajahi Program
                            </Link>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="relative flex items-center justify-center">
                        <div class="w-full max-w-md aspect-square relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full blur-3xl"></div>
                            <img
                                src="/images/hero-image.jpg"
                                alt="AICI Showcase"
                                class="relative w-full h-full object-cover rounded-2xl shadow-2xl"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22400%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22400%22 height=%22400%22/%3E%3Ctext fill=%22%23255d74%22 font-family=%22sans-serif%22 font-size=%2224%22 text-anchor=%22middle%22 x=%22200%22 y=%22200%22%3EAICI%3C/text%3E%3C/svg%3E'"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Section -->
        <section id="program" class="py-20 px-4 md:px-12 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Program 1: Fun Learning -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-8 space-y-4">
                            <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-primary">
                                Fun Learning with AI untuk Siswa SD/MI, SMP/MTs dan SMA/MA/SMK
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Kegiatan belajar yang diselenggarakan oleh AiCI bertujuan untuk memperkenalkan dan meningkatkan pengetahuan serta keterampilan peserta didik dalam bidang Artificial Intelligence …
                            </p>
                        </div>
                    </div>

                    <!-- Program 2: AI for Education -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-8 space-y-4">
                            <div class="w-16 h-16 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-primary">
                                AI for Education
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Kegiatan pelatihan implementasi AI dalam bidang pendidikan untuk Guru dan Dosen. Bertujuan untuk meningkatkan pengetahuan, keterampilan, serta melatih kemampuan guru dan dosen dalam mengembangkan pembelajaran artificial intelligence …
                            </p>
                        </div>
                    </div>

                    <!-- Program 3: AI Day -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-8 space-y-4">
                            <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-primary">
                                AI Day
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                AI Day merupakan sebuah kegiatan yang dilaksanakan selama satu hari dengan tujuan untuk menumbuhkan minat, pengetahuan, dan keterampilan peserta didik dalam bidang artificial intelligence dengan cara yang menyenangkan (fun learning) …
                            </p>
                        </div>
                    </div>

                    <!-- Program 4: AI Edu Fair -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-8 space-y-4">
                            <div class="w-16 h-16 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-primary">
                                AI Edu Fair
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Sebuah kegiatan yang dilaksanakan selama satu hari dengan tujuan untuk menumbuhkan rasa ingin tahu, pengetahuan, dan keterampilan peserta didik dalam bidang artificial intelligence. Selain itu, pada kegiatan ini dikembangkan juga beberapa soft skills …
                            </p>
                        </div>
                    </div>

                    <!-- Program 5: AI Talents -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow md:col-span-2 lg:col-span-1">
                        <div class="p-8 space-y-4">
                            <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-primary">
                                Preparing Artificial Intelligence (AI) Talents
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Merupakan program PT Artifisial Intelegensia Indonesia (AiCI) bekerjasama dengan Departemen Fisika FMIPA UI dan beberapa praktisi dalam lingkungan kerja start-up dan industri dalam bentuk Studi Independen Bersertifikat Kampus Merdeka …
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Detail Program Button -->
                <div class="text-center mt-12">
                    <Link
                        href="/program"
                        class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-primary/90 transition-all shadow-lg"
                    >
                        Detail Program
                    </Link>
                </div>
            </div>
        </section>

        <!-- Video Profile & Logo Section -->
        <section class="py-20 px-4 md:px-12 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                    <!-- Video Profile (2 columns) -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="aspect-video w-full rounded-xl overflow-hidden shadow-2xl">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/T55aRq874NM"
                                title="AICI Profile Video"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>

                    <!-- Logo & Virtual Tour (1 column) -->
                    <div class="space-y-8">
                        <!-- Logos -->
                        <div class="bg-gray-50 rounded-xl p-8 space-y-6">
                            <div class="space-y-6">
                                <div class="flex items-center justify-center">
                                    <img
                                        src="/images/logo/logo_umg.png"
                                        alt="UMG IdeaLab"
                                        class="h-20 object-contain"
                                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22100%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22200%22 height=%22100%22/%3E%3Ctext fill=%22%23255d74%22 font-family=%22sans-serif%22 font-size=%2214%22 text-anchor=%22middle%22 x=%22100%22 y=%2255%22%3EUMG IdeaLab%3C/text%3E%3C/svg%3E'"
                                    />
                                </div>
                                <div class="flex items-center justify-center">
                                    <img
                                        src="/images/logo/logo_fmipa.png"
                                        alt="FMIPA UI"
                                        class="h-20 object-contain"
                                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22100%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22200%22 height=%22100%22/%3E%3Ctext fill=%22%23255d74%22 font-family=%22sans-serif%22 font-size=%2214%22 text-anchor=%22middle%22 x=%22100%22 y=%2255%22%3EFMIPA UI%3C/text%3E%3C/svg%3E'"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Virtual Tour -->
                        <div class="bg-gradient-to-br from-primary to-primary/80 rounded-xl p-8 text-white text-center space-y-4 hover:shadow-xl transition-shadow">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-xl font-bold">
                                AICI Virtual Tour
                            </h3>
                            <p class="text-sm opacity-90">
                                Jelajahi fasilitas AICI secara virtual
                            </p>
                            <button class="bg-white text-primary px-6 py-2 rounded-lg font-bold hover:bg-gray-100 transition-all mt-4">
                                Mulai Tour
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facilities Section -->
        <section class="py-20 px-4 md:px-12 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                        Fasilitas yang disediakan
                    </h2>
                    <p class="text-gray-600 max-w-3xl mx-auto">
                        Untuk mendukung kegiatan di AiCI, tersedia fasilitas-fasilitas berupa ruangan, lab AI sebanyak 6 ruang, media pembelajaran/ pelatihan berupa kit dan robot, modul pembelajaran tingkat SD/MI, SMP/MTs dan SMA/MA/SMK serta Perguruan Tinggi.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <!-- Facility 1 -->
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center space-y-4">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-primary">Ruangan</h3>
                        <p class="text-sm text-gray-600">Ruang belajar yang nyaman dan modern</p>
                    </div>

                    <!-- Facility 2 -->
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center space-y-4">
                        <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-primary">Lab AI</h3>
                        <p class="text-sm text-gray-600">6 ruang laboratorium AI lengkap</p>
                    </div>

                    <!-- Facility 3 -->
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center space-y-4">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-primary">AI Kit & Robot</h3>
                        <p class="text-sm text-gray-600">Media pembelajaran interaktif</p>
                    </div>

                    <!-- Facility 4 -->
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center space-y-4">
                        <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-primary">Modul Pembelajaran</h3>
                        <p class="text-sm text-gray-600">Untuk semua tingkat pendidikan</p>
                    </div>
                </div>

                <div class="text-center">
                    <Link
                        href="/facility"
                        class="inline-block bg-secondary text-white px-8 py-3 rounded-lg font-bold hover:bg-secondary/90 transition-all shadow-lg"
                    >
                        Selengkapnya
                    </Link>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-20 px-4 md:px-12 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                        Testimonials
                    </h2>
                    <p class="text-gray-600">
                        What Do They Think After Studying at AiCI?
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Testimonial 1: Kahfi -->
                    <div class="bg-gray-50 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col items-center text-center space-y-4">
                            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">K</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary">Kahfi</h4>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Siswa SD</p>
                            </div>
                            <p class="text-sm text-gray-600 italic leading-relaxed">
                                "Cool!"
                            </p>
                        </div>
                    </div>

                    <!-- Testimonial 2: Sachio -->
                    <div class="bg-gray-50 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col items-center text-center space-y-4">
                            <div class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-secondary">S</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary">Sachio</h4>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Siswa SMP</p>
                            </div>
                            <p class="text-sm text-gray-600 italic leading-relaxed">
                                "Hi Tech, robots and AI are our future, because now technology is increasingly being used"
                            </p>
                        </div>
                    </div>

                    <!-- Testimonial 3: Aulia -->
                    <div class="bg-gray-50 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col items-center text-center space-y-4">
                            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-primary">A</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary">Aulia</h4>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Siswa SMA</p>
                            </div>
                            <p class="text-sm text-gray-600 italic leading-relaxed">
                                "The problem is that the world in the future will also be more sophisticated than now, there will definitely be many more"
                            </p>
                        </div>
                    </div>

                    <!-- Testimonial 4: Sandhya -->
                    <div class="bg-gray-50 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col items-center text-center space-y-4">
                            <div class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-secondary">S</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary">Sandhya</h4>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Siswa SD</p>
                            </div>
                            <p class="text-sm text-gray-600 italic leading-relaxed">
                                "Cool, That's Clever!"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
