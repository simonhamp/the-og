<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Colors\Rgb\Color;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Font;

interface Theme
{
    public function accentColor(string $color): self;

    public function getAccentColor(): Color;

    public function background(Background $background): self;

    public function getBackground(): ?Background;

    public function backgroundColor(string $color): self;

    public function getBackgroundColor(): Color;

    public function backgroundOpacity(float $opacity): self;

    public function getBackgroundOpacity(): float;

    public function baseColor(string $color): self;

    public function getBaseColor(): Color;

    public function baseFont(Font $font): self;

    public function getBaseFont(): Font;

    public function borderColor(string $color): self;

    public function getBorderColor(): Color;

    public function callToActionBackgroundColor(string $color): self;

    public function getCallToActionBackgroundColor(): Color;

    public function callToActionColor(string $color): self;

    public function getCallToActionColor(): Color;

    public function callToActionFont(Font $font): self;

    public function getCallToActionFont(): Font;

    public function descriptionColor(string $color): self;

    public function getDescriptionColor(): Color;

    public function descriptionFont(Font $font): self;

    public function getDescriptionFont(): Font;

    public function titleColor(string $color): self;

    public function getTitleColor(): Color;

    public function titleFont(Font $font): self;

    public function getTitleFont(): Font;

    public function urlColor(string $color): self;

    public function getUrlColor(): Color;

    public function urlFont(Font $font): self;

    public function getUrlFont(): Font;
}
