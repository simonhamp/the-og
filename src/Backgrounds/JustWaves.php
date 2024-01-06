<?php

namespace SimonHamp\TheOg\Backgrounds;

use SimonHamp\TheOg\Interfaces\Background;

class JustWaves implements Background
{
    public function path(): string
    {
        return __DIR__ . '/../../resources/images/just-waves.webp';
    }
}
