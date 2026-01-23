# Module Hunter for Pantheon-hosted Drupal sites

This command-line tool was created to help developers who maintain a large number of Pantheon-hosted Drupal 8+ sites to easily identify which sites have an a module or modules installed. The primary use case is to check your sites for a module after a security advisory is posted.

## Dependencies
Requires [Pantheon's Terminus CLI tool](https://github.com/pantheon-systems/terminus) and your terminus instance must be configured with a machine token.

## Usage
Use this script with the following syntax:

`module-hunt module_name [module_name2] [module_name3]`

Alternatively search for install profiles:

`profile-hunt profile_name [profile_name2]`

If you need to search for additional extensions, just keep appending their names as arguments. There is no limit.

## How does it work?
Module hunter checks the list of modules installed on the Live environment of the site. If the site is on a Sandbox plan, instead it checks the Dev environment.

## Stability: ALPHA Release
This script has thus far proven stable for our use cases, but has not been extensively tested.

## Installation
### With Composer
If you use `composer global` to install and maintain php tools and libraries, you may add Module Hunter to your command line via:

`composer global require devcollaborative/module-hunter`

**NOTE: As this library is currently pre-release, your global composer.json must include a [minimum-stability](https://getcomposer.org/doc/04-schema.md#minimum-stability) value of either "alpha" or "dev".**

### Without Composer
Download/clone this library and append run the command from it's parent directory as `./module-hunt`
