<?php

namespace SimonHamp\TheOg;

class Image
{
    protected string $url;
    protected string $title;
    protected string $description;
    protected Theme $theme;
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
    
    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    
    public function theme(Theme $theme): self
    {
        $this->theme = $theme;
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
