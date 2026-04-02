<script setup lang="ts">
import { ref, reactive } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import AddModal from './Partials/AddModal.vue';
import EditModal from './Partials/EditModal.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const { records } = defineProps({
  records: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  }
});
type DynamicObject = Record<string, any>;
const showModal = ref(false)
const showEdit  = ref(false);
const editIp    = reactive<DynamicObject>({});

const openModal = () => {
    showModal.value = true;
}

const openEditModal = (ip: DynamicObject) => {
  showEdit.value = true;
  Object.assign(editIp, ip);
}

const deleteIpForm = useForm({
  id: null as number | null,
});

const deleteIp = (id: number) => {
  if (confirm('Are you sure you want to delete this IP record?')) {
    deleteIpForm.id = id;
    deleteIpForm.delete(route('ip-record.destroy', id), {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        toast.success("Deleted!", {
            autoClose: 1000,
        });
      },
    });
  }
}
</script>

<template>
    <Head title="IP Record" />

    <AuthenticatedLayout>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">
                    IP Records
                </h2>
                <button
                    @click="openModal"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition"
                >
                    Add IP
                </button>
            </div>

            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-3 font-medium text-gray-800">IP Address</th>
                            <th class="px-6 py-3 font-medium text-gray-800">Label</th>
                            <th class="px-6 py-3 font-medium text-gray-800">Comment</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="records.data.length" v-for="record in records.data" :key="record.id" class="border-t hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                {{ record.ip_address }}
                            </td>
                            <td class="px-6 py-4">
                                {{ record.label }}
                            </td>
                            <td class="px-6 py-4">
                                {{ record.comment }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button v-if="user.id === record.user_id || user.role === 'superadmin'" @click.prevent="openEditModal(record)" class="text-indigo-600 hover:underline mx-1">
                                    Edit
                                </button>
                                <button v-if="user.role === 'superadmin'" @click.prevent="deleteIp(record.id)" class="text-red-600 hover:underline mx-1">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                No records found.
                            </td>
                        </tr>
                    </tbody>
                </table>                

                <div v-if="records.data.length" class="flex justify-center py-2 space-x-2">
                    <button 
                        :disabled="!records.prev_page_url" 
                        @click.prevent="$inertia.get(records.prev_page_url)"
                        href="#" class="text-body bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading text-blue-700 hover:text-blue-500 shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
                        Previous
                    </button>

                    <button 
                        :disabled="!records.next_page_url" 
                        @click.prevent="$inertia.get(records.next_page_url)"
                        href="#" class="text-body bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading text-blue-700 hover:text-blue-500 shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
                        Next
                    </button>
                </div>

            </div>
        </div>

        <AddModal
            :showModal="showModal"
            @close="showModal = false"
        />
        <EditModal 
            v-if="showEdit" 
            :showEdit="showEdit" 
            @close="showEdit = false" 
            :ip="editIp" 
        />
    </AuthenticatedLayout>
</template>