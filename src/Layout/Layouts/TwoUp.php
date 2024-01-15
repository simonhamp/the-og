<?php

namespace SimonHamp\TheOg\Layout\Layouts;

use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\PictureBox;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Layout\TextBox;

class TwoUp extends AbstractLayout
{
    protected BorderPosition $borderPosition = BorderPosition::None;
    protected int $borderWidth = 25;
    protected int $height = 630;
    protected int $padding = 40;
    protected int $width = 1200;

    public function features(): void
    {
        if ($picture = $this->picture()) {
            $this->addFeature((new PictureBox())
                ->path($picture)
                ->box($this->width / 2, $this->height)
                ->position(
                    x: 0,
                    y: 0,
                )
            );
        }

        $this->addFeature((new TextBox())
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size(56)
            ->box($this->mountArea()->box->width() / 2, 400)
            ->position(
                x: 0,
                y: 0,
                relativeTo: function () {
                    if ($url = $this->getFeature('url')) {
                        return $url->anchor(Position::BottomLeft)
                            ->moveY(40);
                    }

                    return $this->mountArea()
                        ->anchor(Position::MiddleTop)
                        ->moveX(40)
                        ->moveY(20);
                },
            )
        );

        if ($callToAction = $this->callToAction()) {
            $this->addFeature((new TextBox())
                ->name('call_to_action')
                ->text($callToAction)
                ->color($this->config->theme->getCallToActionColor())
                ->font($this->config->theme->getCallToActionFont())
                ->size(36)
                ->box($this->mountArea()->box->width() / 2, 100)
                ->position(
                    x: 0,
                    y: 0,
                    relativeTo: fn() => $this->mountArea()->anchor(Position::BottomRight),
                    anchor: Position::BottomRight,
                )
            );

            if ($watermark = $this->watermark()) {
                $this->addFeature((new PictureBox())
                    ->path($watermark)
                    ->box(100, 100)
                    ->position(
                        x: 20,
                        y: 610,
                        anchor: Position::BottomLeft
                    )
                );
            }
        }

        if ($url = $this->url()) {
            $this->addFeature((new TextBox())
                ->name('url')
                ->text($url)
                ->color($this->config->theme->getUrlColor())
                ->font($this->config->theme->getUrlFont())
                ->size(28)
                ->box($this->mountArea()->box->width(), 45)
                ->position(
                    x: 40,
                    y: 20,
                    relativeTo: fn() => $this->mountArea()->anchor(Position::MiddleTop),
                )
            );
        }
    }

    public function url(): string
    {
        return strtoupper(parent::url());
    }
}
