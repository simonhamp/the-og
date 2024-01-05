<?php

use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Layout\Layouts;

include_once __DIR__.'/vendor/autoload.php';

(new Image())
    ->url('simonhamp/the-og')
    ->layout(Layouts::GitHubBasic)
    ->title('An opinionated OpenGraph image generator written in pure PHP')
    ->description("No need for a third-party service, a separate serverless micro-service or installing Puppeteer everywhere just so you can generate dynamic images.\n\nIt's bananas!")
    ->background(Background::Bananas, 0.4)
    ->save(__DIR__.'/thumbnail.png');
