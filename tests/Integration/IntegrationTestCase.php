<?php

namespace Tests\Integration;

use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class IntegrationTestCase extends TestCase
{
    protected const TESTCASE_DIRECTORY = __DIR__.'/../resources/testcases';

    protected function tearDown(): void
    {
        TestCase::tearDown();

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::TESTCASE_DIRECTORY, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($files as $file) {
            unlink($file->getRealPath());
        }
    }
}
