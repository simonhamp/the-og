<?php

namespace SimonHamp\TheOg\Interfaces;

use Intervention\Image\Image;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\Image as Config;
use SimonHamp\TheOg\Layout\TextBox;

interface Layout
{
    public function border(Border $border): self;

    public function render(Config $config): Image;

    public function getCallToAction(): TextBox;

    public function getDescription(): TextBox;

    public function getTitle(): TextBox;

    public function getUrl(): TextBox;
}
