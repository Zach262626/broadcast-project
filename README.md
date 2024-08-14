<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## How to install Project

* Clone Project
* copy env.example add a empty local database
* run npm install and composer install
* php artisan migrate:fresh and php artisan db:seed
* run php artisan reverb:start, php artisan queue:work, npm run dev


## How to install broadcast in laravel 11

* php artisan install:broadcasting, click yes to install reverb and node dependencies
* npm install --save-dev laravel-echo pusher-js
* Go inside resources/js/bootstrap.js and make sure echo.js is imported
* edit config/reverb.php and .env
* run in terminal (php artisan reverb:start,php artisan queue:work,artisan queue:work --queue=broadcast,  npm run dev) to test

## Make a broadcast channel

* To create a broadcast channel, run the command php artisan make:event "Even name"
* Implement ShouldBroadcast to the class
* Change channel name and navigate to channel.php. add authentication, only people with the authenticated will be able to access the channel

## Install Vue

* composer require laravel/ui
* php artisan ui vue
* add id="app" to div to add vue components
* add new components to resources/js/app.js
* in the layout, add @vite(['resources/js/app.js']) in the header
