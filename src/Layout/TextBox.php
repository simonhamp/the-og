<?php

namespace SimonHamp\TheOg\Layout;

use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\ModifierInterface;
use Intervention\Image\Interfaces\SizeInterface;
use Intervention\Image\Modifiers\TextModifier;
use Intervention\Image\Typography\Line;
use Intervention\Image\Typography\TextBlock;
use SimonHamp\TheOg\Layout\Concerns\HasAlignment;
use SimonHamp\TheOg\Layout\Concerns\HasText;

class TextBox extends Box
{
    use HasText;
    use HasAlignment;

    protected ?ModifierInterface $modifier = null;

    public function render(): void
    {
        $modifier = $this->modifier($this->text);
        $modifier->position = $this->calculatePosition();

        $this->canvas()->modify(
            $this->truncateText($modifier)
        );
    }

    public function dimensions(): SizeInterface
    {
        $driver = $this->canvas()->driver();
        $modifier = $this->modifier($this->text);
        $wrappedTextBlock = $this->wrappedTextBlockForModifier($modifier);

        // Create a bounding box, see: https://github.com/Intervention/image/blob/develop/src/Drivers/AbstractFontProcessor.php#L166
        return new Rectangle(
            $driver->fontProcessor()->boxSize((string) $wrappedTextBlock->longestLine(), $modifier->font)->width(),
            $driver->fontProcessor()->leading($modifier->font) * ($wrappedTextBlock->count() - 1) + $driver->fontProcessor()->capHeight($modifier->font)
        );
    }

    public function modifier(string $text): ModifierInterface
    {
        if (! is_null($this->modifier)) {
            return $this->modifier;
        }

        $this->modifier = new TextModifier(
            text: $text,
            position: new Point(),
            font: $this->interventionFontInstance()
        );

        return $this->modifier;
    }

    protected function truncateText(ModifierInterface $modifier): ModifierInterface
    {
        $expectedHeight = $this->dimensions()->height();

        if ($expectedHeight < $this->box->height()) {
            return $modifier;
        }

        $wrappedTextBlock = $this->wrappedTextBlockForModifier($modifier);

        $lineHeight = $expectedHeight / $wrappedTextBlock->count();
        $maxLines = intval(floor($this->box->height() / $lineHeight));

        $truncatedLines = [
            ...array_slice($wrappedTextBlock->toArray(), 0, $maxLines - 1),
            $this->applyEllipsis($wrappedTextBlock->getAtPosition($maxLines - 1)),
        ];

        $modifier->text = implode("\n", $truncatedLines);

        return $modifier;
    }

    protected function applyEllipsis(Line $line): Line
    {
        return new Line(
            substr($line, 0, -3).'...',
            $line->position()
        );
    }

    protected function wrappedTextBlockForModifier(ModifierInterface $modifier): TextBlock
    {
        $driver = $this->canvas()->driver();

        return $driver->fontProcessor()->textBlock($modifier->text, $modifier->font, new Point());
    }
}
