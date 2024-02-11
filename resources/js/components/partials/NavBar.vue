<!-- src/components/NavBar.vue -->

<template>
  <nav class="navbar container" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <router-link to="/" class="navbar-item">
        <!-- Your logo or brand icon goes here -->
        <img src="@/assets/logo.png" alt="Logo">
      </router-link>

      <!-- Burger menu for mobile -->
      <a
        role="button"
        class="navbar-burger burger"
        aria-label="menu"
        aria-expanded="false"
        @click="toggleNavbar"
        :class="{ 'is-active': isNavbarActive }"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbar" class="navbar-menu" :class="{ 'is-active': isNavbarActive }">
      <div class="navbar-start">
        <router-link to="/" class="navbar-item">Home</router-link>
        <!-- <router-link to="/about" class="navbar-item">About</router-link> -->
      </div>
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <!-- Show "Sign In" or "Logout" based on user login status -->
            <template v-if="!isLoggedIn">
              <a class="button is-dark" @click="showLoginForm">
                <strong>Sign In</strong>
              </a>
            </template>
            <template v-else>
              <button class="button is-dark" @click="logout">
                <strong>Logout</strong>
              </button>
            </template>
          </div>
        </div>
      </div>
    </div>

    <!-- Add the login form component -->
    <LoginForm v-if="showLogin" />
  </nav>
</template>

<script>
import LoginForm from '@/components/LoginForm.vue'; // Adjust the path based on your project structure

export default {
  name: 'NavBar',
  components: {
    LoginForm,
  },
  data() {
    return {
      showLogin: false,
      isLoggedIn: false,
      isNavbarActive: false,
    };
  },
  methods: {
    showLoginForm() {
      this.$router.push('/login');
    },
    async logout() {
      try {
        // Call your logout API endpoint
        // await axios.post('http://127.0.0.1:8000/api/logout');

        // Clear user session or perform additional logout logic
        sessionStorage.removeItem('user_token');

        // Update isLoggedIn status
        this.isLoggedIn = false;

        // Force a reactivity update
        this.$forceUpdate();

        // Redirect the user to the desired page or perform additional actions
        this.$router.push('/login');
      } catch (error) {
        // Handle logout error
        console.error(error);
        // Display an error message to the user if needed
      }
    },
    toggleNavbar() {
      this.isNavbarActive = !this.isNavbarActive;
    },
  },
  created() {
    // Check if the user is already logged in (e.g., user_token in session or local storage)
    const userToken = sessionStorage.getItem('user_token');
    // Update the value of isLoggedIn accordingly
    this.isLoggedIn = !!userToken;
  },
};
</script>

<style lang="scss" scoped>
nav {
  margin-top: 25px;
  margin-bottom: 30px;

  .navbar-item {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #d88d00;
    }
  }

  .buttons {
    a.button {
      font-weight: bold;
    }
  }

  // Responsive adjustments
  @media screen and (max-width: 1088px) {
    .navbar-menu {
      display: none;
    }

    .navbar-burger {
      display: block;
    }

    .navbar.is-active .navbar-menu {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
    }
  }

  @media screen and (max-width: 1023px) {
    .navbar-menu.is-active {
      display: block;
    }
  }
  }
</style>
