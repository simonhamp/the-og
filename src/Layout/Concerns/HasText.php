<?php

namespace SimonHamp\TheOg\Layout\Concerns;

use Intervention\Image\Interfaces\ColorInterface;
use SimonHamp\TheOg\Interfaces\Font;

trait HasText
{
    protected ColorInterface $color;
    protected Font $font;
    protected float $lineHeight;
    protected float $size;
    protected string $text;

    public function color(ColorInterface $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function font(Font $font): self
    {
        $this->font = $font;

        return $this;
    }

    public function lineHeight(float $lineHeight): self
    {
        $this->lineHeight = $lineHeight;

        return $this;
    }

    public function size(float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
