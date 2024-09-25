<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Initialize the form
const form = useForm({
  name: '',
  email: '',
  phone: '',
});

// Local errors for client-side validation
const clientErrors = ref({
  name: '',
  email: '',
  phone: ''
});

// Client-side validation
function validateForm() {
  let isValid = true;

  // Validate name field
  if (!form.name) {
    clientErrors.value.name = 'The name field is required.';
    isValid = false;
  } else {
    clientErrors.value.name = '';
  }

  // Validate email field
  if (!form.email) {
    clientErrors.value.email = 'The email field is required.';
    isValid = false;
  } else if (!/\S+@\S+\.\S+/.test(form.email)) {
    clientErrors.value.email = 'The email must be a valid email address.';
    isValid = false;
  } else {
    clientErrors.value.email = '';
  }

  // Validate phone field
  if (!form.phone) {
    clientErrors.value.phone = 'The phone field is required.';
    isValid = false;
  } else {
    clientErrors.value.phone = '';
  }

  return isValid;
}

function submit() {
  // Client-side validation first
  if (validateForm()) {
    // Proceed to submit form if validation passes
    form.post('/customers/store');
  }
}
</script>

<style>
/* Same styling as before */
.form-page {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #333;
}

.form-container {
  width: 100%;
  max-width: 500px;
  padding: 40px;
  border: #6c757d 1px solid;
  background-color: #333;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 30px;
  text-align: center;
  color: #cfc8c8;
}

.form-control {
  height: 50px;
  border-radius: 8px;
  font-size: 16px;
  padding: 10px 20px;
  margin-bottom: 10px;
}

.text-danger {
  font-size: 14px;
  color: #ff0000;
  margin-top: 5px;
  min-height: 18px;
}

.btn-submit {
  background-color: #007bff;
  color: #fff;
  font-size: 18px;
  border-radius: 8px;
  padding: 10px;
  width: 100%;
  margin-top: 20px;
}

.btn-submit:hover {
  background-color: #0056b3;
}
</style>

<template>
  <div class="form-page">
    <div class="form-container">
      <!-- Form Title -->
      <h3 class="form-title">Create New Customer</h3>

      <!-- Form -->
      <form @submit.prevent="submit">
        <!-- Full Name Input -->
        <div class="mb-3">
          <input type="text" v-model="form.name" class="form-control" id="name" placeholder="Full Name">
          <div class="text-danger" v-if="clientErrors.name">{{ clientErrors.name }}</div>
        </div>

        <!-- Email Input -->
        <div class="mb-3">
          <input type="email" v-model="form.email" class="form-control" id="email" placeholder="Email Address">
          <div class="text-danger" v-if="clientErrors.email">{{ clientErrors.email }}</div>
        </div>

        <!-- Phone Input -->
        <div class="mb-3">
          <input type="tel" v-model="form.phone" class="form-control" id="phone" placeholder="Phone Number">
          <div class="text-danger" v-if="clientErrors.phone">{{ clientErrors.phone }}</div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Create Customer</button>
      </form>
    </div>
  </div>
</template>
