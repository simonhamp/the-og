<?php

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use SimonHamp\TheOg\Background as BuiltInBackground;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Layout\Layouts\Avatar;
use SimonHamp\TheOg\Layout\Layouts\GitHubBasic;
use SimonHamp\TheOg\Layout\Layouts\TwoUp;
use SimonHamp\TheOg\Theme;
use SimonHamp\TheOg\Theme\Background;
use SimonHamp\TheOg\Theme\BackgroundPlacement;
use SimonHamp\TheOg\Theme\Fonts\Inter;
use SimonHamp\TheOg\Theme\Fonts\RobotoSlab;
use SimonHamp\TheOg\Theme\Theme as BaseTheme;
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
        yield 'test layout' => [
            (new Image())->layout(new TestLayout()),
            'test-layout',
        ];

        yield 'basic' => [
            (new Image())
                ->title('Just a standard og:image for a blog post with a simple title'),
            'basic',
        ];

        yield 'more text features' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words'),
            'more-text-features',
        ];

        yield 'with watermark' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->watermark(__DIR__.'/../resources/logo.png'),
            'with-watermark',
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
                ->background(BuiltInBackground::JustWaves, 0.2),
            'override-some-elements',
        ];

        yield 'background stretched to cover' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('A basic title')
                ->border(BorderPosition::X)
                ->background(BuiltInBackground::Bananas, 0.2, BackgroundPlacement::Cover),
            'background-cover',
        ];

        yield 'basic with background url' => [
            (new Image())
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->background(new Background('https://placehold.co/600x400.png', 0.2)),
            'basic-with-background-url',
        ];

        yield 'different theme with background url' => [
            (new Image())
                ->theme(Theme::Dark)
                ->url('https://example.com/blog/some-blog-post-url')
                ->title('Some blog post title that is quite big and quite long')
                ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
                ->background(new Background('https://placehold.co/600x400.png', 0.2)),
            'different-theme-with-background-url',
        ];

        yield 'github layout' => [
            (new Image())
                ->layout(new GitHubBasic)
                ->url('username/repo')
                ->title('An awesome package')
                ->background(BuiltInBackground::CloudyDay, 0.8)
                ->watermark(__DIR__.'/../resources/logo.png'),
            'githubbasic-layout',
        ];

        yield 'twoup layout' => [
            (new Image())
                ->layout(new TwoUp)
                ->accentColor('#cc0000')
                /**
                 * Photo by Matthew Hamilton on Unsplash
                 * @see https://unsplash.com/@thatsmrbio?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash
                 * @see https://unsplash.com/photos/unpaired-red-adidas-sneaker-pO2bglTMJpo?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash
                 */
                ->picture(__DIR__.'/../resources/product.jpg')
                ->url('https://my-ecommerce-store.com/')
                ->title('This layout is great for eCommerce!')
                ->callToAction('Buy Now →')
                ->background(BuiltInBackground::CloudyDay, 0.8)
                ->watermark(__DIR__.'/../resources/logo.png'),
            'twoup-layout',
        ];

        yield 'twoup dark' => [
            (new Image())
                ->layout(new TwoUp)
                ->theme(Theme::Dark)
                ->accentColor('#c33')
                /**
                 * Photo by Matthew Hamilton on Unsplash
                 * @see https://unsplash.com/@thatsmrbio?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash
                 * @see https://unsplash.com/photos/unpaired-red-adidas-sneaker-pO2bglTMJpo?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash
                 */
                ->picture(__DIR__.'/../resources/product.jpg')
                ->url('https://my-ecommerce-store.com/')
                ->title('This layout is great for eCommerce!')
                ->callToAction('ONLY $99!'),
            'twoup-dark',
        ];

        yield 'twoup custom theme' => [
            (new Image())
                ->layout(new TwoUp)
                ->theme(new BaseTheme(
                    accentColor: 'pink',
                    baseFont: Inter::regular(),
                    baseColor: '#333',
                    backgroundColor: 'white',
                    background: BuiltInBackground::GridMe->load(),
                    callToActionFont: Inter::black(),
                    titleFont: RobotoSlab::black()
                ))
                ->accentColor('#c33')
                /**
                 * Photo by Matthew Hamilton on Unsplash
                 * @see https://unsplash.com/@thatsmrbio?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash
                 * @see https://unsplash.com/photos/unpaired-red-adidas-sneaker-pO2bglTMJpo?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash
                 */
                ->picture(__DIR__.'/../resources/product.jpg')
                ->url('https://my-sneaker-store.com/')
                ->title('The brightest pair of sneakers you ever did see')
                ->callToAction('ONLY $99!'),
            'twoup-custom-theme',
        ];

        yield 'avatar layout' => [
            (new Image())
                ->layout(new Avatar)
                ->accentColor('#003')
                ->picture('https://i.pravatar.cc/300?img=10')
                ->title('Simone Hampstead')
                ->watermark(__DIR__.'/../resources/wide-logo.png'),
            'avatar-layout',
        ];
    }
}
