<?php

namespace SimonHamp\TheOg\Backgrounds;

use SimonHamp\TheOg\Interfaces\Background;

class CloudyDay implements Background
{
    public function path(): string
    {
        return __DIR__.'/../../resources/images/cloudy-day.png';
    }
}
