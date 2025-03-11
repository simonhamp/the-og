<?php

namespace SimonHamp\TheOg\Layout\Concerns;

use Intervention\Image\Interfaces\ImageInterface;

trait InteractsWithCanvas
{
    protected ImageInterface $canvas;

    public function canvas(): ImageInterface
    {
        return $this->canvas;
    }

    public function setCanvas(ImageInterface $canvas): static
    {
        $this->canvas = $canvas;

        return $this;
    }
}
