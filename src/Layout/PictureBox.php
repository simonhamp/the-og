<?php

namespace SimonHamp\TheOg\Layout;

use Intervention\Image\Drivers\Imagick\Modifiers\PlaceModifier;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

readonly class PictureBox extends Box
{
    public string $path;

    public function render(ImageInterface $image): void
    {
        $picture = ImageManager::imagick()
            ->read(file_get_contents($this->path))
            ->cover($this->box->width(), $this->box->height());

        $image->place($picture);
    }

    public function path(string $path): self
    {
        $this->path = $path;
        return $this;
    }
}
