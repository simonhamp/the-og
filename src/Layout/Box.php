<?php

namespace SimonHamp\TheOg\Layout;

use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Rectangle;

readonly class Box
{
    public Rectangle $box;
    public Position $pivot;
    public Point $position;
    public Box $relativeTo;
    public Position $relativeToPosition;
    public Rectangle $renderedBox;

    public function box(int $width, int $height): self
    {
        $this->box = new Rectangle($width, $height);
        return $this;
    }

    /**
     * Where this box should be rendered on the canvas
     */
    public function position(
        int $x,
        int $y,
        ?callable $relativeTo = null,
        Position $position = Position::TopLeft,
        Position $pivot = Position::TopLeft
    ): self
    {
        $this->position = new Point($x, $y);

        if ($relativeTo) {
            $this->relativeTo = $relativeTo();
            $this->relativeToPosition = $position;
            $this->pivot = $pivot;
        }

        return $this;
    }
    
    public function calculatePosition(): Point
    {
        if (isset($this->relativeTo)) {
            $position = $this->relativeTo->getPointForPosition($this->relativeToPosition);

            return new Point(
                $position->x() + $this->position->x(),
                $position->y() + $this->position->y()
            );
        }

        return $this->position;
    }

    public function getPointForPosition(Position $position): Point
    {
        $box = $this->getRenderedBox();
        $origin = $this->calculatePosition();

        $coordinates = match ($position) {
            Position::BottomLeft => [
                $origin->x(),
                $origin->y() + $box->height()
            ],
            Position::BottomRight => [
                $origin->x() + $box->width(),
                $origin->y() + $box->height()
            ],
            Position::Center => [
                $origin->x() + intval(floor($box->width() / 2)),
                $origin->y() + intval(floor($box->height() / 2)),
            ],
            Position::MiddleBottom => [
                $origin->x() + intval(floor($box->width() / 2)),
                $origin->y() + $box->height(),
            ],
            Position::MiddleLeft => [
                $origin->x(),
                $origin->y() + intval(floor($box->height() / 2)),
            ],
            Position::MiddleRight => [
                $origin->x() + $box->width(),
                $origin->y() + intval(floor($box->height() / 2)),
            ],
            Position::MiddleTop => [
                $origin->x() + intval(floor($box->width() / 2)),
                $origin->y(),
            ],
            Position::TopLeft => [
                $origin->x(),
                $origin->y()
            ],
            Position::TopRight => [
                $origin->x() + $box->width(),
                $origin->y()
            ]
        };

        return new Point(...$coordinates);
    }

    protected function getRenderedBox(): Rectangle
    {
        return $this->renderedBox ?? $this->box;
    }

    protected function setRenderedBox(Rectangle $box): self
    {
        $this->renderedBox = $box;
        return $this;
    }
}
