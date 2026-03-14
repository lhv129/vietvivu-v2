step 1: run migration
step 2: run php artisan db:seed --class=RoleSeeder
step 3: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
step 4: php artisan jwt:secret