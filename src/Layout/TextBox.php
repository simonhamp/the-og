<?php

namespace SimonHamp\TheOg\Layout;

use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\FontInterface;
use Intervention\Image\Interfaces\ModifierInterface;
use Intervention\Image\Interfaces\SizeInterface;
use Intervention\Image\Modifiers\TextModifier;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Typography\TextBlock;
use SimonHamp\TheOg\Layout\Concerns\HasAlignment;
use SimonHamp\TheOg\Layout\Concerns\HasText;
use SimonHamp\TheOg\Modifiers\TextModifier as CustomTextModifier;

class TextBox extends Box
{
    use HasText;
    use HasAlignment;

    public function render(): void
    {
        $modifier = $this->modifier($this->text);
        $modifier->position = $this->calculatePosition();

        $this->canvas()->modify($modifier);
    }

    public function dimensions(): SizeInterface
    {
        $driver = $this->canvas()->driver();

        $modifier = $this->modifier($this->text, new Point());

        $font = $modifier->font;
        $block = $driver->fontProcessor()->textBlock($this->text, $modifier->font, new Point());

        return new Rectangle(
            $driver->fontProcessor()->boxSize((string) $block->longestLine(), $font)->width(),
            $driver->fontProcessor()->leading($modifier->font) * ($block->count() - 1) + $driver->fontProcessor()->capHeight($modifier->font)
        );

        return $driver->fontProcessor()->boxSize($this->text, $modifier->font);
    }

    protected function generateFont(): FontInterface
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

    public function modifier(string $text): ModifierInterface
    {
        return new TextModifier(
            text: $text,
            position: new Point(),
            font: $this->generateFont()
        );
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

    protected function doesTextFitInBox(Rectangle $renderedBox): bool
    {
        return true;

        return $renderedBox->fitsInto($this->box);
    }

    protected function getFinalTextBox(CustomTextModifier &$modifier): Rectangle
    {
        dd('hit');

        $text = $this->text;
        $renderedBox = $this->getRenderedBoxForText($text, $modifier);

        $attempts = 0;

        while (! $this->doesTextFitInBox($renderedBox) && $attempts < 10) {
            if ($renderedBox->width() > $this->box->width()) {
                $text = wordwrap($text, intval(floor($this->box->width() / ($modifier->boxSize('M', $this->font)->width() / 1.8))));
                $renderedBox = $this->getRenderedBoxForText($text, $modifier);
            }

            if ($renderedBox->height() > $this->box->height()) {
                $lines = $this->getTextBlock($text);

                if ($lines->count() > 1) {
                    $take = intval(floor($this->box->height() / $modifier->leadingInPixels()));
                    $lines = array_slice($lines->map(fn ($line) => (string) $line)->toArray(), 0, $take);
                    $text = implode("\n", $lines).'...';
                }

                $renderedBox = $this->getRenderedBoxForText($text, $modifier);
            }

            $modifier = $this->modifier($text, $modifier->position);

            ++$attempts;
        }

        return $renderedBox;
    }
}
