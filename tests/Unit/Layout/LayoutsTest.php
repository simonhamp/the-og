<?php

namespace Tests\Unit\Layout;

use PHPUnit\Framework\Attributes\DataProvider;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\Layouts\GitHubBasic;
use SimonHamp\TheOg\Layout\Layouts\Standard;
use Tests\Unit\UnitTestcase;

class LayoutsTest extends UnitTestCase
{
    #[DataProvider('provideLayouts')]
    public function test_layouts(
        string $layoutClass,
        BorderPosition $borderPosition,
        int $borderWidth,
        int $boxWidth,
        int $boxHeight,
        int $mountX,
        int $mountY
    ): void {
        $layout = new $layoutClass();

        self::assertEquals($borderPosition, $layout->getBorderPosition());
        self::assertEquals($borderWidth, $layout->getBorderWidth());
        self::assertEquals($boxWidth, $layout->mountArea()->box->width());
        self::assertEquals($boxHeight, $layout->mountArea()->box->height());
        self::assertEquals($mountX, $layout->mountArea()->position->x());
        self::assertEquals($mountY, $layout->mountArea()->position->y());
    }

    public static function provideLayouts(): iterable
    {
        yield 'standard' => [Standard::class, BorderPosition::All, 25, 1070, 500, 65, 65];
        yield 'github basic' => [GitHubBasic::class, BorderPosition::Bottom, 25, 1190, 550, 45, 45];
    }
}
