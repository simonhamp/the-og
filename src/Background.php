<?php

namespace SimonHamp\TheOg;

use SimonHamp\TheOg\Interfaces\Background as BackgroundInterface;
use SimonHamp\TheOg\Theme\AbstractBackground;

enum Background: string
{
    case Bananas = 'bananas.webp';
    case CloudyDay = 'cloudy-day.png';
    case JustWaves = 'just-waves.webp';

    public function load(): BackgroundInterface
    {
        return new class (__DIR__ . '/../resources/images/' . $this->value) extends AbstractBackground {};
    }
}
