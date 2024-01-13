<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Interfaces\ImageInterface;

interface Box
{
    public function name(string $name): static;

    public function getName(): ?string;

    public function render(ImageInterface $image): void;
}
