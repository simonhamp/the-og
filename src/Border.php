<?php

namespace SimonHamp\TheOg;

use Intervention\Image\Colors\Rgb\Color;
use Intervention\Image\Interfaces\ColorInterface;

class Border
{
    protected BorderPosition $position;
    protected int $width;
    protected string $color;

    public function color(ColorInterface $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getColor(): ColorInterface
    {
        return Color::create($this->color);
    }

    public function position(BorderPosition $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getPosition(): BorderPosition
    {
        return $this->position;
    }

    public function width(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }
}
