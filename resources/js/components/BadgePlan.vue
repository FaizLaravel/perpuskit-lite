<script setup lang="ts">
const props = defineProps<{
    type: 'preview' | 'limited' | 'locked' | 'readonly';
}>();

const badgeConfig = {
    preview: {
        label: 'Preview',
        class: 'bg-blue-100 text-blue-800 border-blue-200',
    },
    limited: {
        label: 'Limited',
        class: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    },
    locked: {
        label: 'Locked',
        class: 'bg-red-100 text-red-800 border-red-200',
    },
    readonly: {
        label: 'Read-only',
        class: 'bg-gray-100 text-gray-800 border-gray-200',
    },
};

const config = badgeConfig[props.type];
</script>

<template>
    <span
        :class="[
            'inline-flex items-center rounded-md border px-2 py-1 text-xs font-medium',
            config.class,
        ]"
    >
        {{ config.label }}
    </span>
</template>

