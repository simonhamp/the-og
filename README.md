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

![](https://github.com/simonhamp/the-og/blob/main/tests/test.png)

Full API documentation coming soon!

## Testing

There's a basic test script in `tests/test.php`. You can execute this directly from the command line:

```shell
php tests/test.php
```

But a more robust test suite is needed and is coming.

## Contributing

I'd really appreciate and welcome any PRs to help improve this package!

<!-- Please see [CONTRIBUTING](CONTRIBUTING.md) for details. -->

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more details.
