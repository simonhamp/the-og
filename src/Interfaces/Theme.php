<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Interfaces\ColorInterface;

interface Theme
{
    public function accentColor(string $color): self;

    public function getAccentColor(): ColorInterface;

    public function background(Background $background): self;

    public function getBackground(): ?Background;

    public function backgroundColor(string $color): self;

    public function getBackgroundColor(): ColorInterface;

    public function baseColor(string $color): self;

    public function getBaseColor(): ColorInterface;

    public function baseFont(Font $font): self;

    public function getBaseFont(): Font;

    public function borderColor(string $color): self;

    public function getBorderColor(): ColorInterface;

    public function callToActionBackgroundColor(string $color): self;

    public function getCallToActionBackgroundColor(): ColorInterface;

    public function callToActionColor(string $color): self;

    public function getCallToActionColor(): ColorInterface;

    public function callToActionFont(Font $font): self;

    public function getCallToActionFont(): Font;

    public function descriptionColor(string $color): self;

    public function getDescriptionColor(): ColorInterface;

    public function descriptionFont(Font $font): self;

    public function getDescriptionFont(): Font;

    public function titleColor(string $color): self;

    public function getTitleColor(): ColorInterface;

    public function titleFont(Font $font): self;

    public function getTitleFont(): Font;

    public function urlColor(string $color): self;

    public function getUrlColor(): ColorInterface;

    public function urlFont(Font $font): self;

    public function getUrlFont(): Font;
}
