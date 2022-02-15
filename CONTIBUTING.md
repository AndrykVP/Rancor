# How to Contribute
First of all, thank you kindly for your interest in further developing this package. This is being developed as a non-profit hobby, with hopes that it has an impact in the Star Wars Combine community, and any volunteer developers are welcome to join.

You can join the author's [Discord Server](https://discord.gg/5MP9ZwReSu) for help and suggestions.

## Prerequisites
You will need a fresh installation of Laravel 8 [(see the docs)](https://laravel.com/docs/8.x/installation). 

## Installation
Unlike the production installation of the package, this repository must be cloned to your local environment. There are 2 options for developing and testing the package.

### Nested Package
Create a folder named `packages\andrykvp` in the root of your Laravel instance. You will place your cloned repository inside this folder.

Register Rancor's Service Provider in Laravel's `config/app.php`. This can be added Above the `Applications Service Providers` section:

```php
/*
* Package Service Providers...
*/
Rancor\Providers\PackageServiceProvider::class,
Mews\Purifier\PurifierServiceProvider::class,
```

Rancor will now have access to Laravel's classes. However, any update to any of Rancor's Service Providers might require you to run the following command to take effect:

```bash
composer dump-autoload
```

### Isolated Package (recommended)
Place your cloned repository in a separate folder from your Laravel instance, for example `~/Development/Packages`.

You will need to add the following line to the `composer.json` file of your Laravel instance:

```json
"repositories": [
	{
		"type": "path",
		"url": "~/Path/to/package/dir"
	}
]
```

You can now install the package using composer. You will notice in the `vendor` folder, that the `andrykvp/rancor` directory is a symbolic link to your cloned repository. This means any change done to your local copy of the package, will be in effect on your Laravel instance.

In order to write and run tests, you will need access to Laravel classes that are not available in isolated packages, namely the `App\Models\User` model and its factory.

Set up the following folder structure at the root of Rancor:

```bash
- app/
-- Http/
--- Controllers/
---- Controller.php
-- Models/
--- User.php
--- UserFactory.php
```

Where `User.php` and `Controller.php` should be direct copies of Laravel's classes. The User class should also register our custom UserFactory:

```php   
protected static function newFactory()
{
	return UserFactory::new();
}
```

Check the documentation to see what else is needed in the User model class.

You should now be able to run Tests without a hitch.

## Additional Configuration
Since Rancor includes Feature Tests for API endpoints, you need to configure Laravel to use api authentication. Laravel 8 now recommends Sanctum for this, but for the development of Rancor this might be an overkill. The easiest solution for this is to add the column `api_token` to the users table.

If you're using the Nested Package setup, you can simply find the `create_users_table` migration provided by Laravel, and add the following line:

```php
$table->string('api_token', 80)->nullable()->default(null);
```

If you're using the Isolate Package setup, you'll need to create a new migration to alter the users table with the statement mentioned above. Keep in mind this migration should be used locally only, as we don't want it in the package itself, so it should be located in `./app/database/`. This path is loaded by our `TestCase.php` to load dev migrations during testing.

## Submitting changes
Please send a [GitHub Pull Request to Rancor](https://github.com/AndrykVP/Rancor/pull/new/dev) with a clear list of what you've done (read more about [pull requests](http://help.github.com/pull-requests/)). 

Please follow our coding conventions (below) and make sure all of your commits are atomic (one feature per commit).

Always write a clear log message for your commits. One-line messages are fine for small changes, but bigger changes should look like this:

	$ git commit -m "A brief summary of the commit
	> 
	> A paragraph describing what changed and its impact."


## Coding Conventions
Start reading our code and you'll get the hang of it. We optimize for readability and add comments where applicable:

	* We indent using tabs, not spaces
	* We ALWAYS put spaces after list items and method parameters (`[1, 2, 3]`, not `[1,2,3]`), around operators (`x += 1`, not `x+=1`).
	* We use single quotes in PHP files for most cases, except when required in string interpolation.
	* We prefer string interpolation over concatenation.

This is open source software. Consider the people who will read your code, and make it look nice for them. It's sort of like driving a car: Perhaps you love doing donuts when you're alone, but with passengers the goal is to make the ride as smooth as possible.

Thanks for your contributions,

Andrés Velázquez, Author of Rancor