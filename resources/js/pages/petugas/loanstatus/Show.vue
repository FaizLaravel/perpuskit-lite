<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import ShowData from '@/components/ShowData.vue';
import { Card, CardContent } from '@/components/ui/card';
import { index, show } from '@/routes/statuspeminjamans';
import { BreadcrumbItem, PengajuanPeminjaman } from '@/types';

const { LoanStatus } = defineProps<{
    LoanStatus: {
        data: PengajuanPeminjaman;
    };
}>();
console.log(LoanStatus.data);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Status Peminjaman',
        href: index().url,
    },
    {
        title: 'Detail Status Peminjaman',
        href: show(LoanStatus.data.id).url,
    },
];

const columns = [
    { key: 'kode_transaksi', label: 'Kode Transaksi', sortable: true },
    { key: 'user_id', label: 'Nama Anggota', sortable: true },
    { key: 'book_id', label: 'judul Buku', sortable: true },
    { key: 'tanggal_peminjaman', label: 'Tanggal Peminjaman', sortable: true },
    {
        key: 'tanggal_jatuh_tempo',
        label: 'Tanggal Jatuh Tempo',
        sortable: true,
    },
    { key: 'jatuh_tempo', label: 'Jatuh Tempo', sortable: true },
    { key: 'denda', label: 'Denda', sortable: true },
    { key: 'status', label: 'status', sortable: true },
    { key: 'catatan', label: 'catatan', sortable: true },
];
function hitungTerlambat(tanggalJatuhTempo: string | Date): string {
    const jatuhTempo = new Date(tanggalJatuhTempo);
    const today = new Date();

    jatuhTempo.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    const selisihMs = jatuhTempo.getTime() - today.getTime();
    const selisihHari = Math.floor(selisihMs / 86400000);
    return `${selisihHari} hari`;
}
const formatRupiah = (value: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(value);
};
const formatDate = (date: string) => {
    return new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(new Date(date));
};
</script>
<template>
    <div class="mx-auto mt-5 max-w-6xl overflow-x-auto">
        <div class="mb-10 ml-6">
            <Breadcrumbs :breadcrumbs="breadcrumbs" />
        </div>
        <Card class="border-transparent">
            <CardContent>
                <ShowData :columns="columns" :data="LoanStatus.data"
                    ><template #user_id="{ data }">
                        {{ data.user?.name || 'Tidak Ada' }}
                    </template>
                    <template #book_id="{ data }">
                        {{ data.book?.judul || 'Tidak Ada' }}
                    </template>
                    <template #tanggal_peminjaman="{ data }">
                        {{ formatDate(data.tanggal_peminjaman) }}
                    </template>
                    <template #tanggal_jatuh_tempo="{ data }">
                        {{ formatDate(data.tanggal_jatuh_tempo) }}
                    </template>
                    <template #jatuh_tempo="{ data }">
                        <span v-if="data.status === 'pending'"> - </span>
                        <span v-else>
                            {{ hitungTerlambat(data.tanggal_jatuh_tempo) }}
                        </span>
                    </template>
                    <template #denda="{ data }">
                        {{ formatRupiah(data.denda) }}
                    </template>
                </ShowData>
            </CardContent>
        </Card>
    </div>
</template>
