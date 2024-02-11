import { createRouter, createWebHistory } from 'vue-router';
import FeedbackList from './components/FeedbackList.vue';
import FeedbackForm from './components/FeedbackForm.vue';
import CommentSection from './components/CommentSection.vue';
import LoginForm from './components/LoginForm.vue';
import SignupForm from './components/SignupForm.vue';
import FeedbackDetails from './components/FeedbackDetails.vue';

// Import a function to check if the user is authenticated
import { isAuthenticated } from './auth'; // Adjust the path based on your project structure

const routes = [
  {
    path: '/',
    name: 'home',
    component: FeedbackList,
    meta: { requiresAuth: true }, // Add meta field for authentication
  },
  {
    path: '/submit-feedback',
    name: 'submit-feedback',
    component: FeedbackForm,
    meta: { requiresAuth: true },
  },
  {
    path: '/feedback-details/:id', // Dynamic route parameter for feedback ID
    name: 'FeedbackDetails',
    component: FeedbackDetails,
  },
  {
    path: '/feedback/:id/comments',
    name: 'comment-section',
    component: CommentSection,
    meta: { requiresAuth: true },
  },
  {
    path: '/login',
    name: 'LoginForm',
    component: LoginForm,
    beforeEnter: (to, from, next) => {
        // Check if the user is already logged in
        if (isAuthenticated()) {
          // Redirect to another page if the user is logged in
          next('/');
        } else {
          // Allow access to the login page
          next();
        }
      },
  },
  {
    path: '/signup',
    name: 'SignUp',
    component: SignupForm,
  },
  {
    path: '/:catchAll(.*)',
    redirect: '/',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !isAuthenticated()) {
    next({ name: 'LoginForm' });
  } else {
    next();
  }
});

export default router;
