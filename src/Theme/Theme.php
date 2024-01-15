<?php

namespace SimonHamp\TheOg\Theme;

use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\Interfaces\ColorInterface;
use SimonHamp\TheOg\Interfaces\Background;
use SimonHamp\TheOg\Interfaces\Font;
use SimonHamp\TheOg\Interfaces\Theme as ThemeInterface;

class Theme implements ThemeInterface
{
    public function __construct(
        protected string $accentColor,
        protected Font $baseFont,
        protected string $baseColor,
        protected string $backgroundColor,
        protected ?Background $background = null,
        protected ?string $borderColor = null,
        protected ?string $callToActionBackgroundColor = null,
        protected ?string $callToActionColor = null,
        protected ?Font $callToActionFont = null,
        protected ?string $descriptionColor = null,
        protected ?Font $descriptionFont = null,
        protected ?string $titleColor = null,
        protected ?Font $titleFont = null,
        protected ?string $urlColor = null,
        protected ?Font $urlFont = null,
    )
    {
    }

    public function accentColor(string $color): self
    {
        $this->accentColor = $color;
        return $this;
    }

    public function getAccentColor(): ColorInterface
    {
        return Color::create($this->accentColor);
    }

    public function background(Background $background): self
    {
        $this->background = $background;
        return $this;
    }

    public function getBackground(): ?Background
    {
        return $this->background;
    }

    public function backgroundColor(string $color): self
    {
        $this->backgroundColor = $color;
        return $this;
    }

    public function getBackgroundColor(): ColorInterface
    {
        return Color::create($this->backgroundColor);
    }

    public function baseColor(string $color): self
    {
        $this->baseColor = $color;
        return $this;
    }

    public function getBaseColor(): ColorInterface
    {
        return Color::create($this->baseColor);
    }

    public function baseFont(Font $font): self
    {
        $this->baseFont = $font;

        return $this;
    }

    public function getBaseFont(): Font
    {
        return $this->baseFont;
    }

    public function borderColor(string $color): self
    {
        $this->borderColor = $color;
        return $this;
    }

    public function getBorderColor(): ColorInterface
    {
        return Color::create($this->borderColor ?? $this->accentColor);
    }

    public function callToActionBackgroundColor(string $color): self
    {
        $this->callToActionBackgroundColor = $color;
        return $this;
    }

    public function getCallToActionBackgroundColor(): ColorInterface
    {
        return Color::create($this->callToActionBackgroundColor ?? $this->accentColor);
    }

    public function callToActionColor(string $color): self
    {
        $this->callToActionColor = $color;
        return $this;
    }

    public function getCallToActionColor(): ColorInterface
    {
        return Color::create($this->callToActionColor ?? $this->baseColor);
    }

    public function callToActionFont(Font $font): self
    {
        $this->callToActionFont = $font;
        return $this;
    }

    public function getCallToActionFont(): Font
    {
        return $this->callToActionFont ?? $this->baseFont;
    }

    public function descriptionColor(string $color): self
    {
        $this->descriptionColor = $color;
        return $this;
    }

    public function getDescriptionColor(): ColorInterface
    {
        return Color::create($this->descriptionColor ?? $this->baseColor);
    }

    public function descriptionFont(Font $font): self
    {
        $this->descriptionFont = $font;
        return $this;
    }

    public function getDescriptionFont(): Font
    {
        return $this->descriptionFont ?? $this->baseFont;
    }

    public function titleColor(string $color): self
    {
        $this->titleColor = $color;
        return $this;
    }

    public function getTitleColor(): ColorInterface
    {
        return Color::create($this->titleColor ?? $this->baseColor);
    }

    public function titleFont(Font $font): self
    {
        $this->titleFont = $font;
        return $this;
    }

    public function getTitleFont(): Font
    {
        return $this->titleFont ?? $this->baseFont;
    }

    public function urlColor(string $color): self
    {
        $this->urlColor = $color;
        return $this;
    }

    public function getUrlColor(): ColorInterface
    {
        return Color::create($this->urlColor ?? $this->accentColor);
    }

    public function urlFont(Font $font): self
    {
        $this->baseFont = $font;
        return $this;
    }

    public function getUrlFont(): Font
    {
        return $this->urlFont ?? $this->baseFont;
    }
}
