<?php

use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Theme\Theme;

include_once __DIR__.'/../vendor/autoload.php';

// Basic
(new Image())
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->save(__DIR__.'/test1.png');

// Different theme
(new Image())
    ->theme(Theme::Dark)
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->save(__DIR__.'/test2.png');

// Override some elements
(new Image())
    ->accentColor('#cc0000')
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description(<<<'TEXT'
        Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words.

        Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words.
        TEXT)
    ->background(Background::JustWaves, 0.2)
    ->save(__DIR__.'/test3.png');

// Basic with BackgroundUrl
(new Image())
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->backgroundUrl('https://www.goodfreephotos.com/albums/animals/mammals/african-bush-elephant-loxodonta-africana.jpg', 0.2)
    ->save(__DIR__ . '/test4.png');

// Different theme with BackgroundUrl
(new Image())
    ->theme(Theme::Dark)
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->backgroundUrl('https://www.goodfreephotos.com/albums/animals/mammals/african-bush-elephant-loxodonta-africana.jpg', 0.2)
    ->save(__DIR__ . '/test5.png');
