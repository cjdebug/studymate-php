# StudyMate

StudyMate is a student task and study planner web application built as a personal backend development project. The goal of this project is to improve my practical backend skills using PHP, MySQL, sessions, authentication, CRUD operations, and live deployment.

The application helps students organize their university work by managing subjects, study tasks, deadlines, priorities, and task progress.

## Project Status

This project is currently under development.

### Completed

- Initial project folder structure
- MySQL database setup
- Database connection using PDO
- Reusable header and footer
- Homepage
- User registration
- Secure password hashing
- User login
- User logout
- PHP session-based authentication
- Protected dashboard
- Basic Bootstrap layout

### Planned

- Subjects management
- Tasks management
- Edit and delete features
- Mark tasks as completed
- Task filtering by status and priority
- Dashboard statistics
- Improved UI design
- Railway live deployment
- Demo login account
- Screenshots

## Features

### Current Features

- User registration
- User login
- User logout
- Protected dashboard
- Password hashing using PHP `password_hash()`
- Password verification using PHP `password_verify()`
- Database queries using PDO prepared statements
- Bootstrap-based responsive layout

### Upcoming Features

- Add subjects/modules
- View subjects
- Edit subjects
- Delete subjects
- Add study tasks
- View tasks
- Edit tasks
- Delete tasks
- Mark tasks as completed
- Filter tasks
- View dashboard summary counts

## Tech Stack

- PHP
- MySQL
- HTML
- CSS
- Bootstrap
- JavaScript
- XAMPP for local development
- Railway for planned live deployment

## Project Structure

```text
studymate/
│
├── auth/
│   ├── register.php
│   ├── login.php
│   └── logout.php
│
├── config/
│   ├── app.php
│   └── database.php
│
├── database/
│   └── schema.sql
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── public/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
│
├── dashboard.php
├── index.php
├── .env.example
├── .gitignore
└── README.md
```

## Database

The project uses a MySQL database named:

```text
studymate
```

The database contains the following main tables:

- `users`
- `subjects`
- `tasks`

The database structure is available in:

```text
database/schema.sql
```

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/studymate.git
```

### 2. Move the project to XAMPP

Place the project folder inside:

```text
C:\xampp\htdocs
```

The path should look like:

```text
C:\xampp\htdocs\studymate
```

### 3. Start XAMPP

Start:

```text
Apache
MySQL
```

### 4. Create the database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
studymate
```

### 5. Import the database tables

Import or run the SQL file:

```text
database/schema.sql
```

### 6. Open the project

Open the project in your browser:

```text
http://localhost/studymate
```

## Environment Variables

This project includes an `.env.example` file to show the required environment variables.

Example:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=studymate
DB_USER=root
DB_PASSWORD=
APP_BASE_URL=/studymate
```

The real `.env` file should not be uploaded to GitHub because it may contain private database details.

## Security Features Used

This project includes basic backend security practices such as:

- Password hashing instead of storing plain text passwords
- Password verification using `password_verify()`
- PDO prepared statements to reduce SQL injection risk
- Session-based authentication
- Protected dashboard access
- `htmlspecialchars()` when displaying user-provided data

## Development Note

This project was built as a personal backend development project to improve my practical knowledge of PHP, MySQL, authentication, CRUD operations, and deployment.

During development, I used AI as a learning guide because I could not find a YouTube tutorial that matched the exact type of project and explanation style I needed. I did not use it only to copy and paste code. I used it to get step-by-step guidance, understand the purpose of each file, learn how the code works, and improve the structure of the project.

I reviewed the code, tested each feature locally, fixed issues, added comments where needed, and made sure I understood the main backend concepts used in the project, such as database connection, password hashing, sessions, prepared statements, and user authentication.

## Live Demo

Live demo will be added after deployment.

```text
Coming soon
```

## Demo Account

A demo account will be added after deployment.

```text
Coming soon
```

## Author

**Chanuka Jayasundara**

Personal backend development project.

GitHub: `https://github.com/cjdebug`