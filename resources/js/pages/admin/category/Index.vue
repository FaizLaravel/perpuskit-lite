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
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import AppLayout from '@/layouts/AppLayout.vue';
import { create, destroy, edit } from '@/routes/categories';
import { BreadcrumbItem, Category, PaginatedResponse } from '@/types';
import { Link, router, usePage } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Kategori Buku',
        href: '/categories',
    },
];

const columns = [
    { key: 'no', label: 'No' },
    { key: 'name', label: 'Nama', sortable: true },
    { key: 'actions', label: 'Aksi', slot: 'actions' },
];

const props = defineProps<{
    categories: PaginatedResponse<Category>;
}>();
console.log('props categories:', props.categories);
const pagination = computed(() => ({
    previous: props.categories.prev_page_url,
    next: props.categories.next_page_url,
}));
const isOpen = ref<Record<number, boolean>>({});
// const page = usePage();
// watch(
//     () => page.props.flash,
//     (flash) => {
//         console.log('FLASH CHANGED:', flash);
//     },
//     { immediate: true },
// );
const handleDelete = (id: number) => {
    console.log('Button hapus ditekan, isOpen:', isOpen.value);

    router.delete(destroy.url(id), {
        onSuccess: () => {
            isOpen.value[id] = false;
            // Tutup dialog setelah sukses hapus
        },
    });
};

const pageProps = computed(() => {
    return (
        (usePage().props.filters as {
            search?: string;
            sortColumn?: string;
            order?: 'asc' | 'desc';
            perPage?: string;
        }) || {}
    );
});
const searchQuery = ref(pageProps.value.search ?? '');
const selectedSort = ref(pageProps.value.sortColumn ?? 'created_at');
const sortOrder = ref<'asc' | 'desc'>(pageProps.value.order ?? 'asc');
const perPage = ref(pageProps.value.perPage ?? '7');
const updateCategory = () => {
    router.get(
        '/categories',
        {
            search: searchQuery.value,
            sortColumn: selectedSort.value,
            order: sortOrder.value,
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
    updateCategory();
}
watchDebounced(
    [searchQuery, perPage],
    (newQuery, oldQuery) => {
        if (newQuery !== oldQuery) {
            updateCategory();
        }
    },
    { debounce: 500 },
);
function resetFilters() {
    searchQuery.value = '';
    perPage.value = '7';

    // Langsung trigger update
    updateCategory();
}
const popoverOpen = ref(false);
</script>

<template>
    <!-- <Head title="Kategoru Buku" /> -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto mt-5 max-w-6xl overflow-x-auto">
            <FlashMessage />
            <Card class="border-transparent">
                <CardContent>
                    <div
                        class="flex flex-col items-stretch justify-between gap-4 sm:flex-row sm:items-center"
                    >
                        <div class="flex items-end gap-2">
                            <Input
                                id="searchQuery"
                                class="w-full sm:w-64"
                                v-model="searchQuery"
                                placeholder="Cari..."
                            />
                        </div>
                        <div class="flex items-end gap-2">
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
                                                <Label
                                                    for="perPage"
                                                    class="mb-2"
                                                    >Jumlah Data</Label
                                                >
                                                <select
                                                    id="perPage"
                                                    v-model="perPage"
                                                    @change="updateCategory"
                                                    class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                                                >
                                                    <option value="7">
                                                        -- Jumlah Standar --
                                                    </option>
                                                    <option value="5">5</option>
                                                    <option value="10">
                                                        10
                                                    </option>
                                                    <option value="20">
                                                        20
                                                    </option>
                                                    <option value="50">
                                                        50
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mt-2 flex flex-col">
                                                <Button
                                                    type="button"
                                                    class="rounded bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700"
                                                    @click="resetFilters"
                                                >
                                                    Reset Filter
                                                </Button>
                                            </div>
                                        </PopoverContent>
                                    </Popover>
                                </Tooltip>
                            </TooltipProvider>
                            <Link
                                :href="create().url"
                                as="button"
                                class="w-full sm:w-auto"
                            >
                                <Button
                                    variant="outline"
                                    class="w-full sm:w-40"
                                >
                                    Tambah Kategori
                                </Button>
                            </Link>
                        </div>
                    </div>
                    <DataTable
                        :columns="columns"
                        :data="props.categories.data"
                        :links="props.categories.links"
                        :current_page="props.categories.current_page"
                        :per_page="props.categories.per_page"
                        :filters="{
                            search: searchQuery,
                            sortColumn: selectedSort,
                            sortOrder: sortOrder,
                        }"
                        @toggleSort="toggleSort"
                    >
                        <template #no="{ i, current_page, per_page }">
                            {{ (current_page - 1) * per_page + i + 1 }}
                        </template>
                        <template #actions="{ item: categories }">
                            <div class="flex items-center gap-2">
                                <div class="group relative inline-block">
                                    <!-- Edit -->
                                    <Link
                                        :href="edit(categories.id)"
                                        as="button"
                                    >
                                        <Button variant="outline" size="icon">
                                            <Pencil class="h-4 w-4" />
                                        </Button>
                                    </Link>

                                    <span
                                        class="absolute bottom-full left-1/2 mb-2 -translate-x-1/2 rounded bg-black px-2 py-1 text-xs whitespace-nowrap text-white opacity-0 transition group-hover:opacity-100"
                                    >
                                        Edit
                                    </span>
                                </div>
                                <div class="group relative inline-block">
                                    <!-- Hapus -->
                                    <Dialog
                                        v-model:open="isOpen[categories.id]"
                                        :key="categories.id"
                                    >
                                        <DialogTrigger as-child>
                                            <Button
                                                variant="destructive"
                                                size="icon"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </Button>
                                        </DialogTrigger>
                                        <DialogContent class="sm:max-w-md">
                                            <DialogHeader>
                                                <DialogTitle
                                                    >Konfirmasi
                                                    Hapus</DialogTitle
                                                >
                                                <DialogDescription>
                                                    Apakah Anda yakin ingin
                                                    menghapus pengguna ini?
                                                </DialogDescription>
                                            </DialogHeader>
                                            <DialogFooter class="gap-2">
                                                <Button
                                                    variant="destructive"
                                                    @click="
                                                        handleDelete(
                                                            categories.id,
                                                        )
                                                    "
                                                >
                                                    Hapus
                                                </Button>
                                                <DialogClose as-child>
                                                    <Button
                                                        type="button"
                                                        variant="secondary"
                                                        >Batal</Button
                                                    >
                                                </DialogClose>
                                            </DialogFooter>
                                        </DialogContent>
                                    </Dialog>

                                    <span
                                        class="absolute bottom-full left-1/2 mb-2 -translate-x-1/2 rounded bg-black px-2 py-1 text-xs whitespace-nowrap text-white opacity-0 transition group-hover:opacity-100"
                                    >
                                        Hapus
                                    </span>
                                </div>
                            </div>
                        </template>
                    </DataTable>
                </CardContent>
            </Card>
        </div>
        <Pagination
            :previousPage="pagination.previous"
            :nextPage="pagination.next"
            :links="props.categories.links"
        />
    </AppLayout>
</template>
