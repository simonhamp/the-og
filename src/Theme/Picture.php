<?php

namespace SimonHamp\TheOg\Theme;

class Picture
{
    protected bool $isUrl = false;

    public function __construct(
        protected string $path,
        protected ?float $opacity = 1.0,
        protected ?PicturePlacement $placement = null,
    ){
        $this->setPath($path);
        $this->setOpacity($opacity);
    }

    public function opacity(): float
    {
        return $this->opacity;
    }

    public function setOpacity(float $opacity): static
    {
        $this->opacity = max(0, min($opacity, 1));
        return $this;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $this->isUrl = true;
        }

        $this->path = $path;
        return $this;
    }

    public function placement(): ?PicturePlacement
    {
        return $this->placement ?? null;
    }

    public function setPlacement(PicturePlacement $placement): static
    {
        $this->placement = $placement;
        return $this;
    }

    public function isUrl(): bool
    {
        return $this->isUrl;
    }
}
