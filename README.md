<h1 align="center">Germania KG · UpdateApp</h1>

<p align="center"><b>Symfony Console Command for updating a web app from CLI.</b></p>

[![Tests](https://github.com/GermaniaKG/UpdateAppCommand/actions/workflows/php.yml/badge.svg)](https://github.com/GermaniaKG/UpdateAppCommand/actions/workflows/php.yml)

## Installation

```bash
$ composer require germania-kg/update-command:^1.0
```

## Requirements

This package requires  the ***Symfony Console*** and ***Process*** components.

## Usage

```php
use Germania\UpdateApp\UpdateAppCommand;

$cache_directories = array();

$cmd = new UpdateAppCommand();
$cmd = new UpdateAppCommand($cache_directories);
```

## CLI usage

The command name is `update`, and it accepts a `--no-dev` option for production environments:

```bash
$ bin/console update
$ bin/console update --no-dev
```



## Development

```bash
$ git clone git@github.com:GermaniaKG/UpdateAppCommand.git
# or
$ git clone https://github.com/GermaniaKG/UpdateAppCommand.git
```

### Run all tests

This packages has predefined test setups for code quality, code readability and unit tests. Check them out at the `scripts` section of **[composer.json](./composer.json)**.

```bash
$ composer test
# ... which currently includes
$ composer phpunit
```

### Unit tests

Default configuration is **[phpunit.xml.dist](./phpunit.xml.dist).** Create a custom **phpunit.xml** to apply your own settings. 
Also visit [phpunit.readthedocs.io](https://phpunit.readthedocs.io/) · [Packagist](https://packagist.org/packages/phpunit/phpunit)

```bash
$ composer phpunit
# ... or
$ vendor/bin/phpunit
```

### PhpStan

Default configuration is **[phpstan.neon.dist](./phpstan.neon.dist).** Create a custom **phpstan.neon** to apply your own settings. Also visit [phpstan.org](https://phpstan.org/) · [GitHub](https://github.com/phpstan/phpstan) · [Packagist](https://packagist.org/packages/phpstan/phpstan)

```bash
$ composer phpstan
# ... which includes
$ vendor/bin/phpstan analyse
```

### PhpCS

Default configuration is **[.php-cs-fixer.dist.php](./.php-cs-fixer.dist.php).** Create a custom **.php-cs-fixer.php** to apply your own settings. Also visit [cs.symfony.com](https://cs.symfony.com/) ·  [GitHub](https://github.com/FriendsOfPHP/PHP-CS-Fixer) · [Packagist](https://packagist.org/packages/friendsofphp/php-cs-fixer)

```bash
$ composer phpcs
# ... which aliases
$ vendor/bin/php-cs-fixer fix --verbose --diff --dry-run
```

Apply all CS fixes:

```bash
$ composer phpcs:apply
# ... which aliases 
$ vendor/bin/php-cs-fixer fix --verbose --diff
```





