<?php

namespace Tests\Integration;

use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\PictureBox;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Layout\TextBox;

class ShiftLayout extends AbstractLayout
{
    protected BorderPosition $borderPosition = BorderPosition::None;

    protected int $borderWidth = 0;

    protected int $height = 640;

    protected int $padding = 10;

    protected int $width = 1280;

    protected string $category;

    protected int $readTime;

    public function features(): void
    {
        $this->addFeature((new PictureBox)
            ->path(__DIR__.'/../resources/very-wide.png')
            ->box(2297, 49)
            ->position(
                x: 0,
                y: 0,
            )
        );

        $this->addFeature((new TextBox)
            ->name('category')
            ->text($this->category())
            ->color($this->config->theme->getUrlColor())
            ->font($this->config->theme->getUrlFont())
            ->size(28)
            ->box(300, 45)
            ->position(
                x: 0,
                y: 60,
            )
        );

        $this->addFeature((new TextBox)
            ->name('title')
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size(60)
            ->box($this->mountArea()->box->width(), 400)
            ->position(
                x: 0,
                y: 20,
                relativeTo: fn () => $this->getFeature('category')->anchor(Position::BottomLeft)
            )
        );

        if ($readTime = $this->readTime()) {
            $this->addFeature((new TextBox)
                ->name('read-time')
                ->text($readTime.' minute read')
                ->color($this->config->theme->getCallToActionColor())
                ->font($this->config->theme->getCallToActionFont())
                ->size(20)
                ->box(300, 45)
                ->position(
                    x: 0,
                    y: 20,
                    relativeTo: fn () => $this->getFeature('title')->anchor(Position::BottomLeft)
                )
            );
        }

        $this->addFeature((new TextBox)
            ->name('url')
            ->text($this->url())
            ->color($this->config->theme->getUrlColor())
            ->font($this->config->theme->getUrlFont())
            ->size(28)
            ->box($this->mountArea()->box->width(), 45)
            ->position(
                x: 0,
                y: 0,
                relativeTo: fn () => $this->mountArea()->anchor(Position::BottomLeft),
                anchor: Position::BottomLeft
            )
        );

        $this->addFeature((new PictureBox)
            ->path($this->watermark()->path())
            ->box(100, 100)
            ->position(
                x: 0,
                y: 0,
                relativeTo: fn () => $this->mountArea()->anchor(Position::BottomRight),
                anchor: Position::BottomRight
            )
        );
    }

    public function category(): string
    {
        return $this->category;
    }

    public function readTime(): ?int
    {
        return $this->readTime ?? null;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function setReadTime(int $readTime): static
    {
        $this->readTime = $readTime;

        return $this;
    }
}
