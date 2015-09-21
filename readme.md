# Cottaging

### An Accommodation Booking System

Here's an unfinished project of mine, built in late 2013. It was originally meant to power a holiday cottage website. 

It's based on the Laravel4 framework. It's coded using guidance mainly from Chris Fideao's excellent book, [Implementing Laravel](https://leanpub.com/implementinglaravel). 

The main dependency is Sentry for User management. Looking back it would have been easier to use Laravel's built in Auth. 

The majority of the site works. The front end is all there and a rudimentary admin system exists in the back end to see who's booked what and when. It also includes a system to add and update cottage

I'm particularly pleased with the jQuery driven availability calendar. 

## Installation and setup

`composer install` should do the trick. 

The `app/config` files should be filled in first. It has a `cottaging.php` file with details such as site name, admin & contact emails etc. 

I've included the migrations and database seeders. Should be run in this order: 

`artisan migrate --package=artalyst/sentry`
`artisan migrate --seed`

Seeds for prices and bookings are set to 2015/2016. You may want to edit these. 

## Coding Style

I'd do this different now. But this was back then. 

Looking back on the code I realise it's not great, but it did what it was meant to and would have served an excellent base on which to build. 

I use Laravel5.1 and so some of the ideas are outdated. 

There's no front end dependency management either. So here's a list. Versions are what were used at the time. 

#### JavaScript

* Bootstrap 3.0.3
* Bootstrap Datepicker https://github.com/eternicode/bootstrap-datepicker/
* Dropzone.js
* jQuery 1.10.2
* jQuery CC Validator
* jQuery Easing
* jQuery Sequence 0.8.3 http://www.sequencejs.com
* Galleria 1.3.3

#### CSS

These are all bundled with the above libs. 

* Bootstrap
* Datepicker
* Dropzone
* Sequence

#### Fonts

* FontAwesome
* Glyphicons

Feel free to fork, extend and improve. Please let me know if you do. 

### Licence

Released under the [MIT License](https://opensource.org/licenses/MIT). 

[@meilyrg](http://twitter.com/meilyrg)