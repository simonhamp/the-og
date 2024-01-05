<?php

namespace SimonHamp\TheOg\Modifiers;

use Intervention\Image\Drivers\Imagick\Modifiers\TextModifier as ImagickTextModifier;
use Intervention\Image\Geometry\Polygon;

class TextModifier extends ImagickTextModifier
{
    /**
     * Exists purely to expose Intervention's baked-in boxSize method
     */
    public function boxSize(string $text): Polygon
    {
        return parent::boxSize($text);
    }
}
