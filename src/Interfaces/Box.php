<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Geometry\Point;
use Intervention\Image\Interfaces\ImageInterface;
use SimonHamp\TheOg\Layout\Position;

interface Box
{
    public function anchor(?Position $position): Point;

    public function name(string $name): static;

    public function getName(): ?string;

    public function render(ImageInterface $image): void;
}
