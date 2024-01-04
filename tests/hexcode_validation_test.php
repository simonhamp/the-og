<?php

use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Background;

include_once __DIR__.'/../vendor/autoload.php';

try {
    (new Image())
    ->accentColor('#invalid')
    ->border()
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->background(Background::JustWaves, 0.2)
    ->save(__DIR__.'/test.png');
} catch (Exception $e) {
    if ($e->getMessage() === 'Hex code is not valid') {
        echo 'Hex code validation works';
        exit(0);
    }
}

