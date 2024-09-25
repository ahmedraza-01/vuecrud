<script setup>
import { ref, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

// Fetch the customers data from the Inertia response
const { posts, flash } = usePage().props;
const postList = ref(posts);
const props = defineProps({
  posts: Array,
});

const showMessage = ref(flash.message ? true : false);

// Function to handle deleting without confirmation
function deletePost(id) {
  axios.delete(`/posts/${id}`)
    .then(response => {
      // Update the customer list by removing the deleted customer
      postList.value = postList.value.filter(post => post.id !== id);
      
      // Update flash message
      if (response.data.message) {
        flash.message = response.data.message; // Assuming the server sends a success message
        showMessage.value = true; // Show the message
      }
    })
    .catch(() => {
      alert('Error deleting post.');
    });
}


function edit(id) {
  router.get('/posts/' + id + '/edit');
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
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>All Posts</h2>
      <a href="/posts/create" class="btn btn-primary">Create New Post</a>
    </div>
    <div v-if="showMessage" class="alert alert-success alert-dismissible fade show" role="alert">
  {{ flash.message }}
  <button type="button" class="btn-close" @click="showMessage = false" aria-label="Close"></button>
</div>
    <table class="table table-bordered table-hover">

      <thead class="table-dark">
        <tr>
          <th scope="col">Picture</th>
          <th scope="col">Title</th>
          <th scope="col">Excerpt</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="post in postList" :key="post.id">
          <td>
            <img v-if="post.picture" :src="`/storage/${post.picture}`" alt="Post Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" />
            <span v-else>No Image</span>
          </td>
          <td>{{ post.title }}</td>
          <td>{{ post.excerpt }}</td>
          <td class="d-flex align-items-center" style="border: none; margin-top:15%;">
            <button @click.prevent="edit(post.id)" class="btn btn-primary btn-sm me-2">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deletePost(post.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* Additional styling for a cleaner look */
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px wheat solid ;
  padding: 15px;
  text-align: left;
  vertical-align: middle;
  color:wheat;
}

img {
  border-radius: 8px;
}

td:last-child {
  width: 150px;
}
</style>
