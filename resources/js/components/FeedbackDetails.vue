<template>
  <div class="container mt-5">
    <h2 class="title is-2">Feedback Details</h2>

    <div v-if="selectedFeedback">
      <div class="box">
        <h3 class="title is-3">{{ selectedFeedback.title }}</h3>
        <p><strong>Category:</strong> {{ selectedFeedback.category.title }}</p>
        <p><strong>User:</strong> {{ selectedFeedback.user.name }}</p>
      </div>
    </div>

    <div v-if="selectedFeedback && allComments && allComments.length > 0">
      <div class="box">
        <h3 class="title is-3">All Comments</h3>
        <div v-for="comment in allComments" :key="comment.id" class="comment-box">
          <div class="comment-header">
            <strong>{{ comment.user.name }}</strong>
            <small>{{ comment.created_at }}</small>
          </div>
          <div class="comment-content" v-html="formatCommentText(comment.content)"></div>
        </div>
      </div>
    </div>

    <div class="box mt-5">
      <!-- Comment input form with mention and formatting feature -->
      <textarea v-model="newComment" ref="commentInput" class="textarea" placeholder="Leave a comment..."></textarea>
      <button @click="addFormatting('bold')">Bold</button>
      <button @click="addFormatting('italic')">Italic</button>
      <button @click="addFormatting('code')">Code</button>
      <button @click="submitComment" class="button is-primary mt-3 level">Submit Comment</button>

      <!-- Display success message when comment is submitted -->
      <div v-if="commentSubmitted" class="success-message">
        Comment submitted successfully!
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DOMPurify from 'dompurify';

export default {
  data() {
    return {
      newComment: '',
      selectedFeedback: null,
      allComments: [],
      commentSubmitted: false, // Flag to show success message
    };
  },
  methods: {
    async fetchFeedbackDetails() {
      const feedbackId = this.$route.params.id;
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/feedback/${feedbackId}`);
        this.selectedFeedback = response.data;

        // Fetch all comments associated with the feedback
        this.fetchAllComments();
      } catch (error) {
        console.error('Error fetching feedback details:', error);
      }
    },
    async submitComment() {
      if (!this.newComment || !this.selectedFeedback) {
        return;
      }
      const user_id = sessionStorage.getItem('user_id');

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/comments', {
          feedback_id: this.selectedFeedback.id,
          content: this.newComment,
          user_id: user_id,
        });

        // Update the selected feedback with the new comment
        this.selectedFeedback.comments = this.selectedFeedback.comments || [];
        this.selectedFeedback.comments.push(response.data);

        // Fetch updated list of all comments
        this.fetchAllComments();

        // Clear the comment input and show success message
        this.newComment = '';
        this.commentSubmitted = true;

        // Automatically hide the success message after a few seconds
        setTimeout(() => {
          this.commentSubmitted = false;
        }, 3000);
      } catch (error) {
        console.error('Error submitting comment:', error);
      }
    },
    async fetchAllComments() {
      const feedbackId = this.selectedFeedback.id;
      try {
        const commentsResponse = await axios.get(`http://127.0.0.1:8000/api/comments/${feedbackId}/`);
        this.allComments = commentsResponse.data;
      } catch (error) {
        console.error('Error fetching all comments:', error);
      }
    },
    formatCommentText(text) {
      // Handle mentions
      const mentionRegex = /@(\w+)/g;
      text = text.replace(mentionRegex, (match, username) => {
        // Link mention to user profile or handle as needed
        return `<a href="/user/${username}">${match}</a>`;
      });

      // Handle basic formatting options
      text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>'); // Bold
      text = text.replace(/\*(.*?)\*/g, '<em>$1</em>'); // Italics
      text = text.replace(/`(.*?)`/g, '<code>$1</code>'); // Code block

      return DOMPurify.sanitize(text);
    },
    addFormatting(type) {
      const textarea = this.$refs.commentInput;
      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      const selectedText = textarea.value.substring(start, end);

      let formattedText;
      switch (type) {
        case 'bold':
          formattedText = `**${selectedText}**`;
          break;
        case 'italic':
          formattedText = `*${selectedText}*`;
          break;
        case 'code':
          formattedText = `\`${selectedText}\``;
          break;
        default:
          formattedText = selectedText;
      }

      this.newComment = this.newComment.substring(0, start) + formattedText + this.newComment.substring(end);
    },
  },
  mounted() {
    this.fetchFeedbackDetails();
  },
};
</script>

<style lang="scss" scoped>
/* Basic styling using Bulma CSS framework */
.box {
  margin-bottom: 20px;
}

.comment-box {
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 10px;
}

.comment-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.comment-content {
  margin-top: 10px;
}

.textarea {
  width: 100%;
  resize: vertical;
}

.success-message {
  color: green;
  margin-top: 10px;
}
</style>
