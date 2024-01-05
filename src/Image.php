<?php

namespace SimonHamp\TheOg;

use Intervention\Image\Encoders\PngEncoder;
use SimonHamp\TheOg\Traits\RendersImages;

class Image
{
    use RendersImages;

    protected string $accentColor = '#000000';
    protected ?Background $background = null;
    protected ?string $backgroundURL = null;
    protected string $backgroundColor = '#ffffff';
    protected float $backgroundOpacity = 1.0;
    protected ?Border $border = null;
    protected string $callToAction;
    protected string $description;
    protected int $height = 630;
    protected Layout $layout = Layout::Standard;
    protected Theme $theme = Theme::Light;
    protected string $title;
    protected ?string $url = null;
    protected int $width = 1200;

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function image(string $image): self
    {
        $this->image = $image;
        return $this;
    }
    
    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    
    public function layout(Layout $layout): self
    {
        $this->layout = $layout;
        return $this;
    }
    
    public function theme(Theme $theme): self
    {
        $this->theme = $theme;
        return $this;
    }
    
    public function accentColor(string $hexCode): self
    {
        // TODO: Make sure it's a valid hex code
        $this->accentColor = $hexCode;
        return $this;
    }

    public function background(Background $background, float $opacity = 1.0): self
    {
        $this->backgroundOpacity = $opacity < 0 ? 0 : ($opacity > 1 ? 1 : $opacity);
        $this->background = $background;
        return $this;
    }

    public function backgroundURL(string $backgroundURL, float $opacity = 1.0): self
    {
        if (!filter_var($backgroundURL, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('URL is not valid');
        }
        
        $imageInfo = @getimagesize($backgroundURL);
        if (!$imageInfo) {
            throw new \InvalidArgumentException('URL doesn\'t point to an image');
        }

        $this->backgroundOpacity = max(0, min($opacity, 1));
        $this->backgroundURL = $backgroundURL;
        return $this;
    }

    public function callToAction(string $content): self
    {
        $this->callToAction = $content;
        return $this;
    }

    public function width(int $width): self
    {
        $this->width = $width < 100 ? 100 : $width;
        return $this;
    }

    public function height(int $height): self
    {
        $this->height = $height < 100 ? 100 : $height;
        return $this;
    }

    public function backgroundColor(string $backgroundColor): self
    {
        // TODO: Make sure it's a valid hex code
        $this->backgroundColor = $backgroundColor;
        return $this;
    }

    public function border(int $width = 20, BorderPosition $position = BorderPosition::All): self
    {
        $this->border = (new Border())
            ->width($width)
            ->position($position);

        return $this;
    }

    public function save(string $path, string $format = PngEncoder::class): self
    {
        $this->render()
            ->encode(new $format)
            ->save($path);

        return $this;
    }
}
