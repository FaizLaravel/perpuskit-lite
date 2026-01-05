<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import categories from '@/routes/categories';
import databukus from '@/routes/databukus';
import peminjamanbukus from '@/routes/peminjamanbukus';
import pengajuananggotas from '@/routes/pengajuananggotas';
import pengajuanpeminjamans from '@/routes/pengajuanpeminjamans';
import statuspeminjamans from '@/routes/statuspeminjamans';
import users from '@/routes/users';
import { InertiaLinkProps, Link, usePage } from '@inertiajs/vue3';
import {
    Book,
    BookMarked,
    BookOpen,
    Folders,
    LayoutGrid,
    LibraryBig,
    User,
} from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();

// 🟢 Ambil user dari Inertia props
const user = page.props.auth?.user;

interface NavGroup {
    label: string;
    items: {
        title: string;
        href: NonNullable<InertiaLinkProps['href']>;
        icon: any;
    }[];
}

const adminNavItems: NavGroup[] = [
    {
        label: 'Umum',
        items: [{ title: 'Beranda', href: '/dashboard', icon: LayoutGrid }],
    },
    {
        label: 'Data Master',
        items: [
            { title: 'Pengguna', href: users.index(), icon: User },
            {
                title: 'Kategori Buku',
                href: categories.index(),
                icon: Folders,
            },
            { title: 'Data Buku', href: databukus.index(), icon: Book },
        ],
    },
    {
        label: 'Transaksi',
        items: [
            {
                title: 'Pengajuan Peminjaman Buku',
                href: pengajuanpeminjamans.index(),
                icon: BookMarked,
            },
            {
                title: 'Status Peminjaman Buku',
                href: statuspeminjamans.index(),
                icon: LibraryBig,
            },
            {
                title: 'Perpanjangan Peminjaman',
                href: '/upgrade',
                icon: LibraryBig,
            },
            {
                title: 'Pengembalian Buku',
                href: '/upgrade',
                icon: LibraryBig,
            },
            {
                title: 'Pembayaran Denda',
                href: '/upgrade',
                icon: LibraryBig,
            },
        ],
    },
];

const anggotaNavItems: NavGroup[] = [
    {
        label: 'Umum',
        items: [{ title: 'Beranda', href: '/dashboard', icon: LayoutGrid }],
    },
    {
        label: 'Transaksi',
        items: [
            {
                title: 'Peminjaman Buku',
                href: peminjamanbukus.index(),
                icon: Book,
            },
            {
                title: 'Pengajuan Saya',
                href: pengajuananggotas.index(),
                icon: BookMarked,
            },
            {
                title: 'Daftar Peminjaman Buku',
                href: '/upgrade',
                icon: BookMarked,
            },
            {
                title: 'Riwayat Peminjaman',
                href: '/upgrade',
                icon: BookOpen,
            },
        ],
    },
];

const petugasuNavItems: NavGroup[] = [
    {
        label: 'Umum',
        items: [{ title: 'Beranda', href: '/dashboard', icon: LayoutGrid }],
    },
    {
        label: 'Data Master',
        items: [
            {
                title: 'Kategori Buku',
                href: categories.index(),
                icon: Folders,
            },
            { title: 'Data Buku', href: databukus.index(), icon: Book },
        ],
    },
    {
        label: 'Transaksi',
        items: [
            {
                title: 'Pengajuan Peminjaman',
                href: pengajuanpeminjamans.index(),
                icon: BookMarked,
            },
            {
                title: 'Status Peminjaman Buku',
                href: statuspeminjamans.index(),
                icon: LibraryBig,
            },
        ],
    },
];

// const footerNavItems: NavItem[] = [
//     {
//         title: 'Github Repo',
//         href: 'https://github.com/laravel/vue-starter-kit',
//         icon: Folder,
//     },
//     {
//         title: 'Documentation',
//         href: 'https://laravel.com/docs/starter-kits#vue',
//         icon: BookOpen,
//     },
// ];

const mainNavItems = computed(() => {
    if (user.level === 'admin') {
        return adminNavItems;
    } else if (user.level === 'anggota') {
        return anggotaNavItems;
    } else if (user.level === 'petugas') {
        return petugasuNavItems;
        // } else if (user.level === 'karyawan') {
        //     return karyawanNavItems;
    } else {
        return [];
    }
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :groups="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <!-- <NavFooter :items="footerNavItems" /> -->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
