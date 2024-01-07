<?php

namespace SimonHamp\TheOg;

use Intervention\Image\Image as RenderedImage;
use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\Encoders\PngEncoder;
use SimonHamp\TheOg\Interfaces\Layout;
use SimonHamp\TheOg\Layout\Layouts;
use SimonHamp\TheOg\Interfaces\Theme;
use SimonHamp\TheOg\Themes\Themes;

class Image
{
    public Layout $layout;
    public Theme $theme;

    public readonly string $callToAction;
    public readonly string $description;
    public readonly string $picture;
    public readonly string $title;
    public readonly string $url;
    public readonly string $watermark;
    public readonly string $backgroundUrl;

    public function __construct()
    {
        $this->layout(Layouts::Standard);
        $this->theme(Themes::Light);
    }

    /**
     * The call to action text
     */
    public function callToAction(string $content): self
    {
        $this->callToAction = $content;
        return $this;
    }

    /**
     * The description text
     */
    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * The picture to display
     */
    public function picture(string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * The title text
     */
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * The URL
     */
    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * The watermark image
     */
    public function watermark(string $watermark, ?float $opacity = 1.0): self
    {
        $this->watermark = $watermark;
        return $this;
    }

    /**
     * The layout to use
     */
    public function layout(Layouts|Layout $layout): self
    {
        if ($layout instanceof Layouts) {
            $this->layout = $layout->getLayout();
        } else {
            $this->layout = $layout;
        }

        return $this;
    }

    /**
     * The theme to use
     */
    public function theme(Themes|Theme $theme): self
    {
        if ($theme instanceof Themes) {
            $this->theme = $theme->getTheme();
        } else {
            $this->theme = $theme;
        }

        return $this;
    }

    /**
     * The background image from URL
     */
    public function backgroundUrl(string $backgroundUrl, ?float $opacity): self
    {
        $this->backgroundUrl = $backgroundUrl;
        $this->theme->backgroundOpacity($opacity);
        return $this;
    }

    /**
     * Override the theme's default accent color
     */
    public function accentColor(string $color): self
    {
        $this->theme->accentColor($color);
        return $this;
    }

    /**
     * Override the theme's default background
     */
    public function background(Background $background, ?float $opacity = 1.0): self
    {
        $this->theme->background($background);
        $this->theme->backgroundOpacity($opacity);
        return $this;
    }

    /**
     * Override the theme's default background color
     */
    public function backgroundColor(string $backgroundColor): self
    {
        $this->theme->backgroundColor($backgroundColor);
        return $this;
    }

    /**
     * Override the layout's default border
     */
    public function border(?BorderPosition $position = null, ?Color $color = null, ?int $width = null): self
    {
        $this->layout->border(
            (new Border())
                ->position($position ?? $this->layout->getBorderPosition())
                ->color($color ?? $this->theme->getBorderColor())
                ->width($width ?? $this->layout->getBorderWidth())
        );

        return $this;
    }

    public function render(): RenderedImage
    {
        return $this->layout->render($this);
    }

    public function save(string $path, string $format = PngEncoder::class): self
    {
        $this->render()
            ->encode(new $format)
            ->save($path);

        return $this;
    }

    public function toString(string $format = PngEncoder::class): string
    {
        return $this->render()
            ->encode(new $format)
            ->toString();
    }
}
