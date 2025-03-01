# EventX - Laravel Event Management App

## Introduction
EventX is a Laravel-based event management application that allows users to create, manage, and track events seamlessly. It includes features like event scheduling, attendee registration, and automated reminders.

## Features
- User authentication (Login/Register)
- Create and manage events
- RSVP & attendee management
- Payment integration for ticketing (if applicable)
- Notifications & reminders
- Dashboard with event analytics

## Prerequisites
Before running the application, ensure you have the following installed:
- PHP (>= 8.0)
- Composer
- MySQL / PostgreSQL (or any other database supported by Laravel)
- Laravel 10+ (installed via Composer)
- Node.js & npm (for frontend assets)

## Installation

### 1. Clone the Repository
```sh
 git clone https://github.com/Vijaysivadas/eventx.git
 cd eventx
```

### 2. Install Dependencies
```sh
composer install
npm install
```

### 3. Serve the Application
```sh
php artisan serve
```

For database connection, make sure to update the `.env` file.
Your Laravel application will now be running at `http://127.0.0.1:8000/`.


## Deployment Instructions
For deploying to production:
1. Configure `.env` for production.
2. Run database migrations: `php artisan migrate --force`.
3. Optimize Laravel: `php artisan optimize`.
4. Set up a web server (Apache/Nginx) with appropriate configurations.
5. Use Supervisor to run queues and schedule tasks.

## Contributing
Feel free to submit issues or pull requests. Ensure your code follows Laravel best practices.

## License
This project is licensed under the Appache.

## Contact
For support or inquiries, reach out to **[email.vijaysivadas@gmail.com]**.

