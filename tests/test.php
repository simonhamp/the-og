<?php

use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Themes\Themes;

include_once __DIR__.'/../vendor/autoload.php';

// Basic
(new Image())
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->save(__DIR__.'/test1.png');

// Different theme
(new Image())
    ->theme(Themes::Dark)
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->save(__DIR__.'/test2.png');

// Override some elements
(new Image())
    ->accentColor('#cc0000')
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->background(Background::JustWaves, 0.2)
    ->save(__DIR__.'/test3.png');
