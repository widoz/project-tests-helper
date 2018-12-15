<?php # -*- coding: utf-8 -*-
// phpcs:disable
/*
 * This file is part of the project-tests-helper package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ProjectTestsHelper;

use Composer\Script\Event;

class PostPackageInstall
{
    const DIR_TESTS = 'tests';
    const DIR_UNIT_TESTS = self::DIR_TESTS . '/unit';
    const INCLUDE_FILES = [
        'inc/phpunit/bootstrap.php.dist',
        'inc/phpunit/phpunit.xml.dist',
    ];

    public static function moveIncludeFiles(Event $event)
    {
        $composer = $event->getComposer();
        $package = $composer->getPackage();
        $config = $composer->getConfig();

        $packageName = $package->getName();
        $vendorDir = rtrim($config->get('vendor-dir'), '/');
        $rootDir = rtrim(dirname($vendorDir), '/');

        foreach (self::INCLUDE_FILES as $file) {
            $fileBasename = basename($file);
            $sourcePackageFile = $vendorDir . "/{$packageName}/{$file}";

            // TODO SHOW ERROR NOTICE.
            if (!file_exists($sourcePackageFile) || !is_readable($sourcePackageFile)) {
                continue;
            }

            copy($sourcePackageFile, "{$rootDir}/" . self::DIR_UNIT_TESTS . "/{$fileBasename}");
        }
    }
}
