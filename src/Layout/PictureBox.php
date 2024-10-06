<?php

namespace SimonHamp\TheOg\Layout;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use SimonHamp\TheOg\Theme\PicturePlacement;

class PictureBox extends Box
{
    /**
     * @var array<callable<Imagick>>
     */
    public array $maskQueue;

    public string $path;

    public PicturePlacement $placement = PicturePlacement::Natural;

    protected ImageInterface $picture;

    public function render(ImageInterface $image): void
    {
        if (! empty($this->maskQueue)) {
            foreach ($this->maskQueue as $mask) {
                $this->mask($mask());
            }
        }

        $position = $this->calculatePosition();

        $image->place(
            element: $this->getPicture(),
            offset_x: $position->x(),
            offset_y: $position->y()
        );
    }

     /**
      * Apply a mask image to the picture
      */
    public function mask(Imagick $mask): void
    {
        $base = $this->getPicture()->core()->native();

        $base->setImageMatte(true);

        $base->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0);
    }

    public function circle(): static
    {
        $this->maskQueue[] = function () {
            $width = $this->getPrerenderedBox()->width();
            $start = intval(floor($width / 2));

            // Create the circle
            $circle = new ImagickDraw();
            $circle->setFillColor(new ImagickPixel('#fff'));
            $circle->circle($start, $start, $start, $width - 10);

            // Draw it to an Imagick instance
            $image = new Imagick();
            $image->newImage($width, $width, 'none', 'png');
            $image->setImageMatte(true);
            $image->drawImage($circle);

            return $image;
        };

        return $this;
    }

    public function path(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function placement(PicturePlacement $placement): static
    {
        $this->placement = $placement;
        return $this;
    }

    protected function getPicture(): ImageInterface
    {
        $this->picture ??= ImageManager::imagick()
            ->read(file_get_contents($this->path));

        match ($this->placement) {
            PicturePlacement::Cover => $this->picture->cover($this->box->width(), $this->box->height()),
            PicturePlacement::Natural => $this->picture->scaleDown($this->box->width(), $this->box->height()),
        };

        return $this->picture;
    }

    protected function getPrerenderedBox(): Rectangle|null
    {
        return $this->getPicture()->size();
    }
}
