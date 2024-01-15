<?php

namespace SimonHamp\TheOg;

use SimonHamp\TheOg\Interfaces\Background as BackgroundInterface;
use SimonHamp\TheOg\Theme\Background as BaseBackground;

enum Background: string
{
    case Bananas = 'bananas.webp';
    case CloudyDay = 'cloudy-day.png';
    case GridMe = 'gridme.webp';
    case JustWaves = 'just-waves.webp';

    public function load(): BackgroundInterface
    {
        return new BaseBackground(__DIR__ . '/../resources/images/' . $this->value);
    }
}
