# Task Management Application

A full-featured task management web application built with Laravel 11 and Tailwind CSS, featuring drag-and-drop task reordering, project organization, and user authentication.

## Features

- **User Authentication** - Secure login and registration using Laravel Breeze
- **Task Management** - Create, edit, and delete tasks
- **Drag & Drop Reordering** - Intuitive task prioritization with automatic priority updates
- **Project Organization** - Group tasks by projects and filter views
- **Priority System** - Automatic priority assignment (#1 at top, #2 next, etc.)
- **Responsive Design** - Works seamlessly on desktop and mobile devices

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ and NPM
- MySQL, PostgreSQL, or SQLite database
- Web server (Apache/Nginx) or Laravel's built-in server

## Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/ketanbrathod9999/task_managegment
cd task-management
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure your database:

```bash
cp .env.example .env
```

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

For SQLite (simpler setup):
```env
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD can be commented out
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

This will create the necessary tables:
- users
- projects
- tasks
- password_reset_tokens
- sessions

### 7. Build Frontend Assets

For development (with hot reload):
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 8. Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Usage

1. **Register/Login** - Create an account or login at `/register` or `/login`
2. **Navigate to Tasks** - Click "Tasks" in the navigation menu
3. **Create Projects** (Optional) - Add projects to organize your tasks
4. **Add Tasks** - Enter task name and optionally assign to a project
5. **Reorder Tasks** - Drag and drop tasks to change their priority
6. **Filter by Project** - Use the dropdown to view tasks for specific projects
7. **Edit/Delete** - Use the action buttons on each task

## Deployment

### Production Deployment Steps

#### 1. Server Requirements

Ensure your server meets the requirements listed above.

#### 2. Upload Files

Upload all project files to your server (via FTP, Git, or deployment tool).

#### 3. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

#### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Configure your production `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 5. Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 6. Run Migrations

```bash
php artisan migrate --force
```

#### 7. Optimize for Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 8. Configure Web Server

**Apache (.htaccess)**

Ensure `mod_rewrite` is enabled. The `.htaccess` file in the `public` directory should handle routing.

Point your document root to the `public` directory.

**Nginx**

Add this to your Nginx configuration:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/task-management/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 9. Set Up SSL (Recommended)

Use Let's Encrypt for free SSL certificates:

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

#### 10. Set Up Queue Worker (Optional)

If using queues, set up a supervisor configuration:

```bash
sudo apt install supervisor
```

Create `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/task-management/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/task-management/storage/logs/worker.log
```

Start the worker:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### Deployment Platforms

#### Laravel Forge

1. Connect your server to Forge
2. Create a new site pointing to your repository
3. Configure environment variables
4. Deploy via Git push

#### Laravel Vapor (Serverless)

1. Install Vapor CLI: `composer require laravel/vapor-cli`
2. Configure `vapor.yml`
3. Deploy: `vapor deploy production`

#### Shared Hosting (cPanel)

1. Upload files via FTP
2. Move contents of `public` to `public_html`
3. Update `index.php` paths to point to correct directories
4. Configure database via cPanel
5. Run migrations via SSH or cPanel terminal

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

Format code using Laravel Pint:

```bash
./vendor/bin/pint
```

### Database Seeding (Optional)

Create seeders for test data:

```bash
php artisan db:seed
```

## API Endpoints

All endpoints require authentication:

- `GET /api/tasks` - List tasks (with optional project filter)
- `POST /api/tasks` - Create new task
- `PUT /api/tasks/{id}` - Update task
- `DELETE /api/tasks/{id}` - Delete task
- `POST /api/tasks/reorder` - Reorder tasks (drag & drop)
- `GET /api/projects` - List projects
- `POST /api/projects` - Create project
- `PUT /api/projects/{id}` - Update project
- `DELETE /api/projects/{id}` - Delete project

## Troubleshooting

### Styles Not Showing

Run `npm run dev` to compile assets with hot reload, or `npm run build` for production.

### Database Connection Error

Check your `.env` database credentials and ensure the database exists.

### Permission Errors

Ensure `storage` and `bootstrap/cache` directories are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

### 500 Error in Production

Check `storage/logs/laravel.log` for detailed error messages.

## Security

- All routes are protected by authentication middleware
- CSRF protection enabled on all forms
- Authorization policies ensure users can only access their own data
- Passwords are hashed using bcrypt
- SQL injection protection via Eloquent ORM

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues and questions, please open an issue in the repository.
