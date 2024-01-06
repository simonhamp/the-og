<?php

namespace SimonHamp\TheOg\Backgrounds;

use SimonHamp\TheOg\Interfaces\Background;

class Bananas implements Background
{
    public function path(): string
    {
        return __DIR__.'/../../resources/images/bananas.webp';
    }
}
