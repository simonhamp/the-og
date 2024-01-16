<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Image;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\Image as Config;
use SimonHamp\TheOg\Layout\TextBox;
use SimonHamp\TheOg\Theme\Picture;

interface Layout
{
    public function border(Border $border): self;

    public function callToAction(): ?string;

    public function description(): ?string;

    public function features(): void;

    public function picture(): ?Picture;

    public function render(Config $config): Image;

    public function title(): string;

    public function url(): ?string;

    public function watermark(): ?Picture;
}
