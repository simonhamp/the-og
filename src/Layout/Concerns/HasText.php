<?php

namespace SimonHamp\TheOg\Layout\Concerns;

use Intervention\Image\Interfaces\ColorInterface;
use Intervention\Image\Interfaces\FontInterface;
use Intervention\Image\Typography\FontFactory;
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

    protected function interventionFontInstance(): FontInterface
    {
        return (new FontFactory(function (FontFactory $factory) {
            $factory->filename($this->font->path());
            $factory->size($this->size);
            $factory->color($this->color);

            if (isset($this->hAlign)) {
                $factory->align($this->hAlign);
            }

            $factory->valign($this->vAlign ?? 'top');

            $factory->lineHeight($this->lineHeight ?? 1.6);

            $factory->wrap($this->box->width());
        }))();
    }
}
