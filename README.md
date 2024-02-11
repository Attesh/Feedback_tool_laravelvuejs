# Feedback Tool

## Project Overview

This project is a web-based Feedback Tool that allows users to submit and view feedback. It includes user authentication, a user-friendly feedback submission form, a paginated list of feedback items, and a commenting system with basic formatting options.

## Technical Requirements

### User Authentication

1. Implement user authentication using Sanctum or Passport when implementing Vue.js or React.js on the frontend.
2. Users can register, log in, and log out.

### Feedback Submission

1. Create a user-friendly form for submitting feedback.
2. Feedback should include a title, description, and a category (e.g., bug report, feature request, improvement, etc.).
3. Implement validation to ensure required fields are filled out.

### Feedback Listing

1. Display feedback items in a paginated list.
2. Each feedback item should display its title, category, and the user who submitted it.

### Commenting System

1. Enable users to leave comments on feedback items.
2. Comments should include the user's name, date, and content.
3. Implement basic formatting options (e.g., bold, italic, code blocks) for comments.

### Bonus Features (Mandatory for Seniors)

1. Allow users to mention other users in comments using the "@" symbol.

## How to Run the Project

Follow these steps to run the project:

### Prerequisites

- Make sure you have npm and Node.js installed (npm -v10.2.4, node -v20.11.0).
- made this project in (npm -v10.2.4   & node -v20.11.0)
- Run `composer update` to update PHP dependencies.
- Run `npm install` to install JavaScript dependencies.

### Start the Backend

1. Configure your database settings in the `.env` file.
2. Run migrations: `php artisan migrate`.
3. Seed the database with sample data (optional): `php artisan db:seed`.
4. Start the backend server: `php artisan serve`.

### Start the Frontend

1. Run `npm install` to install frontend dependencies.
2. Start the frontend server: `npm run serve`.



Visit `http://localhost:8000` to access the Feedback Tool.

