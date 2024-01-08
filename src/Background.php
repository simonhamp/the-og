<?php

namespace SimonHamp\TheOg;

enum Background: string implements Interfaces\Background
{
    case Bananas = 'bananas.webp';
    case CloudyDay = 'cloudy-day.png';
    case JustWaves = 'just-waves.webp';

    public function path(): string
    {
        return __DIR__ . '/../resources/images/' . $this->value;
    }
}
