<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-content">
        <h2 class="title is-4">Create Feedback</h2>

        <div v-if="errorMessage" class="notification is-danger">
          {{ errorMessage }}
        </div>
        <div v-if="successMessage" class="notification is-success">
          {{ successMessage }}
        </div>

        <form @submit.prevent="submitFeedback">
          <div class="field">
            <label class="label">Title</label>
            <div class="control">
              <input v-model="title" class="input" type="text" placeholder="Enter title" required />
            </div>
          </div>

          <div class="field">
            <label class="label">Category</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select v-model="selectedCategory" required>
                  <option value="" disabled>Select a category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.title }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <div class="field">
            <label class="label">Description</label>
            <div class="control">
              <textarea v-model="description" class="textarea" placeholder="Enter description" required></textarea>
            </div>
          </div>

          <div class="field">
            <div class="control">
              <button class="button is-primary" type="submit">Submit Feedback</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      title: "",
      description: "",
      selectedCategory: '',
      errorMessage: '',
      successMessage: '',
      categories: [],
    };
  },
  methods: {
    async submitFeedback() {
      // Your validation logic here
      if (this.title.trim() === "" || this.description.trim() === "" || this.selectedCategory === "") {
        this.errorMessage = "Please fill out all fields.";
        this.successMessage = "";
        return;
      }

      const user_id = sessionStorage.getItem('user_id');
      const feedbackData = {
        title: this.title,
        description: this.description,
        category_id: this.selectedCategory,
        user_id: user_id
      };

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/feedback/submit', feedbackData);
        console.log(response.data);

        this.errorMessage = '';
        this.successMessage = 'Submit successful!';
        this.hideMessagesAfterDelay(5000);
      } catch (error) {
        console.error(error);

        this.errorMessage = 'Error submitting feedback';
        this.successMessage = '';
        this.hideMessagesAfterDelay(5000);
      }
    },

    hideMessagesAfterDelay(delay) {
      setTimeout(() => {
        this.errorMessage = '';
        this.successMessage = '';
      }, delay);
    },

    async fetchCategories() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>

<style scoped>
/* Additional styles for your component go here */

/* Style to make select look good (customizable) */
.select select {
  appearance: none;
  background-color: white;
  padding: 0.5em 1em;
  border: 1px solid #dbdbdb;
  border-radius: 4px;
  width: 100%;
  font-size: 1rem;
}
</style>
