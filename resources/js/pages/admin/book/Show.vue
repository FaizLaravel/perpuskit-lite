<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import ShowData from '@/components/ShowData.vue';
import { Card, CardContent } from '@/components/ui/card';
import { index, show } from '@/routes/databukus';
import { Book, BreadcrumbItem } from '@/types';

const { book } = defineProps<{
    book: {
        data: Book;
    };
}>();
console.log(book.data);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Buku',
        href: index().url,
    },
    {
        title: 'Detail Buku',
        href: show(book.data.id).url,
    },
];
const columns = [
    { key: 'judul', label: 'Judul Buku', sortable: true },
    { key: 'penulis', label: 'Penulis Buku', sortable: true },
    { key: 'penerbit', label: 'Penerbit Buku', sortable: true },
    { key: 'tanggal_terbit', label: 'Tanggal Terbit', sortable: true },
    { key: 'category_id', label: 'Kategori', sortable: true },
    { key: 'isbn', label: 'ISBN', sortable: true },
    { key: 'jumlah_halaman', label: 'Jumlah Halaman', sortable: true },
    { key: 'deskripsi', label: 'Deskripsi Singkat', sortable: true },
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
                <ShowData :columns="columns" :data="book.data">
                    <template #category_id="{ data }">
                        {{ data.category?.name || 'Tidak Ada' }}
                    </template>
                    <template #tanggal_terbit="{ data }">
                        {{ formatDate(data.tanggal_terbit) }}
                    </template>
                </ShowData>
            </CardContent>
        </Card>
    </div>
</template>
