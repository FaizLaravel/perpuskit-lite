<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import ShowData from '@/components/ShowData.vue';
import { Card, CardContent } from '@/components/ui/card';
import { index } from '@/routes/users';
import { BreadcrumbItem, User } from '@/types';
import { computed } from 'vue';

const { currentUser } = defineProps<{
    currentUser: {
        data: User;
    };
}>();
console.log(currentUser.data);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pengguna',
        href: index().url,
    },
    {
        title: 'Detail Pengguna',
        href: '',
        // href: show(currentUser.id).url,
    },
];
const columns = [
    { key: 'nik', label: 'Nik', sortable: true },
    { key: 'name', label: 'Nama', sortable: true },
    { key: 'email', label: 'Email', sortable: true },
    { key: 'no_hp', label: 'Telepon', sortable: false },
    { key: 'level', label: 'Level', sortable: true },
];
const profileImage = computed(() => {
    return currentUser.data.profile_user
        ? `/storage/${currentUser.data.profile_user}`
        : null;
});
</script>
<template>
    <div class="mx-auto mt-5 max-w-6xl overflow-x-auto">
        <!-- Breadcrumb -->
        <div class="mb-10 ml-6">
            <Breadcrumbs :breadcrumbs="breadcrumbs" />
        </div>

        <!-- PROFILE HEADER -->
        <Card class="mb-6 border border-white/10 bg-muted/30">
            <CardContent class="flex items-center gap-6 py-6">
                <!-- Foto Profil -->
                <div class="relative">
                    <div
                        class="flex h-70 w-70 items-center justify-center overflow-hidden rounded-full border border-white/10 bg-muted text-xl font-semibold text-muted-foreground shadow-lg"
                    >
                        <img
                            v-if="profileImage"
                            :src="profileImage"
                            alt="Foto Profil"
                            class="h-full w-full object-cover"
                        />
                        <span v-else>
                            {{ currentUser.data.name.charAt(0) }}
                        </span>
                    </div>
                </div>

                <!-- DETAIL DATA -->
                <ShowData :columns="columns" :data="currentUser.data">
                    <template #categories_id="{ data }">
                        {{ data.category?.name || 'Tidak Ada' }}
                    </template>
                </ShowData>
            </CardContent>
        </Card>
    </div>
</template>
