<!-- src/components/CommentSection.vue -->

<template>
    <div>
      <h2>Comments for Feedback {{ feedbackId }}</h2>
      <!-- Your comment section HTML here -->
      <ul>
        <li v-for="comment in commentList" :key="comment.id">
          <strong>{{ comment.user }}</strong>
          <p>{{ comment.content }}</p>
          <!-- Add more details as needed -->
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    props: ['feedbackId'],
    data() {
      return {
        commentList: [],
      };
    },
    mounted() {
      // Fetch comments for the specified feedback ID from the backend using Axios
    },
  };
  </script>
  
  <style>
  /* Add your component-specific styles here */
  </style>
  