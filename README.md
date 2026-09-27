# 🎓 Student & Examination Management Portal

A PHP and MySQL based web application for managing student registration, authentication, student information, examination forms, semester-wise subjects, and examination-related workflows.

> **Project Type:** Academic / Personal Software Project  
> **Backend:** PHP  
> **Database:** MySQL  
> **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5

---

## 📌 Overview

The **Student & Examination Management Portal** is a web-based application developed to provide a structured digital workflow for students and examination-related information.

The system allows students to:

- Register their account
- Upload their profile photograph
- Log in using email or enrollment number
- Access a protected student dashboard
- View their academic and personal information
- Fill examination forms
- Select semester and examination type
- Select subjects according to semester
- View submitted examination information
- Print examination details
- Manage their password
- Log out securely

The project demonstrates backend development, database integration, authentication, session management, form processing, file uploads, and responsive frontend development.

---

# ✨ Features

## 👨‍🎓 Student Registration

Students can register by providing required personal and academic information.

### Registration information includes:

- Candidate Name
- Enrollment Number
- Roll Number
- Father's Name
- Mother's Name
- Date of Birth
- Gender
- Nationality
- Religion
- Course
- Admission Year
- Email
- Mobile Number
- Password
- Profile Photograph

The registration process validates required information before creating a student account.

---

# 🔐 Student Authentication

Students can log in using:

```
Email
OR
Enrollment Number
+
Password
The authentication system uses PHP sessions to maintain the logged-in student's state.

Passwords are stored using password hashing instead of storing plain-text passwords.

Authentication Flow
                ┌─────────────────┐
                │     Student     │
                └────────┬────────┘
                         │
                         ▼
                ┌─────────────────┐
                │    Login Page   │
                └────────┬────────┘
                         │
                 Email / Enrollment
                         +
                      Password
                         │
                         ▼
                ┌─────────────────┐
                │     MySQL       │
                │ Student Record  │
                └────────┬────────┘
                         │
                         ▼
                Password Verification
                         │
                ┌────────┴────────┐
                │                 │
              Valid             Invalid
                │                 │
                ▼                 ▼
           Dashboard            Error
```
# 📊 Student Dashboard

After successful authentication, students can access their protected dashboard.

The dashboard provides access to:

Student Data
Examination Form
Contact
Password Management
Logout

The logged-in student's name and academic information can also be displayed.

#👤 Student Information

The student information section displays information stored in the database.

Information includes:
Candidate Name
Enrollment Number
Roll Number
Father's Name
Mother's Name
Date of Birth
Gender
Nationality
Religion
Course
Admission Year
Email
Mobile Number
Profile Photograph

Student information can be displayed in a structured format suitable for viewing and printing.

#  📝 Examination Form

The examination form allows students to submit examination-related information.

Students can select:

Course
Semester
Examination Type
Subjects
Examination Types
Regular
Ex
Back

The available subjects are determined according to the selected semester.

# 📚 Semester-Wise Subjects

The application supports semester-based subject selection.

Subjects contain information such as:

Subject Code
Subject Name
Subject Type
Subject Types
THEORY
PRACTICAL

When a student selects a semester, the application can retrieve the corresponding subjects from the database.

# 📄 Examination Submission

After selecting the required examination information and subjects, the student can submit the examination form.

The submitted examination information includes:

Student ID
Course
Semester
Exam Type
Selected Subjects
Submission Date

The submitted information is stored in the MySQL database.

# 🖨️ Print Examination Details

After submitting the examination form, students can view their examination information and use the browser's print functionality to generate a printable copy.

The printable information can include:

Student Name
Enrollment Number
Semester
Examination Type
Submission Date
Selected Subjects
Student Photograph

# 🔑 Password Management

The application includes password-management functionality for students.

Password-related workflows include:

Password verification
Password hashing
Password change/reset functionality

Passwords are not intended to be stored as plain text.

#🚪 Logout

Students can securely end their current session using the logout functionality.

The logout process destroys the active student session and redirects the user appropriately.

🛠️ Technology Stack
Frontend
HTML5
CSS3
JavaScript
Bootstrap 5
Backend
PHP
Database
MySQL
UI Libraries
Bootstrap
Font Awesome
Animate.css
Authentication
PHP Sessions
password_hash()
password_verify()

```🏗️ System Architecture
                        ┌─────────────────────┐
                        │       Student       │
                        └──────────┬──────────┘
                                   │
                                   ▼
                        ┌─────────────────────┐
                        │ Registration / Login│
                        └──────────┬──────────┘
                                   │
                                   ▼
                        ┌─────────────────────┐
                        │ Authentication &    │
                        │ Session Management  │
                        └──────────┬──────────┘
                                   │
                                   ▼
                        ┌─────────────────────┐
                        │      Dashboard      │
                        └──────────┬──────────┘
                                   │
                  ┌────────────────┼────────────────┐
                  │                │                │
                  ▼                ▼                ▼
          ┌───────────────┐ ┌───────────────┐ ┌───────────────┐
          │ Student Data  │ │ Examination   │ │   Password    │
          │               │ │     Form      │ │   Management  │
          └───────┬───────┘ └───────┬───────┘ └───────────────┘
                  │                 │
                  ▼                 ▼
          ┌───────────────┐ ┌───────────────┐
          │    Student    │ │ Examination   │
          │    Records    │ │     Data      │
          └───────┬───────┘ └───────┬───────┘
                  │                 │
                  └────────┬────────┘
                           ▼
                   ┌─────────────────┐
                   │      MySQL      │
                   │    Database     │

                   └─────────────────┘
```
```🔄 Examination Form Workflow
Student Login
      │
      ▼
Student Dashboard
      │
      ▼
Examination Form
      │
      ▼
Select Course
      │
      ▼
Select Semester
      │
      ▼
Select Examination Type
      │
      ▼
Load Semester Subjects
      │
      ▼
Select Subjects
      │
      ▼
Submit Examination Form
      │
      ▼
Store Data in MySQL
      │
      ▼
Display Examination Details
      │
      ▼
Print / Download
```
```🗄️ Database

The application uses MySQL for persistent data storage.

The database stores student information and examination-related records.

Examination Form Data

The examination form stores information such as:

student_id
course
semester
exam_type
subjects
created_at

The selected subjects are associated with the student's submitted examination form.
```
```📁 Project Structure
student-examination-portal/
│
├── index.php
├── config.php
│
├── login.php
├── register.php
├── logout.php
├── forget_password.php
│
├── student_info.php
├── student_data.php
├── exam_form.php
├── contact.php
│
├── asset/
│   └── logo.svg
│
├── uploads/
│   └── student-images/
│
├── admin/
│   ├── login.php
│   ├── dashboard.php
│   └── ...
│
├── database/
│   └── database.sql
│
└── README.md
```

``` ⚙️ Requirements

Before running the project, install:

PHP 8.x or compatible PHP version
MySQL
Apache
XAMPP / WAMP / Laragon
Web browser

Recommended local environments:

XAMPP
WAMP
Laragon
```
```# 🚀 Installation

1. Clone Repository
git clone YOUR_REPOSITORY_URL
2. Open Project Directory
cd student-examination-portal
3. Start Apache and MySQL

If using XAMPP:

Apache → Start
MySQL  → Start
4. Move Project

For XAMPP:

C:\xampp\htdocs\

Place the project inside:

C:\xampp\htdocs\student-examination-portal
```
```🗄️ Database Setup

Create Database

Open phpMyAdmin and create:

CREATE DATABASE student_portal;

Import Database

If the repository contains a SQL file:

database/database.sql

Import it into the newly created database.
``` 
```🔧 Database Configuration

Open:

config.php

Configure the database connection.

Example:

<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "student_portal";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Database connection failed.");
}
?>

Do not upload real production database credentials to GitHub.
```
```▶️ Run the Project

Start Apache and MySQL, then open:

http://localhost/student-examination-portal/
```
```🔒 Security

The project uses several basic security practices.

Password Hashing

Passwords should be stored using:

password_hash()

and verified using:

password_verify()
Session Authentication

PHP sessions are used to maintain authenticated student sessions.

Prepared Statements

Database queries should use prepared statements where user input is involved.

Output Escaping

User-controlled values should be escaped before being displayed in HTML.

Example:

htmlspecialchars($value)
```
```📱 Responsive Design

The interface is designed using Bootstrap's responsive grid and components.

The application can be used across:

Desktop
Laptop
Tablet
Mobile

Responsive areas include:

Navigation
Registration form
Login form
Student dashboard
Examination form
Student information
Tables
Buttons
🎨 UI

The interface uses a university-style academic design with:

Responsive navigation
Bootstrap components
Structured forms
Student dashboard
Academic information sections
Examination workflow
Campus imagery
Responsive layouts

```

```The main objectives of this project are to demonstrate practical implementation of:

PHP development
MySQL database integration
User authentication
Session management
Password hashing
Form validation
File upload handling
Student management
Examination form processing
Semester-wise subject management
Database-driven applications
Responsive UI development
Printable academic documents
```
```💡 What I Learned

Through this project, I worked with:

PHP Backend Development
MySQL Database Design
Authentication
Sessions
Password Hashing
Prepared Statements
Form Validation
File Uploads
AJAX / Dynamic Data
Bootstrap
Responsive Web Design
CRUD Operations
Database Relationships
```
```🚧 Current Status
Project Status: Development / Academic Project

The current implementation focuses on student registration, authentication, student information, examination-form workflows, subject selection, and database integration.
```

```🔮 Future Improvements

Potential future improvements include:

Admin dashboard
Role-based access control
Complete student CRUD management
Branch management
Semester management
Subject management
Examination result management
Grade-card generation
PDF generation
Email notifications
OTP-based password recovery
CSRF protection
Login rate limiting
Audit logs
Advanced reporting
REST API
API-based frontend
Better production configuration
Automated testing
```
```🧪 Testing Checklist

Before deployment, test:

[ ] Student registration
[ ] Duplicate email handling
[ ] Duplicate enrollment handling
[ ] Invalid email
[ ] Invalid password
[ ] Login with email
[ ] Login with enrollment number
[ ] Invalid login
[ ] Session protection
[ ] Logout
[ ] Student information
[ ] Profile image upload
[ ] Semester selection
[ ] Subject loading
[ ] Examination form submission
[ ] Examination form retrieval
[ ] Print functionality
[ ] Password change/reset
[ ] Mobile layout
[ ] Desktop layout
[ ] Database connection

```
```🌐 Deployment

The application can be deployed on a PHP-compatible hosting environment.

Required server components:

PHP
MySQL
Apache / compatible web server

Before production deployment:

Move credentials to environment/configuration variables
Disable development error output
Validate uploaded files
Enable HTTPS
Add CSRF protection
Review authentication
Restrict database permissions
Backup the database
Test all forms
Test mobile responsiveness
```

```⚠️ Disclaimer

This is an independent educational/personal software project.

The application may use university-style terminology, design elements, or publicly available campus imagery for demonstration purposes.

It should not be represented as an official university system unless explicit authorization has been obtained.
```
👨‍💻 Developer
Zakir Hussain

Computer Engineering
Software Developer

Connect

🐙 GitHub
https://github.com/Ahan-07

📄 License

This project is intended for educational and portfolio purposes.

If you want to allow others to use, modify, and distribute the source code, add an appropriate open-source license to the repository.

⭐ Support

If you find this project useful or interesting, consider giving the repository a ⭐.

Thank you for checking out the project!
