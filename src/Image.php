<?php

namespace SimonHamp\TheOg;

class Image
{
    protected string $url;
    protected string $title;
    protected string $description;
    protected Layout $layout;
    protected ColorScheme $colorScheme;
    protected string $accentColor;
    protected Background $background;
    protected string $callToAction;

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
        $this->iamge = $image;
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
    
    public function colorScheme(ColorScheme $colorScheme): self
    {
        $this->colorScheme = $colorScheme;
        return $this;
    }
    
    public function accentColor(string $hexCode): self
    {
        $this->accentColor = $hexCode;
        return $this;
    }
    
    public function background(Background $background): self
    {
        $this->background = $background;
        return $this;
    }
    
    public function callToAction(string $content): self
    {
        $this->callToAction = $content;
        return $this;
    }
}
