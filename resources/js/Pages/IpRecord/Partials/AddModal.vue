<script setup lang="ts">
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Spinner from '@/Components/Spinner.vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const {showModal} = defineProps({
  showModal: {
    type: Boolean,
    required: true
  },
});

const emit = defineEmits(['close']);

const form = useForm({
    ip_address: '',
    label: '',
    comment: ''
});
const errors = ref<Record<string, string>>({});
const isLoading = ref(false);

const closeModal = () => {
  emit('close');
  form.reset();
  form.clearErrors(); 
  errors.value = {};
};

const submitIp = () => {
  isLoading.value = true;
  form.post(route("ip-record.store"), {
    onSuccess: () => {
      emit('close');
      form.ip_address = "";
      form.label = "";
      form.comment = "";
      isLoading.value = false;

      toast.success("Saved!", {
        autoClose: 1000,
      });
    },
    onError: (e) => {
      errors.value = e;
      isLoading.value = false;
      console.log(e);
    },
  });
}
</script>

<template>
  <Modal :show="showModal" @close="closeModal">
    <h1 class="text-gray-700 text-2xl font-bold">Add IP Address</h1>
    <form @submit.prevent="submitIp" class="mt-6 space-y-4">

      <div>
        <InputLabel for="ip_address" value="IP Address" />
        <TextInput
          id="ip_address"
          type="text"
          class="block w-full"
          v-model="form.ip_address"
        />
        <InputError class="mt-2" :message="form.errors.ip_address" />
      </div>

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

      <div>
        <InputLabel for="comment" value="Comment" />
        <textarea
            v-model="form.comment"
            rows="3"
            placeholder="Comment"
            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
        <InputError class="mt-2" :message="form.errors.comment" />
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing || isLoading">
          <Spinner v-if="isLoading"/>
          Save
        </PrimaryButton>
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
