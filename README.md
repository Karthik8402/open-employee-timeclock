# PHP Timeclock (Modernized)

A web-based employee time tracking system, originally built in 2010. This repository contains the source code for a legacy PHP application that is currently undergoing migration to modern standards (PHP 8.4 + MySQL 5.7).

## ? Project Status: **MIGRATION IN PROGRESS**
> [!WARNING]
> The `master` branch contains **LEGACY CODE** (PHP 4/5 style).
> It relies on `mysql_*` functions which verify removed in PHP 7.0.
> **DO NOT** try to run this on a modern server without following the migration guide.

## ?? Features
- **Time Tracking**: Clock In, Clock Out, Break, Lunch.
- **Administration**: Manage employees, offices, and groups.
- **Reporting**: detailed hours-worked reports and audit logs.
- **IP Restriction**: Limit clock-in ability to specific office networks.

### Phase 4: Security & Auth (Completed)
- [x] **Refactor Authentication**
    - [x] Modify `public/login.php` to check password hash using `password_verify`
    - [x] Fallback support for legacy passwords (re-hash on login?) or force reset? *Decision: Manual reset best for security, or auto-update on first login.*
- [x] **Refactor User Creation/Editing**
    - [x] Modify `public/admin/usercreate.php` to use `password_hash`
    - [x] Modify `public/admin/useredit.php` to use `password_hash`
    - [x] Modify `public/leftmain.php` (Employee Timeclock Login) to use `password_verify`
- [ ] **Output Escaping**
    - [ ] Audit `display.php` and `timeclock.php` for XSS vulnerabilities.

## ?? Setup Guide (XAMPP / Localhost)

### 1. Database Setup
1. Open **phpMyAdmin**.
2. Create a new database named `eatime`.
3. Import the `create_tables.sql` file from the root directory.
   *(Note: You may need to change `TYPE=MyISAM` to `ENGINE=InnoDB` in the SQL file first).*

### 2. Configuration
1. Copy `config.inc.example.php` to `config.inc.php`.
2. Edit `config.inc.php` and set your database credentials:
   ```php
   $db_hostname = "localhost";
   $db_username = "root";
   $db_password = "";
   $db_name = "eatime";
   ```
3. **Important**: You must also update `dbc.php` with the same credentials (until the refactor is complete).

### 3. Migration (Required for PHP 8+)
The code requires significant refactoring to run on modern PHP.
- **Goal**: Replace `mysql_*` with PDO.
- **Progress**:- [x] **Security Implementation**
    - [x] `password_hash` migration.
    - [x] SQL Injection fixes (basic).

## ?? Technologies
- **Backend**: PHP (Legacy) -> Target: PHP 8.4
- **Database**: MySQL 5.7+
- **Frontend**: HTML4, CSS, JavaScript

## ?? Credentials
- **Default Admin**: `admin`
- **Default Password**: (Check `create_tables.sql` or reset via database)

---
*Original project appears to be a customized version of "PHP Timeclock 1.04" (c) 2010.*
