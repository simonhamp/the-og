<?php

namespace SimonHamp\TheOg\Layout\Concerns;

trait HasAlignment
{
    public string $hAlign;
    public string $vAlign;

    public function hAlign(string $hAlign): self
    {
        $this->hAlign = $hAlign;

        return $this;
    }

    public function vAlign(string $vAlign): self
    {
        $this->vAlign = $vAlign;

        return $this;
    }
}
