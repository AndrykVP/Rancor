# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
## [1.4.0] - 2021-03-09
### Added
- View Components: `AdminLayout`, `MainLayout`, `Alert`, `AdminNavigation`, `Main Navigation`

### Changed
- Refactored all Models to folder and namespace `Models` under their respective modules, to follow Laravel 8 directory structure.
- `App\User` to `App\Models\User` change as per Laravel 8 directory structure
- Namespacing of database Seeders and Factories
- Views now use Tailwind CSS instead of Bootstrap, as per Laravel 8 Startkits (Laravel Breeze specifically)
- Renamed `FrameworkServiceProvider` to `PackageServiceProvider` for consistency of naming convention.
- Scanner log moved to Audit module:
  - `Scanner\Log` => `Audit\Models\EntryLog`
  - `Scanner\Events\EditScan` => `Audit\Events\EntryUpdate`
  - `Scanner\Listeners\CreateScanLog` => `Audit\Listeners\CreateScanLog`
- Turned Forums `views/includes` into View Components:  `BoardRow`, `CategoryCard`, `DiscussionList`
- `Structure\Policies` and `Auth\Policies` now use model binding for potential future extensions 

### Deleted
- Gate `manage-faction` became irrelevant after the addition of the permission `view-admin-panel` used for admin middleware.

## [1.3.3] - 2021-03-04
### Added
- `Structure\Award` and `Structure\Type` models, along with their respective migrations and factories
- `Audit\NodeLog` and `Auit\AwardLog` to keep track of changes to these models
- `Holocron\Node` and `Holocron\Collection` models, along with their respective migrations and factories

### Changed
- Database table names for `Auth\Permission` and `Auth\Roles` are now prefixed `rancor_` for consistency
- Database table names for `Structure\Faction`, `Structure\Department` and `Structure\Rank` are now prefixed `structure_` for consistency
- `Structure\Department` now has a `color` column for optional front-end visualization
- `Structure\Traits\FactionMember` adds relationship between `User` and the new `Award` model

## [1.3.2] - 2021-02-26
### Added
- `Scanner` module. This includes migrations, controllers, views, etc. for `Entry` and `Log` models.
- Events and Listeners to audit changes to `Scanner\Entry` models.

## [1.3.1] - 2021-01-04
### Added
- `Package\Traits\RancorUser` trait to simplify usage of modular traits.
- `Views` on every module for front-end usage.
- `News\Tag` models, controllers, migrations, views, etc; for advanced functionality of the News module
- Admin Panel with middleware for admin access.

### Changed
- `Rancor\Faction` namespace to `Rancor\Structure` for better clarity.

## [1.3.0] - 2020-11-14
### Added
- Column `color` on `user_logs` table for UI display.
- `Audit\Http\Controllers\LogController` to include more information on JSON request
- Permission `manage-faction` and its respective Gate for easier rendering of conditional menus in Navbar.
- Custom `dateFormat` field in config file for date rendering on all resources.
- New `search()` method in `Auth\Http\Controllers\UserController` to search Users by name.
- New `drafts()` method on `News\Http\Controllers\ArticleController` to see only unpublished articles.
- `Auth\Http\Resources\PermissionResource` for conditional rendering in `UserResource`
- `Providers\EventServiceProvider` to automatically register Rancor's events and listeners into the service container.
- `Forum` module, including Models, Controllers, Resources, Requests, Events and Listeners.

### Changed
- Moved config files from individual modules to a `config/` folder in root directory
- Moved `News\Http\Controllers\NewsController@index` method to `...\ArticleController@public` method for simplicity.
- `Resources` on modules `Auth`, `Faction` and `News` now use `whenLoaded()` method for conditional rendering of relationships.

### Fixed
- Error in `Audit\Listeners` where old database fields were still included during inserts.
- Condition `elseif($this->permissions()` in `Auth\Traits\HasPrivs` was fixed to `if()`, and both conditions now use an improved check.
- Method `$request->all()` changed to `$request->validated()` in all Api Controllers for security.
- Model binding in all Api Controllers for simplicity.
- Model binding in all Policies for advanced conditions.

### Deleted
- `News\Http\Controllers\NewsController`, as its only relevant method was moved to `News\Http\Controllers\ArticleController`


## [1.2.1] - 2020-08-26
### Fixed
- Listener for `Audit` module to log when a User's rank changes, now checks first if the rank_id column changed, and also that the previous rank_id was not null. Otherwise creates a first log.

## [1.2.0] - 2020-08-11
### Added
- Controller, Listeners and Routes for `Audit` module that tracks promotions/demotions of Users, as well as IP logging.
- Listener for `Auth` module to fill User's `last_login` column on login.
- Event and Listener for `Audit` module to log when a User's rank changes.
- `Faction\Rank` Model has a `level` column to keep track of promotions/demotions in `Audit` module.

### Changed
- User table uses `nickname` column instead of `biography`

## [1.1.2] - 2020-07-09
### Added
- Controller, Request Validation, Resource and Routes for `Auth\Role`
- Policies for `Auth\Role`, `App\Models\User`, `Faction\Faction`, `Faction\Department`, `Faction\Rank` and , `News\Article`.
- Configuration file for defining what authentication middleware to use in API Controllers.

### Changed
- Config files have been moved from `src/<Feature>/config.php` to `config/<feature>.php`. 

### Removed
- IDGen functionality. It's been moved to a development branch as it is not yet completed.

## [1.1.1] - 2020-07-09
### Added
- New feature `Rancor\News` with [mews/purifier](https://github.com/mewebstudio/Purifier) dependency.
- Routes, API Controllers, Resources and Requests for `Faction\Faction`, `Faction\Department`, `Faction\Rank`, `Auth\User` and `News\Article` models.
- `Role` model to the Auth feature, and its relationship to `App\Models\User` via trait.

### Changed
- `Auth\Permission` to be have a Many to Many polymorphic relation with `Auth\Role` and Laravel's `App\Models\User` model.
- `hasPermission()`method in Auth trait, to account for change in `Permission` model.

### Removed
- API functionality. It's been moved to a development branch as it is not yet completed.

## [1.1.0] - 2020-06-26
### Changed
- Package renamed from `swc_api` to `Rancor`!

### Added
- Custom log channel added to stack through the `FrameworkServiceProvider`

## [1.0.3] - 2020-06-26
### Added
- **Helper** for _IDGen_ feature that runs as static class to generate Signatures and Avatars using a configuration file, and assets that are published in the Service Provider. (WIP)
- **Facade** for _IDGen_ feature to instantiate the Helper class as a signleton for global use.

### Changed
- Changed Folder structure and namespaces for each feature of the package. Namely: `API`, `Auth`, `Faction` and `IDGen`
- Changed `Provider\SWCServiceProvider` to `Provider\FrameworkServiceProvider` and included a new service provider for each of the features listed above.
- `HasPrivs` trait was split from `FactionMember`trat as consequence of the new folder structure. 

## [1.0.2] - 2020-06-24
### Added
- **Models** and **Migrations** for `Factions`, `Departments`, `Ranks` and `Permissions`.
- **Migration** to alter `Users` table to accomodate for package-related functions.
- `FactionMember` trait to use on models, with common functions for relations.

## [1.0.1] - 2020-05-04
### Added
- **Models** and **Migrations** for `Sectors`, `Systems` and `Planets`.
- **Jobs** for processing each of the models above, by consuming Combine's Web Services.
- **Console Command** for running the jobs above; which can be limited to individual models with parameters. (WIP)

### Removed
- **Model**, **Route** and **Controller** for `Facilities` as it will be included in a future feature called _Asset Manager_.

## [1.0.0] - 2020-04-16
### Added
- This CHANGELOG file to hopefully serve as an evolving example of a
  standardized open source project CHANGELOG.
- Added a Work-in-Progress version of the Planetary Income Calculator page
  available for beta-testers through password.