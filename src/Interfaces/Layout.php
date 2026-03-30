<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Interfaces\ImageInterface;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\Image as Config;
use SimonHamp\TheOg\Theme\Picture;

interface Layout
{
    public function border(Border $border): self;

    public function callToAction(): ?string;

    public function description(): ?string;

    public function features(): void;

    public function picture(): ?Picture;

    public function render(Config $config): ImageInterface;

    public function title(): string;

    public function url(): ?string;

    public function watermark(): ?Picture;
}
