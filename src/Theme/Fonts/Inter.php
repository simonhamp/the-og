<?php

namespace SimonHamp\TheOg\Theme\Fonts;

use SimonHamp\TheOg\Theme\AbstractFont;

class Inter extends AbstractFont
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
        return __DIR__ . "/../../../resources/fonts/Inter/static/Inter-{$this->variant}.ttf";
    }
}
