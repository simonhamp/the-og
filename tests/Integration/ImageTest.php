<?php

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use SimonHamp\TheOg\Backgrounds\JustWaves;
use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Themes\Themes;
use Spatie\Snapshots\MatchesSnapshots;

class ImageTest extends IntegrationTestCase
{
    use MatchesSnapshots;

    #[DataProvider('snapshotImages')]
    public function test_basic_image(Image $image, string $name): void
    {
        $path = self::TESTCASE_DIRECTORY.'/'.$name.'.png';

        $image->save($path);

        $this->assertMatchesImageSnapshot($path);
    }

    public static function snapshotImages(): iterable
    {
        yield 'basic' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words'),
            'basic',
        ];

        yield 'different theme' => [
            (new Image())
                ->theme(Themes::Dark)
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words'),
            'different-theme',
        ];

        yield 'override some elements' => [
            (new Image())
                ->accentColor('#cc0000')
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description(<<<'TEXT'
        Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words.

        Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words.
        TEXT
                )
                ->background(new JustWaves(), 0.2),
            'override-some-elements',
        ];

        yield 'basic with background url' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->backgroundUrl('https://www.goodfreephotos.com/albums/animals/mammals/african-bush-elephant-loxodonta-africana.jpg', 0.2),
            'basic-with-background-url',
        ];

        yield 'different theme with background url' => [
            (new Image())
                ->theme(Themes::Dark)
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->backgroundUrl('https://www.goodfreephotos.com/albums/animals/mammals/african-bush-elephant-loxodonta-africana.jpg', 0.2),
            'different-theme-with-background-url',
        ];
    }
}
