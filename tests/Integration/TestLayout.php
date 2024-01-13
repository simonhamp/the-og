<?php

namespace Tests\Integration;

use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\Box;
use SimonHamp\TheOg\Layout\Position;

class TestLayout extends AbstractLayout
{
    protected BorderPosition $borderPosition = BorderPosition::None;

    protected int $borderWidth = 0;

    protected int $height = 400;

    protected int $padding = 10;

    protected int $width = 600;

    public function features(): void
    {
        $this->addFeature((new Box)
            ->box(100, 100)
            ->position(
                x: 0,
                y: 0,
                relativeTo: fn () => $this->mountArea()->anchor(Position::BottomLeft),
                anchor: Position::Center
            )
        );
    }
}
