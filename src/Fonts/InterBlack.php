<?php

namespace SimonHamp\TheOg\Fonts;

use SimonHamp\TheOg\Interfaces\Font;

class InterBlack implements Font
{
    public function path(): string
    {
        return __DIR__ . '/../../resources/fonts/Inter/static/Inter-Black.ttf';
    }
}
