# EenvoudigeDatabase Project

## Overview
EenvoudigeDatabase is a simple PHP application that provides a dashboard with CRUD (Create, Read, Update, Delete) functionalities. It allows users to manage records in a database through a user-friendly interface.

## Project Structure
```
EenvoudigeDatabase
├── src
│   ├── config
│   │   └── database.php
│   ├── controllers
│   │   └── CRUDController.php
│   ├── models
│   │   └── Database.php
│   └── views
│       ├── dashboard.php
│       ├── create.php
│       ├── edit.php
│       └── delete.php
├── public
│   ├── index.php
│   ├── css
│   │   └── style.css
│   └── js
│       └── script.js
├── .htaccess
└── README.md
```

## Installation
1. Clone the repository or download the project files.
2. Place the `EenvoudigeDatabase` folder in the `c:\xampp\htdocs\` directory.
3. Start the XAMPP control panel and ensure that Apache and MySQL services are running.
4. Create a new database in MySQL and import the necessary SQL schema (if provided).
5. Update the database connection settings in `src/config/database.php` with your database credentials.

## Usage
- Navigate to `http://localhost/EenvoudigeDatabase/public/index.php` in your web browser.
- Use the dashboard to create, view, edit, and delete records.

## Features
- User-friendly dashboard for managing records.
- Responsive forms for creating and editing records.
- Confirmation dialogs for delete operations.
- Clean and organized code structure for easy maintenance.

## Contributing
Feel free to submit issues or pull requests for improvements and bug fixes.

## License
This project is open-source and available under the MIT License.