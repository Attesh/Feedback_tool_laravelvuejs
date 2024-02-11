// src/plugins/axios.js

import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000/api', // Adjust the URL based on your Laravel backend configuration
});

export default instance;
