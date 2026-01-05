import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    data: string;
    id: number;
    name: string;
    email: string;
    level: string;
    nik: string;
    no_hp: string;
    profile_user: file | null;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Category {
    id: number;
    name: string;
}

export interface Book {
    id: number;
    judul: string;
    penulis: string;
    penerbit: string;
    tanggal_terbit: string;
    category_id: number;
    isbn: string;
    jumlah_halaman: number;
    deskripsi: string;
    total_dipinjam: number;
}

export interface PengajuanPeminjaman {
    id: number;
    user_id: number;
    kode_transaksi: string;
    book_id: number;
    tanggal_peminjaman: string;
    tanggal_jatuh_tempo: string;
    tanggal_pengembalian: string;
    status: string;
    catatan: string;
    book: Book;
    user: User;
    denda: number;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface PaginatedResponse<T> {
    current_page: number;
    data: T[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export interface Edituser {
    nik: string;
    name: string;
    email: string;
    no_hp: string;
    level: string;
    profile_user: File | null;
    _method: string;
}
