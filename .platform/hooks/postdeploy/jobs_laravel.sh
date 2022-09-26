#!/bin/bash

# Optimizing configuration loading, route loading and view loading
# https://laravel.com/docs/8.x/deployment#optimization

php artisan schedule:work
php artisan queue:work
