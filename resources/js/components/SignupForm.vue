<template>
    <div class="signup-form">
      <div class="signup-header">
        <h2 class="title">
          <i class="fas fa-user-plus"></i> Sign Up
        </h2>
      </div>
      <form @submit.prevent="submitSignupForm">
        
        <div class="field">
          <label class="label">Name</label>
          <div class="control">
            <input v-model="user.name" class="input" type="text" placeholder="Enter your name" required />
          </div>
        </div>
  
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
  
        <div class="field">
          <label class="label">Confirm Password</label>
          <div class="control">
            <input v-model="user.confirmPassword" class="input" type="password" placeholder="Confirm your password" required />
          </div>
        </div>
  
        <div id="message">{{ message }}</div>
  
        <div class="field">
          <div class="control">
            <button class="button is-primary" type="submit">Sign Up</button>
          </div>
        </div>
      </form>
  
      <!-- Login link -->
      <div class="login-link">
        <router-link to="/login" class="button is-link">
          Login
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
          name: '',
          email: '',
          password: '',
          confirmPassword: '',
        },
        message: '',
      };
    },
    methods: {
      async submitSignupForm() {
        // Check if passwords match
        if (this.user.password !== this.user.confirmPassword) {
          // Display an error message to the user
          this.message = 'Passwords do not match';
          console.error('Passwords do not match');
          this.clearMessageAfterDelay();
          return;
        }
  
        try {
          // Send signup data to the Laravel API endpoint
          const response = await axios.post('http://127.0.0.1:8000/api/register', this.user);
  
          // Handle successful signup
          console.log(response.data);
          this.message = 'Signup successful!';
          this.clearMessageAfterDelay();
  
          // Redirect the user to the desired page or perform additional actions
          this.$router.push('/login');
        } catch (error) {
          // Handle signup error
          console.error(error);
  
          // Check for the specific error message from the API
          if (error.response && error.response.data && error.response.data.message) {
            this.message = error.response.data.message;
          } else {
            this.message = 'Signup failed. Please try again.';
          }
  
          this.clearMessageAfterDelay();
          // Display an error message to the user if needed
        }
      },
      clearMessageAfterDelay() {
        // Clear the message after 5 seconds
        setTimeout(() => {
          this.message = '';
        }, 5000);
      },
    },
  };
  </script>
  
  <style lang="scss" scoped>
  /* Add your component-specific styles here */
  .signup-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
  }
  
  .signup-header {
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
  
  .login-link {
    margin-top: 10px;
    text-align: center;
  }
  
  #message {
    color: red;
  }
  </style>
  