<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Interfaces\ImageInterface;

interface Box
{
    public function render(ImageInterface $image): void;
}
