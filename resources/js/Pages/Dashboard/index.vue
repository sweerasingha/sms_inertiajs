<template>
    <AppLayout>
        <template #content>
            <div
                class="relative bg-gray-900 h-screen flex items-center justify-center overflow-hidden"
            >
                <div class="shape-bg"></div>
                <div class="flex-col">
                    <h1 class="text-white font-bold text-3xl md:text-5xl z-10">
                        SMS
                    </h1>
                    <h3 class="text-white font-bold text-xl md:text-3xl z-10">
                        Student Management System
                    </h3>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";

export default {
    components: {
        AppLayout,
    },
};
</script>

<style lang="scss" scoped>
.shape-bg::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(120deg, rgba(255, 255, 255, 0.1), transparent);
    clip-path: ellipse(50% 100% at 50% 0%);
    z-index: 0;
}

h1 {
    @apply text-white font-bold text-3xl md:text-5xl;
    z-index: 10;
}
</style>
