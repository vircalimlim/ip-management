<script setup lang="ts">
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const toggleMenu = ref(false);
const currentRoute = route().current();

const handleMenu = () => {
  toggleMenu.value = !toggleMenu.value;
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
  

            <button @click="handleMenu" :class="toggleMenu ? 'hidden' : 'inline-flex'" data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base ms-3 mt-3 text-sm p-2 focus:outline-none inline-flex sm:hidden">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                </svg>
            </button>

            <aside 
                id="default-sidebar"
                :class="toggleMenu ? 'translate-x-0' : '-translate-x-full'"
                class="bg-white fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
                    <div class="mb-2 text-end block md:hidden">
                        <span
                        @click="handleMenu"
                        class="text-[30px] text-gray-700 px-2 cursor-pointer rounded hover:bg-gray-200"
                        >&times;</span>
                    </div>
                    <ul class="space-y-2 font-medium">
                        <Link href="/dashboard">
                            <div class="flex gap-2 items-center">
                                <ApplicationLogo class="h-10 w-10 fill-current text-gray-500" />
                                IP Management
                            </div>
                        </Link>
                        <li>
                                <Link
                                    :href="route('ip-record.index')"
                                    :class="currentRoute == 'ip-record.index' ? 'text-blue-800 bg-gray-100' : ''"
                                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group"
                                >
                                    <!-- <img class="h-8 w-8" src="/images/icons/logs.png" /> -->
                                    <span :class="currentRoute == 'ip-record.index' ? 'text-[#e5432d]' : ''" class="flex-1 ms-3 whitespace-nowrap">Ip</span>
                                </Link>
                        </li>
                        <li v-if="$page.props.auth.user.role == 'superadmin'">
                                <Link
                                    :href="route('audit-log.index')"
                                    :class="currentRoute == 'audit-log.index' ? 'text-blue-800 bg-gray-100' : ''"
                                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group"
                                >
                                    <!-- <img class="h-8 w-8" src="/images/icons/logs.png" /> -->
                                    <span :class="currentRoute == 'audit-log.index' ? 'text-[#e5432d]' : ''" class="flex-1 ms-3 whitespace-nowrap">Logs</span>
                                </Link>
                        </li>
                        <li>
                            <Link
                                    :href="route('logout')"
                                    method="post"
                                    :class="currentRoute == 'logout' ? 'text-blue-800 bg-gray-100' : ''"
                                    class="flex w-full text-start items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group"
                                >
                                <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="md:ml-64 h-screen">
                <slot />
            </main>
        </div>
    </div>
</template>
