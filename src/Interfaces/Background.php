<?php

namespace SimonHamp\TheOg\Interfaces;

use SimonHamp\TheOg\Theme\BackgroundPlacement;

interface Background
{
    public function isUrl(): bool;

    public function opacity(): float;

    public function setOpacity(float $opacity): static;

    public function path(): string;

    public function setPath(string $path): static;

    public function placement(): BackgroundPlacement;

    public function setPlacement(BackgroundPlacement $placement): static;
}
