<?php

use SimonHamp\TheOg\Image;

include_once __DIR__.'/../vendor/autoload.php';

(new Image())
    ->accentColor('#cc0000')
    ->border()
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->backgroundURL('https://www.goodfreephotos.com/albums/animals/mammals/african-bush-elephant-loxodonta-africana.jpg', 0.2) // CC0 licensed image from https://www.goodfreephotos.com/
    ->save(__DIR__.'/test_background_url.png');
