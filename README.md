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

## Unit tests and development

1. Copy `phpunit.xml.dist` to `phpunit.xml` 
2. Run [PhpUnit](https://phpunit.de/) like this:

```bash
$ composer test
# or
$ vendor/bin/phpunit
```

And there's more in the `scripts` section of **composer.json**.

