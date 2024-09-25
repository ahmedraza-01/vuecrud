<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Initialize the form
const form = useForm({
    title: '',
    excerpt: '',
    body: '',
    picture: null,
});

// Local errors for client-side validation
const clientErrors = ref({
    title: '',
    excerpt: '',
    body: '',
});

// Client-side validation
function validateForm() {
    let isValid = true;

    // Validate title field
    if (!form.title) {
        clientErrors.value.title = 'The title field is required.';
        isValid = false;
    } else {
        clientErrors.value.title = '';
    }

    // Validate excerpt field
    if (!form.excerpt) {
        clientErrors.value.excerpt = 'The excerpt field is required.';
        isValid = false;
    } else {
        clientErrors.value.excerpt = '';
    }

    // Validate body field
    if (!form.body) {
        clientErrors.value.body = 'The body field is required.';
        isValid = false;
    } else {
        clientErrors.value.body = '';
    }

    return isValid;
}

// Submit handler
function submit() {
    if (validateForm()) {
        form.post('/posts/store');
    }
}

// Initialize CKEditor
onMounted(() => {
    ClassicEditor.create(document.querySelector('#body'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                form.body = editor.getData();
            });
        })
        .catch(error => {
            console.error('There was a problem initializing CKEditor:', error);
        });
});
</script>

<style scoped>
/* Full-page form */
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

<template>
    <div class="form-page">
        <div class="form-container">
            <!-- Form Title -->
            <h3 class="form-title">Create New Post</h3>

            <!-- Form -->
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <!-- Title Input -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" v-model="form.title" class="form-control" id="title"
                        placeholder="Enter post title" />
                    <div class="text-danger" v-if="clientErrors.title">{{ clientErrors.title }}</div>
                </div>

                <!-- Excerpt Input -->
                <div class="form-group mb-3">
                    <label for="excerpt" class="form-label">Excerpt</label>
                    <input type="text" v-model="form.excerpt" class="form-control" id="excerpt"
                        placeholder="Enter post excerpt" />
                    <div class="text-danger" v-if="clientErrors.excerpt">{{ clientErrors.excerpt }}</div>
                </div>

                <!-- Rich Text Body Input (CKEditor) -->
                <div class="form-group mb-3">
                    <label for="body" class="form-label">Content</label>
                    <textarea style="  height: 50vh !important;" id="body" class="form-control" rows="6"
                        placeholder="Enter post content here">
                    </textarea>
                    <div class="text-danger" v-if="clientErrors.body">{{ clientErrors.body }}</div>
                </div>

                <!-- Picture Input -->
                <div class="form-group mb-3">
                    <label for="picture" class="form-label">Upload Picture</label>
                    <input type="file" @change="e => form.picture = e.target.files[0]" class="form-control"
                        id="picture" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">Create Post</button>
            </form>
        </div>
    </div>
</template>
