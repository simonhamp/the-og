<?php

namespace SimonHamp\TheOg;

use Intervention\Image\Image as RenderedImage;
use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Interfaces\EncoderInterface;
use SimonHamp\TheOg\Background as BuiltInBackground;
use SimonHamp\TheOg\Interfaces\Background;
use SimonHamp\TheOg\Interfaces\Layout;
use SimonHamp\TheOg\Interfaces\Theme;
use SimonHamp\TheOg\Layout\Layouts\Standard;
use SimonHamp\TheOg\Theme\Theme as BuiltInTheme;

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
            $this->theme = $theme->load();
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
    public function background(Background|BuiltInBackground $background, ?float $opacity = 1.0): self
    {
        if ($background instanceof BuiltInBackground) {
            $background = $background->load();
        } else {
            $background = $background;
        }

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
        $encoder = $this->validateEncoder($format);

        $this->render()
            ->encode($encoder)
            ->save($path);

        return $this;
    }

    // TODO: Add a test that covers both eventualities here
    protected function validateEncoder(string $encoder): EncoderInterface
    {
        if (is_a($encoder, $encoderInterface = EncoderInterface::class, true)) {
            return new $encoder;
        }

        throw new \InvalidArgumentException(
            "[{$encoder}] is not a valid image encoder. It must implement [{$encoderInterface}]"
        );
    }
}
