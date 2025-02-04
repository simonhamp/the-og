<?php

namespace SimonHamp\TheOg\Layout;

use Closure;
use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\SizeInterface;
use InvalidArgumentException;
use SimonHamp\TheOg\Interfaces\Box as BoxInterface;
use SimonHamp\TheOg\Layout\Concerns\InteractsWithCanvas;

class Box implements BoxInterface
{
    use InteractsWithCanvas;

    public Position $anchor;

    public Rectangle $box;

    public string $name;

    public Rectangle $renderedBox;

    public Point $position;

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
     * Where this box should be rendered on the canvas.
     *
     * @param int       $x
     * @param int       $y
     * @param ?callable $relativeTo
     * @param Position  $anchor
     */
    public function position(
        int $x,
        int $y,
        ?callable $relativeTo = null,
        Position $anchor = Position::TopLeft,
    ): self {
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
                throw new InvalidArgumentException(
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
     *
     * @param ?Position $position
     * @param mixed     $driver
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
        if (is_null($position)) {
            $position = $this->anchor;
        }

        $dimensions = $this->dimensions();

        $coordinates = match ($position) {
            Position::BottomLeft => [0, $dimensions->height()],
            Position::BottomRight => [$dimensions->width(), $dimensions->height()],
            Position::Center => [
                intval(floor($dimensions->width() / 2)),
                intval(floor($dimensions->height() / 2)),
            ],
            Position::MiddleBottom => [
                intval(floor($dimensions->width() / 2)),
                $dimensions->height(),
            ],
            Position::MiddleLeft => [0, intval(floor($dimensions->height() / 2))],
            Position::MiddleRight => [
                $dimensions->width(),
                intval(floor($dimensions->height() / 2)),
            ],
            Position::MiddleTop => [intval(floor($dimensions->width() / 2)), 0],
            Position::TopLeft => [0, 0],
            Position::TopRight => [$dimensions->width(), 0],
        };

        return new Point(...$coordinates);
    }

    /**
     * Get the box that will be rendered without calculating its position on the canvas.
     *
     * @return SizeInterface
     */
    public function dimensions(): SizeInterface
    {
        return $this->box;
    }

    public function render(): void
    {
        $position = $this->calculatePosition();

        $this->box->setBackgroundColor('orange');
        $this->box->setBorder('red');
        $this->box->setPivot($position);

        $this->canvas()->drawRectangle(
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
