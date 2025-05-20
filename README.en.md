
# Laravel FakeStore API

[English](./README.en.md) | [Português](./README.pt.md)


This project is a Laravel environment configured with Sail and Vue.js to consume the FakeStore API. 
In addition to the product listing, a complete CRUD system for products has been implemented along with authentication via Laravel Sanctum to protect the routes.

## 📦 Implemented Features

- JWT Authentication via Laravel Sanctum
- CRUD for products (Read, Update, and Delete)
- Product synchronization with the FakeStore API
- Pagination and Category Filtering
- Axios Interceptors configured to include tokens in requests
- Route protection using middleware
- Login Interface with visual feedback (SweetAlert)
- Vue.js componentization for frontend organization
- Navigation system between product listing, product details, addition, and editing

## ✅ Requirements

- Docker and Docker Compose installed
- Node.js and npm installed
- Git installed

## 🚀 Installation and Setup

1. Clone the repository:

```bash
git clone https://github.com/Tiagokochem/laravel-fakestore-api.git
cd laravel-fakestore-api
```

2. Copy the `.env.example` file to `.env` and adjust the settings if necessary:

```bash
cp .env.example .env
```

3. Install PHP and Node.js dependencies:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

4. Generate the application key:

```bash
./vendor/bin/sail artisan key:generate
```

5. Run the database migrations:

```bash
./vendor/bin/sail artisan migrate
```

6. Compile Vue.js assets:

```bash
./vendor/bin/sail npm run dev
```

7. Start the local server:

```bash
./vendor/bin/sail up -d
```

8. Access the application at:

- Laravel: [http://localhost](http://localhost)

## 🔐 Authentication

- The application includes an authentication system using Laravel Sanctum.
- A default user is already created for testing:
  - Login: admin@example.com
  - Password: 123456

- If you want to create another test user, use the following command:

```bash
./vendor/bin/sail artisan tinker
```

In Tinker, run:

```php
$user = new App\Models\User();
$user->name = "Admin";
$user->email = "admin@example.com";
$user->password = bcrypt('123456');
$user->save();
```

- Access the system at `/login` using:
  - Email: `admin@example.com`
  - Password: `123456`

## 🛠️ Useful Commands

- Stop containers:

```bash
./vendor/bin/sail down
```

- Restart containers:

```bash
./vendor/bin/sail up -d
```

- Access the Laravel container:

```bash
./vendor/bin/sail shell
```

- Run Artisan commands:

```bash
./vendor/bin/sail artisan migrate
```

## 🔥 Next Steps and Improvements

- Implement a logout system to clear the stored token
- Implement product registration
- Improve product interface using Tailwind CSS
- Add a permission system for access control
- Create a dashboard with charts using Chart.js or ApexCharts
- Implement unit and integration tests

---

**Note:** Make sure that port `3306` is not in use, as MySQL uses this port.
