<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps({
  errors: Object, // Handle any initial errors if passed
  post: Object // Post details passed from the server
});

// Initialize the form with post data
const form = useForm({
  title: props.post.title || '',
  excerpt: props.post.excerpt || '',
  body: props.post.body || '',
  picture: null // For file upload
});

// Submit the form using Inertia's `form.put` method
function submit(id) {
  form.put(`/posts/${id}`, {
    onError: (errors) => {
      console.log('Validation errors:', errors);
    }
  });
}

// Initialize CKEditor
onMounted(() => {
    ClassicEditor.create(document.querySelector('#body'))
        .then(editor => {
            // Set the initial data
            editor.setData(form.body);

            editor.model.document.on('change:data', () => {
                form.body = editor.getData();
            });
        })
        .catch(error => {
            console.error('There was a problem initializing CKEditor:', error);
        });
});

// Handle file upload change
function handleFileUpload(event) {
  form.picture = event.target.files[0];
}
</script>

<template>
  <div class="form-page">
    <div class="form-container">
      <!-- Form Title -->
      <h3 class="form-title">Edit Post</h3>

      <!-- Form -->
      <form @submit.prevent="submit(post.id)">
        <!-- Title Input -->
        <div class="form-group mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" v-model="form.title" class="form-control" id="title" placeholder="Enter post title" />
          <div class="text-danger" v-if="props.errors.title">{{ props.errors.title }}</div>
        </div>

        <!-- Excerpt Input -->
        <div class="form-group mb-3">
          <label for="excerpt" class="form-label">Excerpt</label>
          <input type="text" v-model="form.excerpt" class="form-control" id="excerpt" placeholder="Enter post excerpt" />
          <div class="text-danger" v-if="props.errors.excerpt">{{ props.errors.excerpt }}</div>
        </div>

        <!-- Rich Text Body Input (CKEditor) -->
        <div class="form-group mb-3">
          <label for="body" class="form-label">Content</label>
          <textarea
            style="height: 50vh !important;"
            id="body"
            class="form-control"
            rows="6"
            placeholder="Enter post content here"
            v-model="form.body" 
          ></textarea>
          <div class="text-danger" v-if="props.errors.body">{{ props.errors.body }}</div>
        </div>

        <!-- Picture Input -->
        <div class="form-group mb-3">
          <label for="picture" class="form-label">Upload Picture</label>
          <input type="file" @change="handleFileUpload" class="form-control" id="picture" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Save Changes</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.form-page {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f5f5f5;
}

/* Form container styling */
.form-container {
    margin-top: 5vh;
    background-color: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 800px;
}

/* Form title styling */
.form-title {
    font-size: 28px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 1.5rem;
}

/* Submit button styling */
.btn-submit {
    width: 100%;
    padding: 1rem;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    transition: background-color 0.3s;
}

.btn-submit:hover {
    background-color: #0056b3;
}

/* Error message styling */
.text-danger {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

h3 {
    color: cadetblue;
}

.ck.ck-editor__editable_inline>:last-child {
    color: black;
}
</style>
