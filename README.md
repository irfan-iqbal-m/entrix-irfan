# Install dependencies
composer install

# Install Node.js dependencies
npm install


# Migrate database 
php artisan migrate
php artisan db:seed

# Run the project
php artisan serve
npm run dev 


# Login
Admin
username: admin@admin.com
password: 12345678

User
username:leuschke.arielle@example.com
password: 12345678