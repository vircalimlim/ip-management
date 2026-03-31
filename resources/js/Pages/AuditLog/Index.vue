<script setup lang="ts">
import { ref, reactive } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const { logs } = defineProps({
  logs: {
    type: Object,
    required: true,
  }
});
</script>

<template>
    <Head title="Audit Logs" />

    <AuthenticatedLayout>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Audit Logs
                </h2>
            </div>

            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-3 font-medium text-gray-800">Event Type</th>
                            <th class="px-6 py-3 font-medium text-gray-800">User ID</th>
                            <th class="px-6 py-3 font-medium text-gray-800">Description</th>
                            <th class="px-6 py-3 font-medium text-gray-800">Created</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="logs.length" v-for="log in logs" :key="log.id" class="border-t hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                {{ log.event_type }}
                            </td>
                            <td class="px-6 py-4">
                                {{ log.user_id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ log.description }}
                            </td>
                            <td class="px-6 py-4">
                                {{ log.created_at }}
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                No logs found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>