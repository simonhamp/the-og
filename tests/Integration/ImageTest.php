<?php

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Layout\Layouts\GitHubBasic;
use SimonHamp\TheOg\Theme\Theme;
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
                ->theme(Theme::Dark)
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
                ->background(Background::JustWaves, 0.2),
            'override-some-elements',
        ];

        yield 'basic with background url' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->backgroundUrl('https://placehold.co/600x400.png', 0.2),
            'basic-with-background-url',
        ];

        yield 'different theme with background url' => [
            (new Image())
                ->theme(Theme::Dark)
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->backgroundUrl('https://placehold.co/600x400.png', 0.2),
            'different-theme-with-background-url',
        ];

        yield 'github layout' => [
            (new Image())
                ->layout(new GitHubBasic)
                ->url('username/repo')
                ->title('An awesome package')
                ->background(Background::CloudyDay, 0.8),
            'githubbasic-layout',
        ];
    }
}
