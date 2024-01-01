<?php

namespace SimonHamp\TheOg;

enum Background: string
{
    case Bananas = 'bananas.webp';
    case CloudyDay = 'cloud-day.png';
    case JustWaves = 'just-waves.webp';

    public function path(): string
    {
        return __DIR__ . '/../resources/images/' . $this->value;
    }
}
