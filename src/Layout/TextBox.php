<?php

namespace SimonHamp\TheOg\Layout;

use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Polygon;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Interfaces\ColorInterface;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Modifiers\TextModifier;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Typography\TextBlock;
use SimonHamp\TheOg\Interfaces\Font;
use SimonHamp\TheOg\Modifiers\TextModifier as CustomTextModifier;

class TextBox extends Box
{
    public ColorInterface $color;
    public Font $font;
    public string $hAlign;
    public int $lineHeight;
    public int $size;
    public string $text;
    public string $vAlign;

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

    public function hAlign(string $hAlign): self
    {
        $this->hAlign = $hAlign;
        return $this;
    }

    public function lineHeight(int $lineHeight): self
    {
        $this->lineHeight = $lineHeight;
        return $this;
    }

    public function size(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function vAlign(string $vAlign): self
    {
        $this->vAlign = $vAlign;
        return $this;
    }

    public function render(ImageInterface $image): void
    {
        $this->ensureTextFitsBox($this->generateModifier($this->text, $this->calculatePosition()))->apply($image);
    }

    protected function getPrerenderedBox(): Rectangle
    {
        $modifier = $this->generateModifier($this->text);

        return $this->getFinalTextBox($modifier);
    }

    protected function generateModifier(string $text, Point $position = new Point()): CustomTextModifier
    {
        return new CustomTextModifier(
            new TextModifier(
                $text,
                $position,
                (new FontFactory(
                    function(FontFactory $factory) {
                        $factory->filename($this->font->path());
                        $factory->size($this->size);
                        $factory->color($this->color);

                        if (isset($this->hAlign)) {
                            $factory->align($this->hAlign);
                        }

                        $factory->valign($this->vAlign ?? 'top');

                        $factory->lineHeight($this->lineHeight ?? 1.6);
                    }
                ))()
            ),
            new ImagickDriver
        );
    }

    protected function doesTextFitInBox(Rectangle $renderedBox): bool
    {
        return $renderedBox->fitsInto($this->box);
    }

    protected function getRenderedBoxForText(string $text, CustomTextModifier $modifier): Rectangle|Polygon
    {
        return $modifier->boundingBox($this->getTextBlock($text));
    }

    protected function getTextBlock(string $text): TextBlock
    {
        return new TextBlock($text);
    }

    protected function ensureTextFitsBox(CustomTextModifier $modifier): CustomTextModifier
    {
        $this->getFinalTextBox($modifier);

        return $modifier;
    }

    protected function getFinalTextBox(CustomTextModifier &$modifier): Rectangle
    {
        $text = $this->text;
        $renderedBox = $this->getRenderedBoxForText($text, $modifier);

        while (! $this->doesTextFitInBox($renderedBox)) {
            if ($renderedBox->width() > $this->box->width()) {
                $text = wordwrap($text, intval(floor($this->box->width() / ($modifier->boxSize('M')->width() / 1.8))));
                $renderedBox = $this->getRenderedBoxForText($text, $modifier);
            }

            if ($renderedBox->height() > $this->box->height()) {
                $lines = $this->getTextBlock($text);

                if ($lines->count() > 1) {
                    $take = intval(floor($this->box->height() / $modifier->leadingInPixels()));
                    $lines = array_slice($lines->map(fn($line) => (string) $line)->toArray(), 0, $take);
                    $text = implode("\n", $lines).'...';
                }

                $renderedBox = $this->getRenderedBoxForText($text, $modifier);
            }

            $modifier = $this->generateModifier($text, $modifier->position);
        }

        return $renderedBox;
    }
}
