<?php

namespace SimonHamp\TheOg;

use SimonHamp\TheOg\Interfaces\Background as BackgroundInterface;
use SimonHamp\TheOg\Theme\Background as BaseBackground;

enum Background: string
{
    /**
     * @see https://www.toptal.com/designers/subtlepatterns/bananas/
     */
    case Bananas = 'bananas.webp';

    /**
     * @see https://www.toptal.com/designers/subtlepatterns/cloudy-day/
     */
    case CloudyDay = 'cloudy-day.png';

    /**
     * @see https://www.toptal.com/designers/subtlepatterns/grid-me/
     */
    case GridMe = 'gridme.webp';

    /**
     * @see https://www.toptal.com/designers/subtlepatterns/just-waves/
     */
    case JustWaves = 'just-waves.webp';

    public function load(): BackgroundInterface
    {
        return new BaseBackground(__DIR__ . '/../resources/images/' . $this->value);
    }
}
