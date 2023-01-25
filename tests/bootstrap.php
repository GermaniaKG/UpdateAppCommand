<?php

/**
 * germania-kg/update-command
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$autoloader_file = __DIR__.'/../vendor/autoload.php';
if (!is_readable($autoloader_file)) {
    exit("\nMissing Composer's vendor/autoload.php; run 'composer install' first.\n\n");
}
