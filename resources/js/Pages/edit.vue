<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  errors: Object, // Handle any initial errors if passed
  customer: Object // Customer details passed from the server
});

// Initialize the form with customer data
const form = useForm({
  name: props.customer.name || '',
  email: props.customer.email || '',
  phone: props.customer.phone || ''
});

// Submit the form using Inertia's `form.put` method
function submit(id) {
  form.put(`/customers/${id}`, {
    onError: (errors) => {
      // Errors are automatically available in form.errors when validation fails
      console.log('Validation errors:', errors);
    }
  });
}
</script>

<template>
  <div class="form-page">
    <div class="form-container">
      <!-- Form Title -->
      <h3 class="form-title">Edit Customer</h3>

      <!-- Form -->
      <form @submit.prevent="submit(customer.id)">
        <!-- Full Name Input -->
        <div class="mb-3">
          <input type="text" v-model="form.name" class="form-control" id="name" placeholder="Full Name">
          <div class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</div>
        </div>

        <!-- Email Input -->
        <div class="mb-3">
          <input type="email" v-model="form.email" class="form-control" id="email" placeholder="Email Address">
          <div class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>

        <!-- Phone Input -->
        <div class="mb-3">
          <input type="tel" v-model="form.phone" class="form-control" id="phone" placeholder="Phone Number">
          <div class="text-danger" v-if="form.errors.phone">{{ form.errors.phone }}</div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Save Changes</button>
      </form>
    </div>
  </div>
</template>