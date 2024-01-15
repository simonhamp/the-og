<?php

namespace SimonHamp\TheOg\Layout;

use Closure;
use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\ImageInterface;
use SimonHamp\TheOg\Interfaces\Box as BoxInterface;

class Box implements BoxInterface
{
    public Position $anchor;

    public Rectangle $box;

    public readonly string $name;

    public readonly Rectangle $renderedBox;

    public readonly Point $position;

    /**
     * @var Closure<Box>
     */
    public readonly Closure $relativeTo;

    public function box(int|float $width, int|float $height): self
    {
        $this->box = new Rectangle(intval(floor($width)), intval(floor($height)));
        return $this;
    }

    /**
     * Where this box should be rendered on the canvas
     */
    public function position(
        int $x,
        int $y,
        ?callable $relativeTo = null,
        Position $anchor = Position::TopLeft
    ): self
    {
        $this->position = new Point($x, $y);

        if ($relativeTo) {
            $this->relativeTo = $relativeTo;
        }

        $this->anchor = $anchor;

        return $this;
    }

    public function calculatePosition(): Point
    {
        if (isset($this->relativeTo)) {
            $origin = ($this->relativeTo)();

            if (! $origin instanceof Point) {
                // new Point()
                throw new \InvalidArgumentException(
                    'The relativeTo callback must return an instance of '.Point::class
                );
            }

            return new Point(
                $origin->x() + $this->position->x() - $this->anchorOffset()->x(),
                $origin->y() + $this->position->y() - $this->anchorOffset()->y()
            );
        }

        return $this->position
            ->moveX(-$this->anchorOffset()->x())
            ->moveY(-$this->anchorOffset()->y());
    }

    /**
     * Get the absolute Point on the canvas for a given anchor position on the current box.
     */
    public function anchor(?Position $position = null): Point
    {
        if (! $position) {
            $position = $this->anchor;
        }

        $origin = $this->calculatePosition();

        $anchor = $this->anchorOffset($position);

        return new Point($origin->x() + $anchor->x(), $origin->y() + $anchor->y());
    }

    protected function anchorOffset(?Position $position = null): Point
    {
        if (! $position) {
            $position = $this->anchor;
        }

        // We can check pre-rendered boxes here because we know that we don't need the absolute position of the box yet
        $box = $this->getPrerenderedBox() ?? $this->getRenderedBox();

        $coordinates = match ($position) {
            Position::BottomLeft => [0, $box->height()],
            Position::BottomRight => [$box->width(), $box->height()],
            Position::Center => [
                intval(floor($box->width() / 2)),
                intval(floor($box->height() / 2))
            ],
            Position::MiddleBottom => [
                intval(floor($box->width() / 2)),
                $box->height()
            ],
            Position::MiddleLeft => [0, intval(floor($box->height() / 2))],
            Position::MiddleRight => [
                $box->width(),
                intval(floor($box->height() / 2))
            ],
            Position::MiddleTop => [intval(floor($box->width() / 2)), 0],
            Position::TopLeft => [0, 0],
            Position::TopRight => [$box->width(), 0]
        };

        return new Point(...$coordinates);
    }

    protected function getRenderedBox(): Rectangle
    {
        return $this->renderedBox ?? $this->box;
    }

    /**
     * Get the box that will be rendered without calculating its position on the canvas.
     */
    protected function getPrerenderedBox(): ?Rectangle
    {
        return null;
    }

    protected function setRenderedBox(Rectangle $box): self
    {
        $this->renderedBox = $box;
        return $this;
    }

    public function render(ImageInterface $image): void
    {
        $position = $this->calculatePosition();

        $this->box->setBackgroundColor('orange');
        $this->box->setBorder('red');
        $this->box->setPivot($position);

        $image->drawRectangle(
            $position->x(),
            $position->y(),
            $this->box,
        );
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }
}
