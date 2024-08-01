<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## How to install broadcast in laravel 11

1 - php artisan install:broadcasting, click yes to install reverb and node dependencies
2 - npm install --save-dev laravel-echo pusher-js
3 - Go inside resources/js/bootstrap.js and make sure echo.js is imported
4 - edit config/reverb.php and .env
5 - run in terminal (php artisan reverb:start, npm run dev) to test

## Make a broadcast channel

1 - To create a broadcast channel, run the command php artisan make:event "Even name"
2 - Implement ShouldBroadcast to the class
3 - Change channel name and navigate to channel.php. add authentication, only people with the authenticated will be able to access the channel

## Install Vue

1 - composer require laravel/ui
2 - php artisan ui vue
3 - add id="app" to div to add vue components
4 - add new components to resources/js/app.js
5 - in the layout, add @vite(['resources/js/app.js']) in the header
