<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Roles and Permissions

## About
This project, created by Hylton Walters, is based on instructions provided by PlusNarrative.

This documentation provides information on how to use the Laravel Roles and Permissions project. The project aims to implement role-based access control (RBAC) in a Laravel application, allowing administrators to manage user roles, permissions, and access control policies.

## Project Instructions

> The purpose of this Laravel project is to be able to create a user admin system, where you can create/edit a user and assign a role to a user. Each role has permissions assigned to it. The system also sends an email when a user logs in with a new IP or device/browser. Please follow the below process to get set up.

1. Create a new Laravel project via Composer and complete the full installation with your database set up.
2. Add the Laravel Breeze Authentication starter kit.
3. Create Migrations, Seeders and Models
    - Update the user migration to have a first_name and last_name and any other columns you find necessary.
    - Create a roles table.
        - The roles should include: Admin, Content Manager, User.
    - Create a permissions table.
        - The permissions should include: View Admin Dashboard, Administer Users.
        - All permissions should be assigned to the Admin role.
        - Only View Admin Dashboard should be assigned to the Content Manager role.
    - Create the pivot tables for the above migrations.
    - Create another pivot table that keeps track of a user's location (integrating with http://ip-api.com/json/<ip> free version - NOTE: not HTTPS), login_at time, and browser user_agent when they log in.
    - Create a user Seeder and populate the database with 100 Users (using a Factory).
        - Make one of them an Admin user.
        - Make another a Content Manager.
4. Add an Admin button to the top header.
5. Add the necessary admin routes to create, view, update, and delete users.
    - The Admin should be able to assign multiple roles to a user.
6. Protect the Routes according to these permissions:
    - Admin -> View Admin Dashboard, Administer Users (CRUD).
    - Content Manager -> View Admin Dashboard (read only).
    - User -> Not able to access the admin backend or see users.
7. When a user logs in, the system should check if their IP and User Agent match what is in the database. If it isn't the first entry or a new user, an email (https://laravel.com/docs/10.x/mail#markdown-mailables or https://laravel.com/docs/8.x/notifications#mail-notifications) needs to be sent out to the user informing there is a login from a new device/browser.
8. When storing/updating a user, use Form Requests to validate and sanitize the request.
9. Use Tailwind CSS to match the design in Figma.
10. Where possible, use components for building out the frontend (anonymous components can be used).

### Bonus Points

It's not required, but add some tests and containerize the application if you really want to impress us.

## Figma Design
<a href="https://imgur.com/hTasFzT" target="_blank"><img src="https://i.imgur.com/hTasFzT.png" alt="Figma Design" width="400"></a>
<a href="https://imgur.com/uOK4uGO" target="_blank"><img src="https://i.imgur.com/uOK4uGO.png" alt="Figma Design" width="400"></a>

## Credits

- **Project Creator**: Hylton Walters
- **Instructions**: PlusNarrative
---
## Features

- **Role-Based Access Control**: Define roles and assign permissions to users based on their roles.
- **User Management**: Manage users, roles, and permissions through an intuitive interface.
- **MySQL Database**: Store application data in a MySQL database.
- **Redis Integration**: Utilize Redis for caching and session management.
- **Full-Text Search**: Incorporate MeiliSearch for efficient full-text search capabilities.
- **Database Management**: Access and manage the database with PHPMyAdmin.
- **Testing**: Run tests using ```php artisan test```.
- **Email Testing**: Test email functionality with MailHog.
- **User Location Logic**: Capture user location information based on IP address and user agent, and send email notifications for new logins from different devices.

## Installation

### Prerequisites

- **Local Installation**:
    - PHP 8.3 installed on your system.
    - Composer for PHP dependency management.
    - NPM and Node.js for front-end asset compilation.
    - Laravel Breeze Authentication starter kit.
    - Tailwind CSS for styling.
### Additionally
- **Docker Installation**:
    - Docker installed on your system.
    - Project pushed to [Docker Hub](https://hub.docker.com/r/871115/laravel-roles-and-permissions) for easy download and convenience.

### Local Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    ```

2. Navigate to the project directory:

    ```bash
    cd laravel-roles-and-permissions
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Install front-end dependencies:

    ```bash
    npm install && npm run dev
    ```

5. Set up the environment configuration:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

6. Update the `.env` file with your database configuration.

7. Run the migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

8. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

9. Access the application in your web browser at `http://localhost:8000`.

### Docker Installation

1. Pull the Docker image from Docker Hub:

    ```bash
    docker pull 871115/laravel-roles-and-permissions
    ```

2. Run the Docker container:

    ```bash
    docker run -d -p 80:80 871115/laravel-roles-and-permissions
    ```

3. Access the application in your web browser at `http://localhost`.

## Usage

### Login Credentials
- **Admin User**:
    - Email: admin@me.com
    - Password: admin


- **Content Manager User**:
    - Email: manager@me.com
    - Password: manager
  

- **Normal User**:
  - Email: user@example.com
  - Password: password


### User Management

The project includes controllers and views for user management:

- **Admin\UserController**: Manages user-related actions for administrators, such as creating, updating, deleting, and showing user details.
- **Manager\UserController**: Manages user-related actions for managers, such as viewing user details.

#### Middleware and UserPolicy

- **Middleware**: Middleware is used to protect routes based on user roles and permissions.
- **UserPolicy**: UserPolicy defines authorization rules for actions such as creating, updating, and deleting users.

### Roles and Permissions

To manage roles and permissions:

- **Create Roles**: Administrators can create roles using the provided interface.
- **Assign Permissions**: Assign permissions to roles to define access control policies.
- **Assign Roles**: Assign roles to users to grant access rights.

### User Location Logic

The project includes logic to capture user location information based on IP address and user agent:

- **Location Capture**: When a user logs in, the system captures the user's IP address and user agent.
- **API Integration**: The system uses an external API to retrieve location information based on the user's IP address.
- **Location Update**: If the user's location changes or if the user agent is different from the previous login, the system updates the user's location and sends an email notification to the user.

### Testing

- **Feature Test**: The `UserRolesAndPermissionsTest.php` feature test ensures authorization and permission checks for various actions.

#### The project includes test cases for:

- Authorization checks for various actions.
- Edge cases and error handling scenarios.
- Permission checks for accessing different parts of the application.

## Configuration

- **Environment Variables**: You can customize the Laravel application configuration by setting environment variables. Refer to the [Laravel documentation](https://laravel.com/docs/configuration) for details on available configuration options.

## License

This project is licensed under the MIT License.
