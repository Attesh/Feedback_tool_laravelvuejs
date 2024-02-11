// src/auth.js

// Placeholder function to check if the user is authenticated
export function isAuthenticated() {
  // Implement your logic here, e.g., check if a user token exists in localStorage
  const token = sessionStorage.getItem('user_token');
  

  return token !== null;
}
