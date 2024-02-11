<!-- src/components/LoginForm.vue -->

<template>
  <div class="login-form">
    <div class="login-header">
      <h2 class="title">
        <i class="fas fa-user"></i> Login
      </h2>
    </div>
    <form @submit.prevent="submitLoginForm">
      <div class="field">
        <label class="label">Email</label>
        <div class="control">
          <input v-model="user.email" class="input" type="email" placeholder="Enter your email" required />
        </div>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <div class="control">
          <input v-model="user.password" class="input" type="password" placeholder="Enter your password" required />
        </div>
      </div>

      <!-- Display error or success message -->
      <div id="message" :class="{ 'error-message': errorMessage, 'success-message': successMessage }">
        {{ errorMessage || successMessage }}
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Login</button>
        </div>
      </div>
    </form>

    <!-- Sign-up button -->
    <div class="signup-link">
      <router-link to="/signup" class="button is-link">
        Sign Up
      </router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: {
        email: '',
        password: '',
      },
      errorMessage: '',
      successMessage: '',
    };
  },
  methods: {
    async submitLoginForm() {
      try {
        // Send login data to the Laravel API endpoint
        const response = await axios.post('http://127.0.0.1:8000/api/login', this.user);

        // Handle successful login
        console.log(response.data);

        this.errorMessage = '';
        this.successMessage = 'Login successful!';

        sessionStorage.setItem('user_token', response.data.token);
        sessionStorage.setItem('user_id', response.data.user_id);
        window.location.reload();
        // this.$router.push('/');
      } catch (error) {
        // Handle login error
        console.error(error);

        // Display an error message to the user
        this.errorMessage = 'Invalid email or password';
        this.successMessage = '';
      }
    },
  },
};
</script>

<style lang="scss" scoped>
/* Add your component-specific styles here */
.login-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

/* Add styles for error and success messages */
.error-message {
  color: #ff0000; /* Red color for error messages */
}

.success-message {
  color: #008000; /* Green color for success messages */
}

.login-header {
  text-align: center;
}

.title {
  font-size: 24px;
  margin-bottom: 20px;

  i {
    margin-right: 10px;
  }
}

.label {
  font-size: 16px;
  margin-bottom: 5px;
}

.input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
}

.button {
  width: 100%;
}

.signup-link {
  margin-top: 10px;
  text-align: center;
}
</style>
