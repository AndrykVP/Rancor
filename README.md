# Rancor
![repo size](https://img.shields.io/github/repo-size/AndrykVP/Rancor) ![license](https://img.shields.io/github/license/AndrykVP/Rancor) ![activity](https://img.shields.io/github/last-commit/AndrykVP/Rancor) ![downloads](https://img.shields.io/packagist/dt/andrykvp/rancor)

Rancor is a [Laravel](http://www.laravel.com) package built for quickly scaffolding a project related to the MMORPG [Star Wars Combine](http://www.swcombine.com), and make use of common functionality required by factions and/or groups of this game. Such as:

- Generating server-side avatars and signatures using a given template
- Recording scan logs and browsing them in an expressive GUI
- Consume web services provided by the game
- Kickstarting a dashboard/admin panel

## Getting Started
### Prerequisites

What things you need to install this package

- PHP 7.4
- Laravel 7

### Dependencies

The following packages will be installed by Composer if they have not yet been installed:

- [HTMLPurifier](https://github.com/mewebstudio/Purifier)
- [Doctrine DBAL](https://github.com/doctrine/dbal)

### Installing

Installation is done through the [Composer](https://getcomposer.org/) dependency manager with the following command:

```bash
composer require andrykvp/rancor
```

Because of the development in Laravel 7, the package is auto-discovered and you do not need to register the Service Provider.

Backwards compatibility to previous versions of Laravel has not been tested and it is not recommended to use with previous versions of Laravel 6. However, if you wish to test it yourself, you may add the following lines of code at the end of your `config/app.php` file:

```php
AndrykVP\Rancor\Providers\FrameworkServiceProvider::class,
Mews\Purifier\PurifierServiceProvider::class,
```

## Authors

* **Andrés Velázquez** - *Initial work* - [AndrykVP](https://github.com/AndrykVP)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
