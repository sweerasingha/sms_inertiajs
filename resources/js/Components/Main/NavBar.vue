<template>
    <nav class="bg-gray-900 p-4 lg:p-6">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <span class="font-semibold text-xl tracking-tight">
                    <Link class="navbar-brand" href="/">SMS</Link>
                </span>
            </div>
            <button
                @click="toggleMenu"
                class="lg:hidden flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white"
            >
                <svg
                    class="fill-current h-3 w-3"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
            <div
                :class="{ flex: isMenuOpen, hidden: !isMenuOpen }"
                class="w-full lg:flex lg:items-center lg:w-auto"
            >
                <div class="text-sm lg:flex-grow">
                    <Link
                        href="/student"
                        class="block mt-4 lg:inline-block text-teal-200 hover:text-white mr-4"
                        >Dashboard</Link
                    >
                </div>
                <div class="flex">
                    <Link
                        v-if="!isLoggedIn"
                        href="/login"
                        class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0"
                        >Login</Link
                    >
                    <div class="px-2"></div>
                    <Link
                        v-if="!isLoggedIn"
                        href="/register"
                        class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0"
                        >Register</Link
                    >
                    <Link
                        v-else
                        href="/logout"
                        method="post"
                        as="button"
                        class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0"
                        >Logout</Link
                    >
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

export default {
    components: {
        Link,
    },
    setup() {
        const { auth } = usePage().props;
        const isMenuOpen = ref(false); // State to track menu visibility on mobile

        // Toggle visibility of the menu on mobile
        const toggleMenu = () => {
            isMenuOpen.value = !isMenuOpen.value;
        };

        return {
            isLoggedIn: computed(() => !!auth.user),
            isMenuOpen,
            toggleMenu,
        };
    },
};
</script>
