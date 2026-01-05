<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { watch } from 'vue'
import { computed, ref, onMounted } from 'vue'

interface FlashMessageProps {
  success?: string
  error?: string
  warning_orange?: string
}

const page = usePage()

const flash = computed<FlashMessageProps>(() => {
  return (page.props.flash ?? {}) as FlashMessageProps
})

const localFlash = ref<FlashMessageProps>({ success: '', error: '', warning_orange: '' })
const visible = ref(false)
watch(
  () => page.props.flash as FlashMessageProps,
  (flash) => {
    if (!flash.success && !flash.error && !flash.warning_orange) return

    localFlash.value = { ...flash }
    visible.value = true

    setTimeout(() => {
      visible.value = false
      localFlash.value = {}
    }, 4000)
  },
  { immediate: true }
)

</script>

<template>
  <div class="fixed top-4 right-4 z-50 space-y-2">
    <transition name="fade" mode="out-in">
      <div
        v-if="visible && flash.success"
        key="success"
        class="max-w-xs rounded-lg bg-green-600 px-4 py-3 text-white shadow-lg"
      >
        {{ flash.success }}
      </div>
    </transition>

    <transition name="fade" mode="out-in">
      <div
        v-if="visible && flash.error"
        key="error"
        class="max-w-xs rounded-lg bg-red-600 px-4 py-3 text-white shadow-lg"
      >
        {{ flash.error }}
      </div>
    </transition>

        <transition name="fade" mode="out-in">
      <div
        v-if="visible && flash.warning_orange"
        key="warning_orange"
        class="max-w-xs rounded-lg bg-orange-600 px-4 py-3 text-white shadow-lg"
      >
        {{ flash.warning_orange }}
      </div>
    </transition>
  </div>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
