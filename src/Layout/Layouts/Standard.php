<?php

namespace SimonHamp\TheOg\Layout\Layouts;

use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\Position;

class Standard extends AbstractLayout
{
    protected BorderPosition $borderPosition = BorderPosition::All;
    protected int $borderWidth = 25;
    protected int $height = 630;
    protected int $padding = 40;
    protected int $width = 1200;

    public function url(): string
    {
        return strtoupper(parent::url());
    }

    protected function features(string $feature, string $setting): mixed
    {
        $settings = [
            'call_to_action' => [
                'font_size' => 20,
                'dimensions' => [$this->mountArea()->box->width(), 240],
                'layout' => [
                    'x' => 0,
                    'y' => 20,
                    'relativeTo' => fn () => $this->getDescription(),
                ],
            ],
            'description' => [
                'font_size' => 40,
                'dimensions' => [$this->mountArea()->box->width(), 240],
                'layout' => [
                    'x' => 0,
                    'y' => 50,
                    'relativeTo' => fn () => $this->getTitle(),
                    'position' => Position::BottomLeft
                ],
            ],
            'title' => [
                'font_size' => 60,
                'dimensions' => [$this->mountArea()->box->width(), 400],
                'layout' => [
                    'x' => 0,
                    'y' => 20,
                    'relativeTo' => fn () => $this->getUrl(),
                    'position' => Position::BottomLeft
                ],
            ],
            'url' => [
                'font_size' => 28,
                'dimensions' => [$this->mountArea()->box->width(), 45],
                'layout' => [
                    'x' => 0,
                    'y' => 20,
                    'relativeTo' => fn () => $this->mountArea(),
                ],
            ],
        ];

        return $settings[$feature][$setting];
    }
}
