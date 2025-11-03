# Wedding Planner (PHP MVC Project)

A simple **Wedding Planning Website** built using **PHP**, **MySQL**, and the **MVC (Model–View–Controller)** architecture.
Users can **sign up**, **log in**, and **log out** securely. This project is designed to demonstrate a clean separation of concerns between logic, data, and presentation layers.

---

## Features

* Secure **user registration and login**
* **Session management** for authenticated users
* MVC structure (Model–View–Controller)
* Automatically creates and connects to MySQL database via `database.php`
* Built to run locally on **MAMP**, **XAMPP**, or similar environments

---

## Project Structure

```
WeddingPlanner/
│
├── index.php                # Main entry point
├── database.php             # Database connection and setup
│
├── controllers/
│   ├── Controller.php        # Base controller
│   └── AuthController.php    # Handles login/signup/logout logic
│
├── models/
│   └── Model.php             # Database queries and operations
│
├── views/
│   └── View.php              # Handles HTML rendering
│
├── login.php                 # Login page
├── signup.php                # Registration page
├── logout.php                # Logout endpoint
└── README.txt                # Local setup guide
```

---

## Setup Instructions (MAMP)

1. Copy the project folder to:

   ```
   /Applications/MAMP/htdocs/WeddingPlanner
   ```
2. Start **MAMP** (ensure Apache and MySQL servers are running).
3. Visit:

   ```
   http://localhost:8888/WeddingPlanner/login.php
   ```

   or, if using the default port:

   ```
   http://localhost/WeddingPlanner/login.php
   ```
4. On first load, the database and tables are automatically created via `database.php`.

---

## Demo Credentials

| Username                              | Password |
| ------------------------------------- | -------- |
| [demo@test.com](mailto:demo@test.com) | 123456   |

You can also register your own account using the **Sign Up** page.

---

## Future Improvements

* Include cookies/session
* Enhance UI/UX

---
