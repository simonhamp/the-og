<?php

namespace SimonHamp\TheOg\Theme\Fonts;

use SimonHamp\TheOg\Theme\AbstractFont;

class RobotoSlab extends AbstractFont
{
    public static function regular(): self
    {
        return new self('Regular');
    }

    public static function black(): self
    {
        return new self('Black');
    }

    public static function bold(): self
    {
        return new self('Bold');
    }

    public static function light(): self
    {
        return new self('Light');
    }

    public function path(): string
    {
        return __DIR__ . "/../../../resources/fonts/Roboto_Slab/static/RobotoSlab-{$this->variant}.ttf";
    }
}
