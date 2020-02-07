# Module Hunter for Pantheon-hosted Drupal sites

This command-line tool was created to help developers who maintain a large number of Pantheon-hosted Drupal sites to easily identify which sites have an active instance of a particular module. You can optionally choose to only check D7 or only D8 sites. The primary use case is for enabling a quick response to critical security advisories.

## Dependencies
 Requires command-line access to a properly configured instance of [Pantheon's Terminus CLI tool](https://github.com/pantheon-systems/terminus).

## Syntax
Use this script using the following
syntax:

`./module_hunt.php module_name [d7|d8]`

## Stability: ALPHA Release
This script has thus far proven stable for our use cases, but has not been extensively tested.

## Todo
* Support checking for multiple modules.
* Make this a terminus plug-in instead[?]
* Instructions for installing this as a global command.
