<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import ShowData from '@/components/ShowData.vue';
import { Card, CardContent } from '@/components/ui/card';
import { index, show } from '@/routes/pengajuanpeminjamans';
import { BreadcrumbItem, PengajuanPeminjaman } from '@/types';

const { currentPengajuan } = defineProps<{
    currentPengajuan: {
        data: PengajuanPeminjaman;
    };
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pengajuan Peminjaman',
        href: index().url,
    },
    {
        title: 'Detail Pengajuan Peminjaman',
        href: show(currentPengajuan.data.id).url,
    },
];

const columns = [
    { key: 'kode_transaksi', label: 'Kode Transaksi', sortable: true },
    { key: 'user_id', label: 'Nama Anggota', sortable: true },
    { key: 'book_id', label: 'Judul Buku', sortable: true },
    {
        key: 'tanggal_pengajuan',
        label: 'Tanggal Pengajuan Peminjaman',
        sortable: true,
    },
    { key: 'status', label: 'Status', sortable: true },
    { key: 'catatan', label: 'Catatan', sortable: true },
];
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
                <ShowData :columns="columns" :data="currentPengajuan.data"
                    ><template #user_id="{ data }">
                        {{ data.user?.name || 'Tidak Ada' }}
                    </template>
                    <template #book_id="{ data }">
                        {{ data.book?.judul || 'Tidak Ada' }}
                    </template>
                    <template #tanggal_pengajuan="{ data }">
                        {{ formatDate(data.tanggal_pengajuan) }}
                    </template>
                </ShowData>
            </CardContent>
        </Card>
    </div>
</template>
