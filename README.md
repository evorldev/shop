# Installation

 - make .env (!!! Important !!!)

 - composer install
 - npm install
 - npm run build

 - php artisan storage:link
 - php artisan key:generate

 - php artisan migrate

# Deploy 

 - make .env (!!! Important !!!)

 - composer install --optimize-autoloader --no-dev

 - php artisan storage:link
 - php artisan key:generate

 - php artisan migrate

 - php artisan config:cache
 - php artisan route:cache
 - php artisan view:cache
