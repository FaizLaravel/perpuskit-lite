<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const message = computed(() => page.props.flash?.message || '');

const features = [
    {
        name: 'CRUD Buku',
        lite: 'Max 20 buku',
        full: 'Unlimited',
        icon: '📚',
    },
    {
        name: 'CRUD User',
        lite: 'Max 5 user',
        full: 'Unlimited',
        icon: '👥',
    },
    {
        name: 'Pengajuan Peminjaman',
        lite: '1x saja',
        full: 'Unlimited',
        icon: '📖',
    },
    {
        name: 'Persetujuan Peminjaman',
        lite: '❌ Locked',
        full: '✅ Full Access',
        icon: '✅',
    },
    {
        name: 'Pengembalian Buku',
        lite: '❌ Locked',
        full: '✅ Full Access',
        icon: '📤',
    },
    {
        name: 'Perpanjangan Peminjaman',
        lite: '❌ Locked',
        full: '✅ Full Access',
        icon: '🔄',
    },
    {
        name: 'Input Pembayaran Denda',
        lite: '❌ Locked',
        full: '✅ Full Access',
        icon: '💰',
    },
    {
        name: 'Export Laporan PDF',
        lite: '❌ Locked',
        full: '✅ Full Access',
        icon: '📄',
    },
    {
        name: 'Dashboard Advanced',
        lite: '❌ Locked',
        full: '✅ Full Access',
        icon: '📊',
    },
];
</script>

<template>
    <Head title="Upgrade ke Full Plan" />

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    Upgrade ke Full Plan
                </h1>
                <p class="text-lg text-gray-600">
                    Dapatkan akses penuh ke semua fitur PerpusKit
                </p>
            </div>

            <!-- Message Alert -->
            <div
                v-if="message"
                class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg"
            >
                {{ message }}
            </div>

            <!-- Pricing Cards -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Lite Plan -->
                <div class="bg-white rounded-lg shadow-md p-6 border-2 border-gray-200">
                    <div class="text-center mb-4">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Lite Plan</h3>
                        <div class="text-4xl font-bold text-gray-900 mb-1">Gratis</div>
                        <p class="text-sm text-gray-500">GitHub Preview</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">✅</span>
                            <span class="text-sm text-gray-600">CRUD Kategori (Full)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">✅</span>
                            <span class="text-sm text-gray-600">CRUD Buku (Max 20)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">✅</span>
                            <span class="text-sm text-gray-600">CRUD User (Max 5)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">✅</span>
                            <span class="text-sm text-gray-600">Dashboard Basic</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">✅</span>
                            <span class="text-sm text-gray-600">Pengajuan (1x)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-gray-400 mr-2">👁️</span>
                            <span class="text-sm text-gray-600">Status/Riwayat (Read-only)</span>
                        </li>
                    </ul>
                </div>

                <!-- Full Plan -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 border-2 border-blue-400 transform scale-105">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mb-2">
                            RECOMMENDED
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Full Plan</h3>
                        <div class="text-4xl font-bold text-white mb-1">$79</div>
                        <p class="text-sm text-blue-100">One-time payment</p>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <span class="text-white mr-2">✅</span>
                            <span class="text-sm text-white">Semua fitur Lite (Unlimited)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2">✅</span>
                            <span class="text-sm text-white">Persetujuan & Pengembalian</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2">✅</span>
                            <span class="text-sm text-white">Perpanjangan Peminjaman</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2">✅</span>
                            <span class="text-sm text-white">Input Pembayaran Denda</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2">✅</span>
                            <span class="text-sm text-white">Export Laporan PDF</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2">✅</span>
                            <span class="text-sm text-white">Dashboard Advanced</span>
                        </li>
                    </ul>
                    <button
                        class="w-full bg-white text-blue-600 font-bold py-3 px-6 rounded-lg hover:bg-blue-50 transition-colors"
                        @click="alert('Hubungi admin untuk upgrade')"
                    >
                        Upgrade Sekarang
                    </button>
                </div>
            </div>

            <!-- Feature Comparison Table -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                    Perbandingan Fitur
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-900">Fitur</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-900">Lite</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-900">Full</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(feature, index) in features"
                                :key="index"
                                class="border-b border-gray-100 hover:bg-gray-50"
                            >
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <span class="text-xl mr-2">{{ feature.icon }}</span>
                                        <span class="font-medium text-gray-900">{{ feature.name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center text-sm text-gray-600">
                                    {{ feature.lite }}
                                </td>
                                <td class="py-3 px-4 text-center text-sm text-green-600 font-semibold">
                                    {{ feature.full }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="text-center">
                <Link
                    :href="dashboard()"
                    class="inline-block bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors mr-4"
                >
                    Kembali ke Dashboard
                </Link>
                <button
                    class="inline-block bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors"
                    @click="alert('Hubungi admin untuk upgrade')"
                >
                    Hubungi untuk Upgrade
                </button>
            </div>
        </div>
    </div>
</template>


