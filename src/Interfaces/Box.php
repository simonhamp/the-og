<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\PointInterface;
use Intervention\Image\Interfaces\SizeInterface;
use SimonHamp\TheOg\Layout\Position;

interface Box
{
    public function setCanvas(ImageInterface $canvas): static;

    public function anchor(?Position $position = null): PointInterface;

    public function name(string $name): static;

    public function getName(): ?string;

    public function dimensions(): SizeInterface;

    public function render(): void;
}
