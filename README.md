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

[Laradir](https://laradir.com/?ref=the-og-github) - Connecting the best Laravel Developers with the best Laravel Teams

## Installation

Install via Composer:

```shell
composer require simonhamp/the-og --with-all-dependencies
```

## Usage

Using The OG is really simple. Here's a basic example:

```php
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Image;

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

The [`Image` class](https://github.com/simonhamp/the-og/blob/main/src/Image.php) provides an elegant and fluent API for
configuring the content, style and layout of your image, as well as helpers to render the image and save it to a file.

### Colors

Throughout The OG, colors can be expressed as hex codes, rgba, or HTML named colors.

### Borders

Borders provide a subtle variation of color and texture to your image by framing one, or multiple edges of the image
with a single band of color—usually the theme's `accentColor`.

Borders are usually defined as part of the theme, but you can override the border position, color and size on the image
itself:

```php
use SimonHamp\TheOg\BorderPosition;

$image = new Image;
$image->border(BorderPosition::Top, 'pink', 10);
```

The available border positions are:

- `BorderPosition::All` - All 4 edges will be bordered
- `BorderPosition::Bottom` - The bottom edge will be bordered
- `BorderPosition::Left` - The left edge will be bordered
- `BorderPosition::Right` - The right edge will be bordered
- `BorderPosition::None` - No edges will be bordered
- `BorderPosition::Top` - The top edge will be bordered
- `BorderPosition::X` - Combines `BorderPosition::Top` and `BorderPosition::Bottom`
- `BorderPosition::Y` - Combines `BorderPosition::Left` and `BorderPosition::Right`


#### Removing default borders

You can remove the default border from the image by chaining the `border()` method with the `position` argument set to
`BorderPosition::None`:

```php
$image = new Image;
$image->border(BorderPosition::None);
```

### Themes

Themes set the colors, fonts, and styles for your image. There are currently 2 themes available:
`Light` and `Dark`.

The default theme is `Light`.

You can set the theme on your image at any point before it's rendered:

```php
use SimonHamp\TheOg\Theme\Theme;

$image = new Image;
$image->theme(Theme::Dark);
```

#### Creating themes

Themes are simple classes that implement the
[`Theme` interface](https://github.com/simonhamp/the-og/blob/main/src/Interfaces/Theme.php).

However, you can create your own theme most easily by simply extending the
[`AbstractTheme` class](https://github.com/simonhamp/the-og/blob/main/src/Theme/AbstractTheme.php).

You can even do this with an anonymous class to save creating a whole new file:

```php
use SimonHamp\TheOg\Theme\Fonts\Inter;
use SimonHamp\TheOg\Theme\AbstractTheme;

$theme = new class(
    accentColor: '#247BA0',
    backgroundColor: '#ECEBE4',
    baseColor: '#153B50',
    baseFont: Inter::bold(),
    callToActionBackgroundColor: '#153B50',
    callToActionColor: '#ECEBE4',
    descriptionColor: '#429EA6',
    descriptionFont: Inter::light(),
    titleFont: Inter::black(),
) extends AbstractTheme {};

$image = new Image;
$image->theme($theme);
```

#### Fonts

Currently, there is only 1 font available (with 4 variants):
[`Inter`](https://github.com/simonhamp/the-og/blob/main/src/Theme/Fonts/Inter.php).

More fonts are coming soon!

#### Custom fonts

You can load custom fonts by creating a class that implements the
[`Font` interface](https://github.com/simonhamp/the-og/blob/main/src/Interfaces/Font.php):

```php
use SimonHamp\TheOg\Interfaces\Font;

class CustomFont implements Font
{
    public function path(string $path): string
    {
        return '/path/to/your/font/source/file.ttf';
    }
}
```

Then you can load this font when defining your theme:

```php
$font = new CustomFont;

$theme = new class(
    baseFont: $font,
) extends AbstractTheme {};
```

#### Custom background images

If the built-in background patterns don't tickle your fancy, you can load your own simply by instantiating the
[`Background` class](https://github.com/simonhamp/the-og/blob/main/src/Theme/Background.php):

```php
use SimonHamp\TheOg\Theme\Background;

$background = new Background('/path/to/your/image.png');
```

Then you can pass the background to your custom theme, or directly to your image:

```php
$theme = new class(
    background: $background,
) extends AbstractTheme {};

$image = (new Image)->theme($theme);

// Or

$image->background($background);
```

If you want more customization of the background, you may create your own background classes that implement the
[`Background` interface](https://github.com/simonhamp/the-og/blob/main/src/Interfaces/Background.php).

#### Overriding theme settings

You can override some theme settings, such as the accent color, background and background color, without having to
create a whole new theme.

```php
$image = new Image;
$image->backgroundColor('seagreen')
    ->background($customBackground);
```

### Layouts

While themes govern the colors and styles used within your images, layouts govern size of your images and the size and
position of the image's elements (text blocks, other images etc), called **Features**.

There are currently 2 layouts:
[`Standard`](https://github.com/simonhamp/the-og/blob/main/src/Layout/Layouts/Standard.php)
and [`GitHubBasic`](https://github.com/simonhamp/the-og/blob/main/src/Layout/Layouts/GitHubBasic.php).

The default layout is `Standard`.

More layouts are coming.

#### Creating layouts

Layout classes are usually a simple class with some basic settings values.

[Take a look at the Standard layout](https://github.com/simonhamp/the-og/blob/main/src/Layout/Layouts/Standard.php) as
an example.

In it you'll see the basic settings for the layout, such as the dimensions of the canvas, the border size and location,
and any padding.

**All sizes are in pixels.**

Each layout class must implement the
[`Layout` interface](https://github.com/simonhamp/the-og/blob/main/src/Interfaces/Layout.php)

#### Creating features

Features are the individual elements that make up your image, such as the Title, Description, URL, Border, Background
and more.

Different layouts will provide different features, so not all features will be available. At a minimum, a layout should
provide a Title feature so that at least one block of text can be rendered on the image.

### Storing the image elsewhere

If you prefer to store your image somewhere other than the local filesystem (e.g. storing it on Amazon S3) you can use
the `toString()` method.

`toString()` will return the rendered image as a binary string:

```php
$image = (new Image())->toString();

// $service here could be an AWS\S3\S3Client, for example
$service->putObject([
    'Key' => 'example-image.png',
    'Body' => $image,
    'ContentType' => 'image/png',
]);
```

This will send the raw binary data directly to the external service without needing to write the image to a file on the
local disk first.

## Testing

The OG uses PHPUnit with [snapshot testing](https://github.com/spatie/phpunit-snapshot-assertions).

To run the integration tests, you need to install all Composer dependencies:

```shell
composer install
```

You will also need [NodeJS](https://nodejs.org/en) (version 20 or above) and to install the NPM dependencies:

```shell
npm install
```

Once done, you can execute the tests:

```shell
./vendor/bin/phpunit
```

## Contributing

I'd really appreciate and welcome any PRs to help improve this package!

<!-- Please see [CONTRIBUTING](CONTRIBUTING.md) for details. -->

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more details.
