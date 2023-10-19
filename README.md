# Student Management System (SMS)

## Table of Contents
- [Project Description](#project-description)
- [Functionality](#functionality)
- [User Roles](#user-roles)
- [Installation](#installation)
- [Usage](#usage)
- [Authentication](#authentication)
- [Admin Dashboard](#admin-dashboard)
- [Teacher Dashboard](#teacher-dashboard)
- [Course Management by Teachers](#course-management-by-teachers)
- [Attendance Tracking](#attendance-tracking)
- [Grading](#grading)
- [Student Dashboard](#student-dashboard)
- [Reporting](#reporting)
- [Backend Technology](#backend-technology)

## Project Description
The Student Management System (SMS) is a web-based application designed to simplify teacher-led control over student data, attendance, and grades. It offers a user-friendly interface for students, teachers, and administrators to manage and access information.

## Functionality
The system provides the following key functionalities:

### User Roles
1. **Admin:** Manages teachers, students, and system roles.
2. **Teachers:** Add and manage students, student data, attendance, and grades.
3. **Students:** View attendance, personal data, and grades.

### Installation
Please refer to the [Installation Guide](installation.md) for detailed instructions on how to set up the system.

### Usage
Detailed instructions on using the Student Management System can be found in the [Usage Guide](usage.md).

### Authentication
The system uses JSON Web Tokens (JWT) for authentication. When making API requests, you should include a JWT token in the headers to authenticate. To get started, follow the steps in the [Authentication Guide](authentication.md).

### Admin Dashboard
- Admins can manage teacher accounts.
- Control user roles and permissions.

### Teacher Dashboard
- Teachers have access to a teacher-specific dashboard.
- They can view the courses/classes they teach.

### Course Management by Teachers
- Teachers can create classes, assign subject names, and set class size limits (up to 75 students).
- Enroll students in classes.
- View student lists for each class.

### Attendance Tracking
- Teachers can mark student attendance.
- Students can access their attendance records.

### Grading
- Teachers input grades for assignments, exams, and other assessments.
- Students can review their grades for courses.

### Student Dashboard
- Students have access to a student-specific dashboard.
- They can view their personal information.

### Reporting
- Generate attendance and grade reports.

## Backend Technology
This project utilizes Laravel for the backend, which serves as the REST API for the system.

## Contributing
If you would like to contribute to this project, please refer to the [Contributing Guidelines](CONTRIBUTING.md).

## License
This project is licensed under the [MIT License](LICENSE.md).

## Author
- [Your Name]

## Contact Information
For questions or feedback, you can reach out to [your email address].
