<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import Pagination from '@/components/tables/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import FlashMessage from '@/components/ui/flash/FlashMessage.vue';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent } from '@/components/ui/popover';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { index, store } from '@/routes/pembayarans';
import { BreadcrumbItem, PengajuanPeminjaman } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { PopoverTrigger } from 'reka-ui';
import { computed, ref } from 'vue';
import { PaginatedResponse } from '../../../types/index';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pembayaran Denda',
        href: index().url,
    },
];
const props = defineProps<{
    payments: PaginatedResponse<PengajuanPeminjaman>;
}>();
console.log(props.payments);
const pagination = computed(() => ({
    previous: props.payments.prev_page_url,
    next: props.payments.next_page_url,
}));
const pageProps = computed(() => {
    return (
        (usePage().props.filters as {
            search?: string;
            sortColumn?: string;
            order?: 'asc' | 'desc';
            searchBy?: string;
            perPage?: string;
        }) || {}
    );
});
const searchQuery = ref(pageProps.value.search ?? '');
const searchBy = ref(pageProps.value.searchBy ?? '');
const selectedSort = ref(pageProps.value.sortColumn ?? 'created_at');
const sortOrder = ref<'asc' | 'desc'>(pageProps.value.order ?? 'asc');
const perPage = ref(pageProps.value.perPage ?? '7');
const updatePembayarans = () => {
    router.get(
        '/pembayarans',
        {
            search: searchQuery.value,
            sortColumn: selectedSort.value,
            order: sortOrder.value,
            column: searchBy.value,
            searchBy: searchBy.value,
            perPage: perPage.value,
        },
        { preserveState: true, replace: true },
    );
};
function toggleSort(key: string) {
    if (selectedSort.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        selectedSort.value = key;
        sortOrder.value = 'asc';
    }
    updatePembayarans();
}
watchDebounced(
    [searchQuery, searchBy, perPage],
    () => {
        updatePembayarans();
    },
    { debounce: 500 },
);
const resetFilters = () => {
    searchQuery.value = '';
    searchBy.value = '';
    perPage.value = '7';

    updatePembayarans();
};
const columns = [
    { key: 'no', label: 'No' },
    { key: 'kode_transaksi', label: 'Kode Transaksi', sortable: true },
    { key: 'user_id', label: 'Nama Anggota', sortable: true },
    { key: 'book_id', label: 'Judul Buku', sortable: true },
    // { key: 'jatuh_tempo', label: 'Jatuh Tempo', sortable: true },
    { key: 'denda', label: 'Denda', sortable: true },
    { key: 'actions', label: 'Aksi' },
];

function hitungTerlambat(tanggalJatuhTempo: string | Date): string {
    const jatuhTempo = new Date(tanggalJatuhTempo);
    const today = new Date();

    // Samakan jam ke 00:00:00
    jatuhTempo.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    const selisihMs = jatuhTempo.getTime() - today.getTime();
    const selisihHari = Math.floor(selisihMs / 86400000);

    // Jika belum lewat jatuh tempo
    // if (selisihHari <= 0) {
    //     return '0 hari';
    // }

    return `${selisihHari} hari`;
}

const isOpenLunas = ref<Record<number, boolean>>({});
const isOpenBayar = ref<Record<number, boolean>>({});
const nominalBayar = ref<Record<number, number | undefined>>({});

const HandlePembayaran = (id: number, type: 'lunas' | 'bayar') => {
    const item = props.payments.data.find((row) => row.id === id);
    if (!item) return;

    // Tentukan nominal yang dikirim
    let bayar = 0;
    if (type === 'lunas') {
        bayar = item.denda; // lunasi semua sisa denda
    } else {
        bayar = nominalBayar.value[id] ?? 0; // pembayaran sebagian
    }

    if (bayar <= 0) {
        alert('Nominal pembayaran harus lebih dari 0');
        return;
    }

    router.post(
        store().url,
        {
            loan_id: id, // ganti 'id' menjadi 'loan_id'
            bayar: bayar, // kirim 'bayar', bukan 'denda' dan 'status'
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                isOpenLunas.value[id] = false;
                isOpenBayar.value[id] = false;
                nominalBayar.value[id] = undefined;
            },
        },
    );
};
const popoverOpen = ref(false);
const formatRupiah = (value: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(value);
};
</script>
<template>
    <!-- <Head title="Pembayaran" /> -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto mt-5 max-w-6xl overflow-x-auto">
            <FlashMessage />
            <Card class="border-transparent">
                <CardContent>
                    <div
                        class="item-scretch sm:item-center flex flex-col justify-between gap-4 sm:flex-row"
                    >
                        <div class="flex items-end gap-2">
                            <Input
                                id="searchQuery"
                                class="w-full sm:w-64"
                                v-model="searchQuery"
                                placeholder="Cari..."
                            />
                            <select
                                id="searchBy"
                                v-model="searchBy"
                                class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground shadow-sm focus:ring-2 focus:ring-primary focus:outline-none sm:w-40"
                            >
                                <option value="">- Semua Kolom -</option>
                                <option value="kode_transaksi">
                                    Kode Transaksi
                                </option>
                                <option value="user_id">Nama Anggota</option>
                                <option value="book_id">Judul Buku</option>
                                <!-- <option value="jatuh_tempo">Jatuh Tempo</option>
                                <option value="denda">Denda</option> -->
                            </select>
                        </div>
                        <TooltipProvider>
                            <Tooltip v-if="!popoverOpen">
                                <Popover>
                                    <TooltipTrigger as-child>
                                        <PopoverTrigger
                                            ><Button
                                                variant="outline"
                                                class="flex items-center gap-2 bg-blue-600 text-white hover:bg-blue-700"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="18"
                                                    height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="lucide lucide-funnel"
                                                >
                                                    <path
                                                        d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"
                                                    />
                                                </svg> </Button
                                        ></PopoverTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <span>Filter Data</span>
                                    </TooltipContent>
                                    <PopoverContent>
                                        <div class="flex flex-col">
                                            <Label for="perPage" class="mb-2"
                                                >Jumlah Data</Label
                                            >
                                            <select
                                                id="perPage"
                                                v-model="perPage"
                                                class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                                            >
                                                <option value="7">
                                                    -- Jumlah Standar --
                                                </option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                            </select>
                                            <div class="mt-2 flex flex-col">
                                                <Button
                                                    type="button"
                                                    class="rounded bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700"
                                                    @click="resetFilters"
                                                >
                                                    Reset Filter
                                                </Button>
                                            </div>
                                        </div>
                                    </PopoverContent>
                                </Popover>
                            </Tooltip>
                        </TooltipProvider>
                    </div>
                    <DataTable
                        :columns="columns"
                        :data="payments.data"
                        :link="payments.links"
                        :current_page="props.payments.current_page"
                        :per_page="props.payments.per_page"
                        :filters="{
                            search: searchQuery,
                            sortColumn: selectedSort,
                            order: sortOrder,
                        }"
                        @toggleSort="toggleSort"
                    >
                        <template #no="{ i, current_page, per_page }">
                            {{ (current_page - 1) * per_page + i + 1 }}
                        </template>
                        <template #user_id="{ item }">
                            {{ item.user?.name || 'Tidak Ada' }}
                        </template>
                        <template #book_id="{ item }">
                            {{ item.book?.judul || 'Tidak Ada' }}
                        </template>
                        <template #jatuh_tempo="{ item }">
                            {{ hitungTerlambat(item.tanggal_jatuh_tempo) }}
                        </template>
                        <template #denda="{ item }">
                            {{ formatRupiah(item.denda) }}
                        </template>
                        <template #actions="{ item }">
                            <div class="flex items-center gap-2">
                                <Dialog
                                    v-model:open="isOpenLunas[item.id]"
                                    :key="item.id"
                                >
                                    <DialogTrigger as-child>
                                        <Button
                                            variant="success"
                                            size="icon"
                                            class="w-full sm:w-20"
                                        >
                                            Lunas
                                        </Button>
                                    </DialogTrigger>

                                    <DialogContent class="sm:max-w-xl">
                                        <DialogHeader>
                                            <DialogTitle>
                                                Konfirmasi Pelunasan
                                            </DialogTitle>

                                            <h1 class="mt-2">
                                                Nama Anggota:<br />
                                                <strong>
                                                    {{ item.users?.name }}
                                                </strong>
                                            </h1>

                                            <h1 class="mt-2">
                                                Judul Buku:<br />
                                                <strong>
                                                    {{ item.databukus?.judul }}
                                                </strong>
                                            </h1>

                                            <DialogDescription>
                                                Apakah Anda yakin ingin menandai
                                                transaksi ini sebagai
                                                <strong class="text-green-500"
                                                    >LUNAS</strong
                                                >? Setelah dikonfirmasi, status
                                                pembayaran akan diperbarui dan
                                                tidak dapat dibatalkan.
                                            </DialogDescription>
                                        </DialogHeader>

                                        <DialogFooter class="gap-2">
                                            <Button
                                                @click="
                                                    HandlePembayaran(
                                                        item.id,
                                                        'lunas',
                                                    )
                                                "
                                            >
                                                Konfirmasi Lunas
                                            </Button>

                                            <DialogClose as-child>
                                                <Button
                                                    type="button"
                                                    variant="secondary"
                                                >
                                                    Batal
                                                </Button>
                                            </DialogClose>
                                        </DialogFooter>
                                    </DialogContent>
                                </Dialog>
                                <Dialog
                                    v-model:open="isOpenBayar[item.id]"
                                    :key="`bayar-${item.id}`"
                                >
                                    <DialogTrigger as-child>
                                        <Button
                                            variant="destructive"
                                            class="w-full sm:w-28"
                                        >
                                            Bayar
                                        </Button>
                                    </DialogTrigger>

                                    <DialogContent class="sm:max-w-lg">
                                        <DialogHeader>
                                            <DialogTitle>
                                                Pembayaran Denda
                                            </DialogTitle>

                                            <DialogDescription>
                                                Masukkan nominal pembayaran
                                                untuk transaksi ini.
                                            </DialogDescription>
                                        </DialogHeader>

                                        <div class="space-y-4">
                                            <div>
                                                <Label>Nama Anggota</Label>
                                                <p class="mt-3 font-semibold">
                                                    {{ item.users?.name }}
                                                </p>
                                            </div>

                                            <div>
                                                <Label>Judul Buku</Label>
                                                <p class="mt-3 font-semibold">
                                                    {{ item.databukus?.judul }}
                                                </p>
                                            </div>

                                            <div>
                                                <Label for="nominal"
                                                    >Nominal Pembayaran</Label
                                                >
                                                <Input
                                                    id="nominal"
                                                    type="number"
                                                    class="mt-3"
                                                    placeholder="Masukkan nominal"
                                                    v-model="
                                                        nominalBayar[item.id]
                                                    "
                                                />
                                            </div>
                                        </div>

                                        <DialogFooter class="gap-2">
                                            <Button
                                                :disabled="
                                                    !nominalBayar[item.id]
                                                "
                                                @click="
                                                    HandlePembayaran(
                                                        item.id,
                                                        nominalBayar[item.id]
                                                            ? 'bayar'
                                                            : 'lunas',
                                                    )
                                                "
                                            >
                                                Simpan Pembayaran
                                            </Button>

                                            <DialogClose as-child>
                                                <Button variant="secondary">
                                                    Batal
                                                </Button>
                                            </DialogClose>
                                        </DialogFooter>
                                    </DialogContent>
                                </Dialog>
                            </div>
                        </template>
                    </DataTable>
                </CardContent>
            </Card>
        </div>
        <Pagination
            :previousPage="pagination.previous"
            :nextPage="pagination.next"
            :links="props.payments.links"
        />
    </AppLayout>
</template>
