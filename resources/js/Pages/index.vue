<script setup>
import { ref, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

// Fetch the customers data from the Inertia response
const { customers, flash } = usePage().props;
const customerList = ref(customers);

// Reactive variable to control the visibility of the flash message
const showMessage = ref(flash.message ? true : false);

// Function to handle deleting without confirmation
function deleteCustomer(id) {
  axios.delete(`/customers/${id}`)
    .then(response => {
      // Update the customer list by removing the deleted customer
      customerList.value = customerList.value.filter(customer => customer.id !== id);
      
      // Update flash message
      if (response.data.message) {
        flash.message = response.data.message; // Assuming the server sends a success message
        showMessage.value = true; // Show the message
      }
    })
    .catch(() => {
      alert('Error deleting customer.');
    });
}


// Function to navigate to the "Create Customer" page
function createCustomer() {
  router.visit('/customers/create');
}

function edit(id) {
  router.get('/customers/' + id + '/edit');
}

// Hide the message after 3 seconds
onMounted(() => {
  if (showMessage.value) {
    setTimeout(() => {
      showMessage.value = false;
    }, 3000); // 3 seconds
  }
});
</script>

<template>
  <div class="container mt-5">
    <!-- Heading and Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1>Customers</h1>
      <button class="btn btn-success" @click="createCustomer">Create Customer</button>
    </div>

    <!-- Flash message with close button -->
    <div v-if="showMessage" class="alert alert-success alert-dismissible fade show" role="alert">
  {{ flash.message }}
  <button type="button" class="btn-close" @click="showMessage = false" aria-label="Close"></button>
</div>

    <!-- Table -->
    <table class="table table-bordered" style="background-color: #333 !important; color: aliceblue !important;">
      <thead class="thead-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="customer in customerList" :key="customer.id">
          <td>{{ customer.id }}</td>
          <td>{{ customer.name }}</td>
          <td>{{ customer.email }}</td>
          <td>{{ customer.phone }}</td>
          <td style="text-align: center;">
            <button @click.prevent="edit(customer.id)" class="btn btn-primary btn-sm me-2">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteCustomer(customer.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

