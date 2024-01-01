<?php

namespace SimonHamp\TheOg;

class Border
{
    protected BorderPosition $position;
    protected int $width = 10;
    
    public function position(BorderPosition $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getPosition(): BorderPosition
    {
        return $this->position;
    }

    public function width(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }
}
