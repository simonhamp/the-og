![](https://github.com/simonhamp/the-og/blob/main/thumbnail.png?raw=true)

# The OG

An OpenGraph image generator written purely in PHP, so you don't need to install another runtime somewhere
or a whole browser instance just to create a dynamic PNG.

## Sponsorship
The OG is completely free to use for personal or commercial use. If it's making your job easier or you just want to
make sure it keeps being supported and improved, I'd really appreciate your donations!

[Donate now via GitHub Sponsors](https://github.com/sponsors/simonhamp)

Thank you 🙏

## Sponsors

[Laradir](https://laradir.com/?ref=laravel-nov-csv-import-github) - Connecting the best Laravel Developers with the best Laravel Teams

## Installation

Install via Composer:

```shell
composer require simonhamp/the-og --with-all-dependencies
```

## Usage

Using The OG is really simple. Here's a basic example:

```php
use SimonHamp\TheOg\Image;
use SimonHamp\TheOg\Background;

(new Image())
    ->accentColor('#cc0000')
    ->border()
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->background(Background::JustWaves, 0.2)
    ->save(__DIR__.'/test.png');
```

And here's the image that generates:

![](https://github.com/simonhamp/the-og/blob/main/tests/Integration/__snapshots__/ImageTest__test_basic_image%20with%20data%20set%20override%20some%20elements__1.png)

#### Storing the image elsewhere

If you don't have filesystem access or you'd just like to directly store your image on a storage service like Amazon S3 you can do so by using `toString()`.
`toString()` will return the encoded image object as a string.

Here's an example of uploading your image to an S3 compatible storage service:

```php
use Aws\S3\S3Client;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Image;

$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'auto',
    'credentials' => [
        'key' => 'your-access-key',
        'secret' => 'your-secret-key',
    ],
    'endpoint' => 'your-s3-compatible-endpoint',
]);

$bucketName = 'og-test-bucket';

$image = (new Image())
    ->accentColor('#cc0000')
    ->border()
    ->url('https://example.com/blog/some-blog-post-url')
    ->title('Some blog post title that is quite big and quite long')
    ->description('Some slightly smaller but potentially much longer subtext. It could be really long so we might need to trim it completely after many words')
    ->background(Background::JustWaves, 0.2)
    ->toString();


$s3->putObject([
    'Bucket' => $bucket,
    'Key' => 'example-image.png',
    'Body' => $image,
    'ContentType' => 'image/png',
    'ACL' => 'public-read',
]);
```

The image has now been uploaded to S3 and you can serve it from your public bucket URL.

### Themes

Themes set the colors, fonts, and styles for your image. There are currently 2 themes available: `Light` and `Dark`.
The default theme is `Light`.

You can set the theme on your image at any point before it's rendered:

```php
$image = new Image;
$image->theme(Themes::Dark);
```

#### Creating themes

Themes are simple classes. You can create your own theme simply by extending the `AbstractTheme` class:

```php
use SimonHamp\TheOg\Themes\AbstractTheme;

$theme = new class(
    accentColor: '#247BA0',
    backgroundColor: '#ECEBE4',
    baseColor: '#153B50',
    baseFont: Font::InterBold,
    callToActionBackgroundColor: '#153B50',
    callToActionColor: '#ECEBE4',
    descriptionColor: '#429EA6',
    descriptionFont: Font::InterLight,
    titleFont: Font::InterBlack,
) extends AbstractTheme {};

$image = new Image;
$image->theme($theme);
```

Colors can be expressed as hex codes, rgba, or HTML named colors.

Currently, there are currently 4 fonts available, all within the Inter family. More fonts are coming soon!

#### Overriding theme settings

You can override some theme settings, such as the accent color and background color, without having to create a whole
new theme.

```php
$image = new Image;
$image->backgroundColor('seagreen');
```

### Layouts

While themes govern colors and styles, layouts govern sizing and positioning of your images and the elements within
them.

There are currently 2 layouts: `Standard` and `GitHubBasic`. `Standard` is the default.

More layouts are coming.

## Testing

The OG uses [snapshot testing](https://github.com/spatie/phpunit-snapshot-assertions). To run the integration tests, 
install [NodeJS](https://nodejs.org/en) (version 20 or above) and install the dependencies with `npm install`. Lastly, 
execute the tests with `./vendor/bin/phpunit`. 

## Contributing

I'd really appreciate and welcome any PRs to help improve this package!

<!-- Please see [CONTRIBUTING](CONTRIBUTING.md) for details. -->

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more details.
