# SWC API

SWC API is a [Laravel](http://www.laravel.com) package built to quickly implement a way to consume web services provided by the MMORPG [Star Wars Combine](http://www.swcombine.com), as well as regular features used by factions in the game such as:

- Generating server-side avatars and signatures using a given template
- Recording scan logs and accessing them by coordinates

## Getting Started
### Prerequisites

What things you need to install the software and how to install them

```
Laravel 7 or above
```

### Installing

The package is installed through composer with the following command:

```bash
composer require "andrykvp/swc"
```

Then register the service provider to your `'providers'` array in `config/app.php`

```php
AndrykVP\SWC\Providers\SWCServiceProvider::class,
```

## Authors

* **Andrés Velázquez** - *Initial work* - [AndrykVP](https://github.com/AndrykVP)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

[![forthebadge](https://forthebadge.com/images/badges/built-with-love.svg)](https://forthebadge.com)