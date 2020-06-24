# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.2] - 2020-06-24
### Added
- Created **Models** and **Migrations** for `Factions`, `Departments`, `Ranks` and `Permissions`.
- Created **Migration** to alter `Users` table to accomodate for package-related functions.
- Created `FactionMember` trait to use on models, with common functions for relations.

## [1.0.1] - 2020-05-04
### Added
- Created **Models** and **Migrations** for `Sectors`, `Systems` and `Planets`.
- Created **Jobs** for processing each of the models above, by consuming Combine's Web Services.
- Created a **Console Command** for running the jobs above; which can be limited to individual models with parameters.

## [1.0.0] - 2020-04-16
### Added
- This CHANGELOG file to hopefully serve as an evolving example of a
  standardized open source project CHANGELOG.
- Added a Work-in-Progress version of the Planetary Income Calculator page
  available for beta-testers through password.