<p align="center">
  <img src="public/images/rsuGlobal.png" width="200" alt="RSUGlobal Logo">
</p>

<h1 align="center">RSUGlobal</h1>

<p align="center">
  An educational mentoring platform for Rangsit University's International Language Center — connecting students, mentors, team leaders, and administrators in one unified system.
</p>

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Clone the Repository](#1-clone-the-repository)
    - [Install PHP Dependencies](#2-install-php-dependencies)
    - [Install Node Dependencies](#3-install-node-dependencies)
    - [Create the Environment File](#4-create-the-environment-file)
    - [Generate the Application Key](#5-generate-the-application-key)
    - [Set Up the SQLite Database](#6-set-up-the-sqlite-database)
    - [Seed the Database](#7-seed-the-database-optional-but-recommended)
    - [Build Frontend Assets](#8-build-frontend-assets)
    - [Serve the Application](#9-serve-the-application)
    - [Common Issues & Fixes](#common-issues--fixes)
- [Project Structure](#project-structure)
- [Roles & Workflows](#roles--workflows)
    - [Guest](#guest)
    - [Student](#student)
    - [Mentor](#mentor)
    - [Team Leader](#team-leader)
    - [Admin](#admin)
- [Route Reference](#route-reference)
    - [Public / Auth Routes](#public--auth-routes)
    - [Student Routes](#student-routes)
    - [Mentor Routes](#mentor-routes)
    - [Team Leader Routes](#team-leader-routes)
    - [Admin Routes](#admin-routes)
- [Database Schema](#database-schema)
- [Key Features](#key-features)
- [Development](#development)

---

## Overview

RSUGlobal is a Laravel-based web platform built for the ILC (International Language Center) at Rangsit University. It manages the full mentoring lifecycle: student registration, mentor scheduling, appointment booking, form/consent tracking, attendance, and cross-role profile visibility.

The platform supports four authenticated user roles — **Student**, **Mentor**, **Team Leader**, and **Admin** — each with a dedicated dashboard and workflow, plus a public guest landing page.

---

## Tech Stack

| Layer       | Technology                                        |
| ----------- | ------------------------------------------------- |
| Framework   | Laravel 11.9                                      |
| Language    | PHP 8.2+                                          |
| Frontend    | Blade Templates + Tailwind CSS 3.4 + Flowbite 2.5 |
| Build Tool  | Vite 5                                            |
| Database    | SQLite                                            |
| Auth        | Laravel session-based authentication              |
| HTTP Client | Axios (AJAX availability checks)                  |
| Testing     | PHPUnit                                           |

---

## Getting Started

This section covers everything a new developer needs to get RSUGlobal running locally from scratch. Read it fully before starting — the database setup in particular has a few steps that are easy to miss.

### Prerequisites

Make sure you have all of the following installed before cloning:

| Tool     | Version            | Notes                                  |
| -------- | ------------------ | -------------------------------------- |
| PHP      | 8.2+               | Check with `php -v`                    |
| Composer | Latest             | Check with `composer -V`               |
| Node.js  | 18+ recommended    | Check with `node -v`                   |
| npm      | Bundled with Node  | Check with `npm -v`                    |
| XAMPP    | Any recent version | Provides Apache + PHP on macOS/Windows |
| Git      | Any                | For cloning and branching              |

> **macOS tip:** If PHP is missing or outdated, install it via Homebrew: `brew install php`

---

### 1. Clone the Repository

```bash
git clone https://github.com/soungoolwin/ILC-Web.git
cd ILC-Web
```

The **active development branch** is `dashboard_with_larapex`. Switch to it after cloning:

```bash
git checkout "DESIRED_BRANCH"
```

> Do **not** commit directly to `master` or pull from it. Always branch off a secondary or create a feature branch from it.

---

### 2. Install PHP Dependencies

```bash
composer install
```

This installs Laravel and all backend packages defined in `composer.json`. It will create the `vendor/` directory (do not commit this).

---

### 3. Install Node Dependencies

```bash
npm install
```

This installs Tailwind CSS, Vite, Flowbite, Axios, and Prettier. Creates `node_modules/` (do not commit this).

---

### 4. Create the Environment File

There is no `.env.example` in this repo. Create your `.env` file manually in the project root:

```bash
touch .env
```

Then paste the following into it and adjust as needed:

```env
APP_NAME="RSUGlobal"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database

QUEUE_CONNECTION=database

VITE_APP_NAME="${APP_NAME}"
```

> **`DB_CONNECTION=sqlite`** is all you need — Laravel automatically uses `database/database.sqlite`. You do not need to set `DB_HOST`, `DB_DATABASE`, etc. for local SQLite development.

---

### 5. Generate the Application Key

```bash
php artisan key:generate
```

This fills in `APP_KEY` in your `.env`. The app will not boot without it.

---

### 6. Set Up the SQLite Database

The project uses **SQLite** — no MySQL or database server required. You just need to create the database file:

```bash
touch database/database.sqlite
```

Then run all migrations to create the tables:

```bash
php artisan migrate
```

You should see output like:

```
INFO  Running migrations.
  2024_09_28_085700_create_students_table ............... DONE
  2024_09_28_090425_create_mentors_table ................ DONE
  ...
```

If you ever need to reset and start fresh:

```bash
php artisan migrate:fresh
```

> **Warning:** `migrate:fresh` drops all tables and re-runs everything. Do not run this if you have data you want to keep.

---

### 7. Seed the Database (Optional but Recommended)

The seeder creates a default admin account and populates the database with test students, mentors, timetables, and appointments so you can immediately log in and explore the app.

```bash
php artisan db:seed
```

After seeding, you can log in as admin at `/login`:

| Field    | Value               |
| -------- | ------------------- |
| Email    | `admin@example.com` |
| Password | `adminpassword`     |

The seeder also creates **100 students** and **15 mentors** with linked timetables and appointments for testing.

---

### 8. Build Frontend Assets

**For development** (hot reload — run this in a separate terminal while developing):

```bash
npm run dev
```

**For production** (compile and fingerprint assets):

```bash
npm run build
```

> You must have Vite running (`npm run dev`) or have built assets (`npm run build`) — otherwise the page will load with no styles.

---

### 9. Serve the Application

**Option A — XAMPP (recommended for this project):**

1. Place the project inside XAMPP's `htdocs` directory: `xampp/htdocs/ILC-Web/`
2. Start Apache in the XAMPP control panel
3. Visit: `http://localhost/ILC-Web/public`

**Option B — Laravel dev server:**

```bash
php artisan serve
```

Then visit: `http://127.0.0.1:8000`

> If using `php artisan serve`, run `npm run dev` in a second terminal at the same time for Vite hot reload.

---

### Full Setup Checklist

```
[ ] git clone + git checkout dashboard_with_larapex
[ ] composer install
[ ] npm install
[ ] Create .env file with contents above
[ ] php artisan key:generate
[ ] touch database/database.sqlite
[ ] php artisan migrate
[ ] php artisan db:seed         (optional)
[ ] npm run dev                 (keep running in a separate terminal)
[ ] Start Apache via XAMPP, visit http://localhost/ILC-Web/public
```

---

### Common Issues & Fixes

**"Class not found" or autoload errors**

```bash
composer dump-autoload
```

**Blank page / no styles**
Make sure Vite is running (`npm run dev`) or you have run `npm run build`. Check `public/build/` exists.

**`php artisan` commands fail immediately**
Check that `APP_KEY` is set in `.env` — run `php artisan key:generate` if it's empty.

**SQLite errors ("unable to open database file")**
Make sure `database/database.sqlite` exists: `touch database/database.sqlite`

**Migrations fail with "table already exists"**
Run `php artisan migrate:fresh` to reset, or check if you have a leftover `.sqlite` file from a previous setup.

**Session or cache errors on first boot**

```bash
php artisan storage:link
php artisan cache:clear
php artisan config:clear
```

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php               # Admin profile, user mgmt, timetable views
│   │   ├── AdminFormController.php           # Form CRUD + tracking
│   │   ├── AdminFileUploadLinkController.php # File upload link CRUD
│   │   ├── AttendanceController.php          # Attendance index + preview
│   │   ├── AppointmentController.php         # Student appointment booking
│   │   ├── GuestPageController.php           # Public stats landing page
│   │   ├── LoginController.php               # Auth login/logout
│   │   ├── SignupController.php              # Registration for all 4 roles
│   │   ├── MentorController.php              # Mentor profile, status, student view
│   │   ├── MentorFormController.php
│   │   ├── StudentController.php             # Student dashboard, profile, links
│   │   ├── StudentFormController.php
│   │   ├── TeamLeaderController.php          # Team leader dashboard, profile, timetables
│   │   ├── TeamLeaderFormController.php
│   │   ├── TeamLeaderTimetableController.php
│   │   ├── TimetableController.php           # Mentor timetable create/edit/availability
│   │   └── UserController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       ├── MentorMiddleware.php
│       ├── StudentMiddleware.php
│       ├── TeamLeaderMiddleware.php
│       └── RedirectIfAuthenticated.php
│
├── Models/
│   ├── User.php, Admin.php, Student.php, Mentor.php, TeamLeader.php
│   ├── Appointment.php, Timetable.php, TeamLeaderTimetable.php
│   ├── Form.php, StudentForm.php, MentorForm.php, TeamLeaderForm.php
│   └── FileUploadLink.php
│
database/
├── migrations/          # 19 migration files (2024–2025)
├── factories/
└── seeders/

resources/
├── views/
│   ├── guest.blade.php
│   ├── auth/            # Login + 4 registration forms
│   ├── student/         # dashboard, profile, links, appointments, mentor-profile
│   ├── mentor/          # dashboard, profile, links, timetables, student-profile
│   ├── team_leader/     # dashboard, profile, links, timetables, student/mentor profiles
│   ├── admin/           # dashboard, forms, file links, attendance, users
│   └── components/      # Reusable layout, newsletter
├── css/app.css
└── js/app.js

routes/
└── web.php

public/
└── images/              # Logo, banners, uploads
```

---

## Roles & Workflows

### Guest

The public landing page (`/`) displays live platform statistics:

- Total registered users
- Number of mentors, team leaders, and students
- Newsletter signup component

No authentication required.

---

### Student

**Registration** → `GET /register/student`

**After login, the student can:**

1. **View Dashboard** — overview of their session status
2. **Manage Profile** — update name, nickname, LINE ID, phone number, password
3. **Browse Forms (Links)** — view active consent forms assigned to students; mark complete or undo
4. **Book Appointments** — select an available mentor and time slot
5. **Edit Appointments** — modify an existing booking
6. **View Mentor Profile** — browse a mentor's public profile from `/student/mentors/{id}`

**Availability Check** — AJAX endpoint used during appointment booking to show open time slots before submission.

---

### Mentor

**Registration** → `GET /register/mentor`

**After login, the mentor can:**

1. **View Dashboard** — overview of upcoming students and schedule
2. **Manage Profile** — update details and upload a profile image
3. **Browse Forms (Links)** — view and complete mentor-specific consent forms; undo submissions
4. **Create Timetable** — reserve available time slots for student appointments (`/mentor/timetables/reserve`)
5. **Edit Timetable** — modify existing availability slots
6. **Check Availability** — AJAX endpoint used to display real-time slot availability
7. **Search Students** — look up students linked to their timetable slots
8. **Next Semester Confirmation** — confirm continuation for the next semester (`/mentor/nextsem/{mentor}`)
9. **View Student Profile** — access a student's profile from `/mentor/students/{id}`

**Account States**: Active → Paused (`/mentor/pause`) → Suspended (`/mentor/suspended`)

---

### Team Leader

**Registration** → `GET /register/team-leader`

**After login, the team leader can:**

1. **View Dashboard** — team activity overview
2. **Manage Profile** — update info and upload profile image
3. **Browse Forms (Links)** — complete team-leader-specific forms; undo
4. **View All Timetables** — browse mentor and student scheduling (`/team-leader/view-timetables`)
5. **Reserve Own Timetable** — set availability slots (`/team-leader/timetable`)
6. **Check Availability** — AJAX availability check for their own timetable
7. **View Student Profile** — `/team-leader/students/{id}`
8. **View Mentor Profile** — `/team-leader/mentors/{id}`

---

### Admin

**Registration** → `GET /register/admin`

**After login, the admin can:**

1. **View Dashboard** — platform-wide overview
2. **Manage Profile** — update admin details and password
3. **View All Users** — paginated list of all registered users with delete capability
4. **View Profiles** — access student, mentor, and team leader profiles
5. **View Timetables** — browse team leader timetables and mentor–student timetables
6. **Form Management (CRUD)** — create, edit, activate/deactivate, and delete forms for any role
7. **Form Tracking** — see completion status per user per form
8. **File Upload Links (CRUD)** — create shareable file submission links; share with users
9. **Attendance** — generate and preview attendance records before finalizing

---

## Route Reference

### Public / Auth Routes

| Method | URI                      | Name                   | Description                             |
| ------ | ------------------------ | ---------------------- | --------------------------------------- |
| `GET`  | `/`                      | `guest`                | Landing page with live stats            |
| `GET`  | `/register/student`      | `register.student`     | Student registration form               |
| `POST` | `/register/student`      | —                      | Submit student registration             |
| `GET`  | `/register/mentor`       | `register.mentor`      | Mentor registration form                |
| `POST` | `/register/mentor`       | —                      | Submit mentor registration              |
| `GET`  | `/register/admin`        | `register.admin`       | Admin registration form                 |
| `POST` | `/register/admin`        | —                      | Submit admin registration               |
| `GET`  | `/register/team-leader`  | `register.team_leader` | Team leader registration form           |
| `POST` | `/register/team-leader`  | —                      | Submit team leader registration         |
| `GET`  | `/login`                 | `login`                | Login form                              |
| `POST` | `/login`                 | —                      | Authenticate user (rate-limited: 5/min) |
| `POST` | `/logout`                | `logout`               | Log out current user                    |
| `GET`  | `/components/newsletter` | `newsletter`           | Newsletter signup component             |

---

### Student Routes

> All protected by `StudentMiddleware` + `auth`.

| Method   | URI                                        | Name                                | Description                          |
| -------- | ------------------------------------------ | ----------------------------------- | ------------------------------------ |
| `GET`    | `/student/dashboard`                       | `student.dashboard`                 | Student dashboard                    |
| `GET`    | `/student/profile`                         | `student.profile`                   | View student profile                 |
| `PUT`    | `/student/profile`                         | `student.update`                    | Update student profile               |
| `GET`    | `/student/links`                           | `student.links`                     | View active consent forms            |
| `POST`   | `/student/links/{form}/complete`           | `student.forms.complete`            | Mark a form as complete              |
| `DELETE` | `/student/links/{form}/undo`               | `student.forms.undo`                | Undo a form completion               |
| `GET`    | `/student/mentors/{id}`                    | `student.mentors.show`              | View a mentor's profile              |
| `GET`    | `/student/appointments/create`             | `student.appointments.create`       | Appointment booking form             |
| `POST`   | `/student/appointments/store`              | `student.appointments.store`        | Book an appointment                  |
| `GET`    | `/student/appointments/{appointment}/edit` | `student.appointments.edit`         | Edit appointment form                |
| `PUT`    | `/student/appointments/{appointment}`      | `student.appointments.update`       | Update an appointment                |
| `GET`    | `/student/appointments/availability`       | `student.appointments.availability` | AJAX: check mentor slot availability |

---

### Mentor Routes

> All protected by `MentorMiddleware` + `auth`.

| Method   | URI                             | Name                         | Description                     |
| -------- | ------------------------------- | ---------------------------- | ------------------------------- |
| `GET`    | `/mentor/dashboard`             | `mentor.dashboard`           | Mentor dashboard                |
| `GET`    | `/mentor/profile`               | `mentor.profile`             | View mentor profile             |
| `PUT`    | `/mentor/profile`               | `mentor.update`              | Update mentor profile           |
| `POST`   | `/mentor/image/upload`          | `mentor.image.upload`        | Upload profile image            |
| `GET`    | `/mentor/links`                 | `mentor.links`               | View consent forms              |
| `POST`   | `/mentor/links/{form}/complete` | `mentor.forms.complete`      | Mark form complete              |
| `DELETE` | `/mentor/links/{form}/undo`     | `mentor.forms.undo`          | Undo form completion            |
| `GET`    | `/mentor/timetables/reserve`    | `mentor.timetables.create`   | Timetable creation form         |
| `POST`   | `/mentor/timetables/reserve`    | `mentor.timetables.store`    | Save timetable slots            |
| `GET`    | `/mentor/timetables/edit`       | `mentor.timetables.edit`     | Edit timetable form             |
| `PUT`    | `/mentor/timetables/update`     | `mentor.timetables.update`   | Update timetable slots          |
| `GET`    | `/timetables/availability`      | `timetables.availability`    | AJAX: check slot availability   |
| `GET`    | `/mentor/timetables/students`   | `mentor.timetables.students` | AJAX: search students in slots  |
| `GET`    | `/mentor/nextsem/{mentor}`      | `mentor.nextsem`             | Next semester confirmation page |
| `POST`   | `/mentor/confirm-next-semester` | `mentor.confirmNextSemester` | Confirm next semester           |
| `GET`    | `/mentor/pause`                 | `mentor.pause`               | Paused account notice           |
| `GET`    | `/mentor/suspended`             | `mentor.suspended`           | Suspended account notice        |
| `GET`    | `/mentor/students/{id}`         | `mentor.students.show`       | View student profile            |

---

### Team Leader Routes

> All protected by `TeamLeaderMiddleware` + `auth`.

| Method   | URI                                   | Name                                 | Description              |
| -------- | ------------------------------------- | ------------------------------------ | ------------------------ |
| `GET`    | `/team-leader/dashboard`              | `team_leader.dashboard`              | Team leader dashboard    |
| `GET`    | `/team-leader/profile`                | `team_leader.profile`                | View profile             |
| `PUT`    | `/team-leader/profile`                | `team_leader.update`                 | Update profile           |
| `POST`   | `/team-leader/image/upload`           | `team_leader.image.upload`           | Upload profile image     |
| `GET`    | `/team-leader/links`                  | `team_leader.links`                  | View consent forms       |
| `POST`   | `/team-leader/links/{form}`           | `team_leader.forms.complete`         | Mark form complete       |
| `DELETE` | `/team-leader/links/{form}/undo`      | `team_leader.forms.undo`             | Undo form completion     |
| `GET`    | `/team-leader/view-timetables`        | `team_leader.view_timetables`        | Browse all timetables    |
| `GET`    | `/team-leader/timetable`              | `team_leader.timetable.create`       | Reserve timetable form   |
| `POST`   | `/team-leader/timetable`              | `team_leader.timetable.store`        | Save timetable           |
| `GET`    | `/team-leader/timetable/availability` | `team_leader.timetable.availability` | AJAX: check availability |
| `GET`    | `/team-leader/students/{id}`          | `team_leader.students.show`          | View student profile     |
| `GET`    | `/team-leader/mentors/{id}`           | `team_leader.mentors.show`           | View mentor profile      |

---

### Admin Routes

> All protected by `AdminMiddleware` + `auth`.

| Method   | URI                                    | Name                              | Description                          |
| -------- | -------------------------------------- | --------------------------------- | ------------------------------------ |
| `GET`    | `/admin/dashboard`                     | `admin.dashboard`                 | Admin dashboard                      |
| `GET`    | `/admin/profile`                       | `admin.profile`                   | View admin profile                   |
| `PUT`    | `/admin/profile`                       | `admin.update`                    | Update admin profile                 |
| `GET`    | `/admin/users/index`                   | `admin.users.index`               | List all users                       |
| `DELETE` | `/admin/users/{id}`                    | `admin.users.delete`              | Delete a user                        |
| `GET`    | `/admin/mentors/{id}`                  | `admin.mentors.show`              | View mentor profile                  |
| `GET`    | `/admin/students/{id}`                 | `admin.students.show`             | View student profile                 |
| `GET`    | `/admin/team-leaders/{id}`             | `admin.team_leaders.show`         | View team leader profile             |
| `GET`    | `/admin/team-leaders-timetables`       | `admin.team_leaders_timetable`    | View team leader timetables          |
| `GET`    | `/admin/mentor-students-timetable`     | `admin.mentor_students_timetable` | View mentor–student timetables       |
| `GET`    | `/admin/forms`                         | `admin.forms.index`               | List all forms                       |
| `GET`    | `/admin/forms/create`                  | `admin.forms.create`              | Form creation page                   |
| `POST`   | `/admin/forms`                         | `admin.forms.store`               | Create a new form                    |
| `GET`    | `/admin/forms/{form}`                  | `admin.forms.show`                | View form details                    |
| `GET`    | `/admin/forms/{form}/edit`             | `admin.forms.edit`                | Edit form page                       |
| `PUT`    | `/admin/forms/{form}`                  | `admin.forms.update`              | Update a form                        |
| `DELETE` | `/admin/forms/{form}`                  | `admin.forms.destroy`             | Delete a form                        |
| `GET`    | `/admin/form-tracking`                 | `admin.forms.tracking`            | View form completion tracking        |
| `GET`    | `/admin/file_upload_links/create`      | `admin.file_upload_links.create`  | File upload link creation page       |
| `POST`   | `/admin/file_upload_links`             | `admin.file_upload_links.store`   | Create a file upload link            |
| `GET`    | `/admin/file_upload_links/{link}`      | `admin.file_upload_links.show`    | View a file upload link              |
| `GET`    | `/admin/file_upload_links/{link}/edit` | `admin.file_upload_links.edit`    | Edit a file upload link              |
| `PUT`    | `/admin/file_upload_links/{link}`      | `admin.file_upload_links.update`  | Update a file upload link            |
| `DELETE` | `/admin/file_upload_links/{link}`      | `admin.file_upload_links.destroy` | Delete a file upload link            |
| `GET`    | `/admin/attendance`                    | `admin.attendance.index`          | Attendance management                |
| `POST`   | `/admin/attendance/preview`            | `admin.attendance.preview`        | Preview attendance before finalizing |

---

## Database Schema

### Core Tables

| Table          | Key Columns                                                              | Purpose                                         |
| -------------- | ------------------------------------------------------------------------ | ----------------------------------------------- |
| `users`        | `id`, `name`, `nickname`, `email`, `line_id`, `phone_number`, `password` | Base authentication for all roles               |
| `students`     | `id`, `user_id`, `student_id`                                            | Student profile linked to user                  |
| `mentors`      | `id`, `user_id`, `mentor_id`, `image`, `sem_status`, `last_checked_at`   | Mentor profile with image and semester tracking |
| `admins`       | `id`, `user_id`, `admin_id`                                              | Admin profile                                   |
| `team_leaders` | `id`, `user_id`, `team_leader_id`, `image`                               | Team leader profile                             |

### Scheduling Tables

| Table                    | Key Columns                                                         | Purpose                                                |
| ------------------------ | ------------------------------------------------------------------- | ------------------------------------------------------ |
| `timetables`             | `id`, `mentor_id`, `day`, `time_slot`, `student_ids`                | Mentor availability slots (supports up to 30 students) |
| `team_leader_timetables` | `id`, `team_leader_id`, `day`, `time_slot`                          | Team leader availability slots                         |
| `appointments`           | `id`, `student_id`, `mentor_id`, `timetable_id`, `day`, `time_slot` | Student–mentor bookings                                |

### Forms & Consent Tables

| Table              | Key Columns                                                               | Purpose                             |
| ------------------ | ------------------------------------------------------------------------- | ----------------------------------- |
| `forms`            | `id`, `title`, `description`, `form_type`, `for_role`, `is_active`, `url` | Dynamic form definitions            |
| `student_forms`    | `id`, `student_id`, `form_id`, `completed_at`                             | Student form completion records     |
| `mentor_forms`     | `id`, `mentor_id`, `form_id`, `completed_at`                              | Mentor form completion records      |
| `teamleader_forms` | `id`, `team_leader_id`, `form_id`, `completed_at`                         | Team leader form completion records |

### File Management

| Table               | Key Columns                                       | Purpose                         |
| ------------------- | ------------------------------------------------- | ------------------------------- |
| `file_upload_links` | `id`, `title`, `url`, `description`, `expires_at` | Shareable file submission links |

### Infrastructure

| Table                   | Purpose                 |
| ----------------------- | ----------------------- |
| `sessions`              | Laravel session storage |
| `cache`, `cache_locks`  | Application cache       |
| `jobs`, `job_batches`   | Queue management        |
| `password_reset_tokens` | Password reset flow     |

---

## Key Features

### Multi-Role Authentication

Four distinct roles each with dedicated registration, login redirect, and middleware-protected routes. The `RedirectIfAuthenticated` middleware prevents logged-in users from accessing auth pages.

### Mentor Scheduling System

Mentors create time slot availability via timetables. Students use an AJAX availability check before booking appointments. The timetable supports up to 30 concurrent student slots per mentor shift.

### Form & Consent Tracking

Admins create forms targeting specific roles (`for_role`). Each role sees only their relevant active forms and can mark them complete or undo. Admins get a tracking view showing completion status across all users.

### Cross-Role Profile Visibility

- Students can view mentor profiles
- Mentors can view student profiles
- Team leaders can view both student and mentor profiles
- Admins can view all profiles

### Profile Image Uploads

Mentors and team leaders can upload profile images via dedicated upload endpoints.

### Semester Status Management

Mentors have a semester status workflow: they receive confirmation prompts (`/mentor/nextsem/{mentor}`) and can be paused or suspended by the system.

### File Upload Link Sharing

Admins can create shareable upload links with expiry dates, allowing targeted file collection from users.

### Attendance Management

Admins can generate attendance previews and finalize attendance records.

### Rate Limiting

Login is rate-limited to 5 attempts per minute to prevent brute-force attacks.

---

## Development

### Running Tests

```bash
php artisan test
```

### Compiling Assets

```bash
# Development with hot reload
npm run dev

# Production build
npm run build
```

### Code Style

The project uses Prettier for JavaScript/Blade formatting.

```bash
npx prettier --write resources/
```

### Adding a New Role

1. Create migration for the role's profile table
2. Create model, controller, and form controller
3. Add middleware class in `app/Http/Middleware/`
4. Register middleware and routes in `routes/web.php`
5. Create Blade views under `resources/views/{role}/`
6. Add registration method to `SignupController`

---

## License

Internal project for Rangsit University ILC. All rights reserved.
