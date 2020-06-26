# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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