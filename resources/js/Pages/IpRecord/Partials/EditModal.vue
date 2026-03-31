<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { watchEffect } from 'vue';

const {showEdit, ip} = defineProps({
  showEdit: {
    type: Boolean,
    required: true
  },
  ip: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['close']);

const form = useForm({
    // ip_address: '',
    label: '',
    // comment: ''
});

const closeModal = () => {
  emit('close');
  form.reset();
  form.clearErrors();
};

const editForm = () => {
  // form.ip_address = ip.ip_address || '';
  form.label = ip.label || '';
  // form.comment = ip.comment || '';
};

const updateIp = () => {
  form.put(route("ip-record.update", ip.id), {
    onSuccess: () => {
      emit('close');
      // form.ip_address = '';
      form.label = '';
      // form.comment = '';
    },
  });
};

// Use watchEffect to track prop changes
watchEffect(() => {
  editForm();
});

</script>

<template>
  <Modal :show="showEdit" @close="closeModal">
    <h1 class="text-gray-700 text-2xl font-bold">Edit IP Address</h1>
    <form @submit.prevent="updateIp" class="mt-6 space-y-4">

      <!-- <div>
        <InputLabel for="ip_address" value="IP Address" />
        <TextInput
          id="ip_address"
          type="text"
          class="block w-full"
          v-model="form.ip_address"
        />
        <InputError class="mt-2" :message="form.errors.ip_address" />
      </div> -->

      <div>
        <InputLabel for="label" value="Label" />
        <TextInput
          id="label"
          type="text"
          class="block w-full"
          v-model="form.label"
        />
        <InputError class="mt-2" :message="form.errors.label" />
      </div>

      <!-- <div>
        <InputLabel for="comment" value="Comment" />
        <textarea
            v-model="form.comment"
            rows="3"
            placeholder="Comment"
            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
        <InputError class="mt-2" :message="form.errors.comment" />
      </div> -->
      
      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
        </Transition>
      </div>
    </form>
  </Modal>
</template>
