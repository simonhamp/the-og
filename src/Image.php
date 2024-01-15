<?php

namespace SimonHamp\TheOg;

use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Image as RenderedImage;
use Intervention\Image\Interfaces\EncoderInterface;
use SimonHamp\TheOg\Background as BuiltInBackground;
use SimonHamp\TheOg\Interfaces\Background;
use SimonHamp\TheOg\Interfaces\Layout;
use SimonHamp\TheOg\Interfaces\Theme;
use SimonHamp\TheOg\Layout\Layouts\Standard;
use SimonHamp\TheOg\Theme as BuiltInTheme;
use SimonHamp\TheOg\Theme\BackgroundPlacement;

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

    public function __construct()
    {
        $this->layout(new Standard);
        $this->theme(BuiltInTheme::Light);
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
    public function layout(Layout $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * The theme to use
     */
    public function theme(Theme|BuiltInTheme $theme): self
    {
        if ($theme instanceof BuiltInTheme) {
            $theme = $theme->load();
        }

        $this->theme = $theme;
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
    public function background(Background|BuiltInBackground $background, ?float $opacity = null, ?BackgroundPlacement $placement = null): self
    {
        if ($background instanceof BuiltInBackground) {
            $background = $background->load();
        }

        if (isset($opacity)) {
            $background->setOpacity($opacity);
        }

        if (isset($placement)) {
            $background->setPlacement($placement);
        }

        $this->theme->background($background);
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

    public function save(string $path, EncoderInterface $encoder = new PngEncoder()): self
    {
        $this->render()
            ->encode($encoder)
            ->save($path);

        return $this;
    }

    public function toString(EncoderInterface $encoder = new PngEncoder): string
    {
        return $this->render()
            ->encode($encoder)
            ->toString();
    }
}
