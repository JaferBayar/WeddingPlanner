# Wedding Planner (PHP MVC - MAMP)

## Quick Start
1. Copy the `WeddingPlanner` folder to `/Applications/MAMP/htdocs/`.
2. Start MAMP (Apache + MySQL).
3. Open http://localhost:8888/WeddingPlanner/login.php (or http://localhost/WeddingPlanner/login.php depending on your MAMP port).
4. On first run, the database and tables will be created automatically from `database.php` when the site loads models.
5. You can:
   - Click **Quick Login** (demo@test.com / 123456) or
   - **Guest Login**, or
   - **Sign up** a new account.

## Structure
- index.php — front controller that invokes `controllers/Controller.php`
- controllers/
  - Controller.php — OOP wrapper to render the main page
  - AuthController.php — auth/session functions
- models/
  - Model.php — DB access functions (includes `../database.php`)
- views/
  - View.php — rendering helpers (header/body + forms)
- database.php — creates DB/tables and seeds sample data
- login.php, signup.php, logout.php — auth pages
