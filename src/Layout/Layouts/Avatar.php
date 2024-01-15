<?php

namespace SimonHamp\TheOg\Layout\Layouts;

use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\PictureBox;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Layout\TextBox;

class Avatar extends AbstractLayout
{
    protected BorderPosition $borderPosition = BorderPosition::Left;
    protected int $borderWidth = 25;
    protected int $height = 630;
    protected int $padding = 40;
    protected int $width = 1200;

    public function features(): void
    {
        $this->addFeature((new PictureBox())
            ->path($this->picture())
            ->circle()
            ->box(300, 300)
            ->position(
                x: 0,
                y: 0,
                relativeTo: fn () => $this->mountArea()->anchor(Position::Center)->moveY(-100),
                anchor: Position::Center,
            )
        );

        $this->addFeature((new TextBox())
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size(56)
            ->box($this->mountArea()->box->width() / 1.5, 300)
            ->position(
                x: 0,
                y: 0,
                relativeTo: fn () => $this->mountArea()->anchor(Position::Center)->moveY(100),
                anchor: Position::MiddleTop,
            )
        );

        if ($watermark = $this->watermark()) {
            $this->addFeature((new PictureBox())
                ->path($watermark)
                ->box(100, 100)
                ->position(
                    x: 1180,
                    y: 610,
                    anchor: Position::BottomRight
                )
            );
        }
    }

    public function url(): string
    {
        return strtoupper(parent::url());
    }
}
