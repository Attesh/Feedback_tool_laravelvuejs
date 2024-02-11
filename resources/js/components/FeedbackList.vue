<!-- src/components/FeedbackList.vue -->

<template>
    <div class="home">
      <div class="container mt-5">
        <h2 class="title is-2">Feedback List</h2>
  
        <router-link to="/submit-feedback">
        <button class="button is-primary">Create Feedback</button>
        </router-link>


        <div class="table-container">
          <table class="table is-fullwidth is-hoverable feedback-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>User</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="feedback in paginatedFeedback" :key="feedback.id">
                <td>{{ feedback.title }}</td>
                <td>{{ feedback.category }}</td>
                <td>{{ feedback.name }}</td>
                <td>
                <router-link :to="'/feedback-details/' + feedback.id">
                  <button class="button is-info">Details</button>
                </router-link>
              </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <!-- Pagination section at the bottom-left -->
        <nav class="pagination mt-5" role="navigation" aria-label="pagination">
          <div class="pagination-left">
            <button class="pagination-previous" @click="previousPage" :disabled="currentPage === 1">Previous</button>
          </div>
          <div class="pagination-center">
            <ul class="pagination-list">
              <li v-for="page in totalPages" :key="page">
                <button class="pagination-link" @click="currentPage = page" :class="{ 'is-current': currentPage === page }">{{ page }}</button>
              </li>
            </ul>
          </div>
          <div class="pagination-right">
            <button class="pagination-next" @click="nextPage" :disabled="currentPage === totalPages">Next</button>
          </div>
        </nav>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        feedbackList: [],
        currentPage: 1,
        itemsPerPage: 5,
      };
    },
    computed: {
      paginatedFeedback() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        return this.feedbackList.slice(startIndex, endIndex);
      },
      totalPages() {
        return Math.ceil(this.feedbackList.length / this.itemsPerPage);
      },
    },
    methods: {
      async fetchFeedbackData() {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/feedback');
          this.feedbackList = response.data;
        } catch (error) {
          console.error('Error fetching feedback data:', error);
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage += 1;
        }
      },
      previousPage() {
        if (this.currentPage > 1) {
          this.currentPage -= 1;
        }
      },
    },
    mounted() {
      this.fetchFeedbackData();
    },
  };
  </script>
  
  <style lang="scss" scoped>
  /* Your existing styling code (unchanged) */
  
  .feedback-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  .feedback-table th,
  .feedback-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  .feedback-table th {
    background-color: #f2f2f2;
  }
  
  .pagination {
    margin-top: 20px;
    display: flex;
    align-items: center;
  }
  
  .pagination-left {
    margin-right: auto;
  }
  
  .pagination-center {
    margin: 0 auto;
  }
  
  .pagination-right {
    margin-left: auto;
  }
  
  .pagination-previous,
  .pagination-next {
    margin: 0;
  }


  .home {
  padding: 20px;
}

.container {
  max-width: 100%;
  margin: 0 auto;
}

.title {
  margin-bottom: 20px;
}

.table-container {
  overflow-x: auto;
}

/* Responsive styles */
@media screen and (max-width: 768px) {
  .feedback-table th,
  .feedback-table td {
    padding: 6px;
  }

  .pagination {
    flex-direction: column;
    align-items: center;
  }

  .pagination-left,
  .pagination-right {
    margin: 10px 0;
  }
}

@media screen and (max-width: 576px) {
  .title {
    font-size: 1.5rem;
  }
}

/* Additional styles for very small screens */
@media screen and (max-width: 320px) {
  .feedback-table th,
  .feedback-table td {
    padding: 4px;
  }

  .pagination {
    font-size: 12px;
  }
}
  </style>
  