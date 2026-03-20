# SavoryHub - PHP Integration (Phase 3)

SavoryHub is a recipe management web application featuring user authentication, recipe submissions, and a contact form, fully integrated with a MySQL database.

## Prerequisites
- XAMPP or WAMP server installed.
- PHP 7.4 or higher.

## Setup Instructions

1. **Move Project Folder**: 
   Ensure this entire `project2` folder is moved to the `htdocs` directory of your XAMPP installation (usually `C:\xampp\htdocs\project2\`) or WAMP's `www` directory.

2. **Start Services**:
   Open XAMPP Control Panel and start **Apache** and **MySQL** services.

3. **Import the Database**:
   - Go to `http://localhost/phpmyadmin` in your web browser.
   - You can either manually create a database named `savoryhub` OR simply go to the **Import** tab.
   - Click "Choose File" and select `database.sql` located inside the root of this project folder.
   - Click "Import". This will automatically create the `savoryhub` database along with the `users`, `messages`, and `recipes` tables.

4. **Access the Website**:
   - Open your browser and navigate to: `http://localhost/project2/index.php` .
   - You can now Register, Login, Submit recipes, and use the Contact form!

## Folder Structure Update
- `includes/`: Contains `db.php` for database connections and `functions.php` for helper methods.
- `auth/`: Contains logic for `login.php`, `register.php`, and `logout.php`.
- The main files have been converted from `.html` to `.php` to securely handle sessions and database interactions.
