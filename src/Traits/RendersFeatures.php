<?php

namespace SimonHamp\TheOg\Traits;

use Imagick;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ImageManagerInterface;
use InvalidArgumentException;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Image as Config;
use SimonHamp\TheOg\Interfaces\Background;
use SimonHamp\TheOg\Theme\BackgroundPlacement;

trait RendersFeatures
{
    protected Config $config;
    protected ImageInterface $canvas;
    protected ImageManagerInterface $manager;

    public function render(Config $config): ImageInterface
    {
        $this->config = $config;

        $this->manager = ImageManager::usingDriver(ImagickDriver::class);

        $this->canvas = $this->manager->createImage($this->width, $this->height)
            ->fill($this->config->theme->getBackgroundColor());

        if ($this->config->theme->getBackground() instanceof Background) {
            $this->renderBackground();
        }

        // Prep this layout's feature stack
        $this->features();

        // Loop over the stack of features and render each to the canvas
        // The order of the items in the stack will determine the order in which they are rendered and thus their
        // 'layering' on the canvas: earlier elements will be rendered 'underneath' later elements.
        foreach ($this->features as $feature) {
            $feature->render();
        }

        if (! isset($this->border)) {
            $this->border(
                (new Border())
                    ->position($this->borderPosition)
                    ->color($this->config->theme->getBorderColor())
                    ->width($this->borderWidth)
            );
        }

        $this->renderBorder();

        return $this->canvas;
    }

    protected function renderBorder(): void
    {
        match ($this->border->getPosition()) {
            BorderPosition::All => $this->renderBorderLeft() || $this->renderBorderRight() || $this->renderBorderTop() || $this->renderBorderBottom(),
            BorderPosition::Bottom => $this->renderBorderBottom(),
            BorderPosition::Left => $this->renderBorderLeft(),
            BorderPosition::Right => $this->renderBorderRight(),
            BorderPosition::Top => $this->renderBorderTop(),
            BorderPosition::X => $this->renderBorderTop() || $this->renderBorderBottom(),
            BorderPosition::Y => $this->renderBorderLeft() || $this->renderBorderRight(),
            default => null,
        };
    }

    protected function renderBorderLeft(): void
    {
        $this->canvas->drawRectangle(
            $this->verticalAccentedRectangle()->adjust(
                fn(RectangleFactory $rectangle) => $rectangle->at(0, 0)
            )
        );
    }

    protected function renderBorderRight(): void
    {
        $this->canvas->drawRectangle(
            $this->verticalAccentedRectangle()->adjust(
                fn(RectangleFactory $rectangle) => $rectangle->at($this->width - $this->border->getWidth(), 0)
            )
        );
    }

    protected function renderBorderTop(): void
    {
        $this->canvas->drawRectangle(
            $this->horizontalAccentedRectangle()->adjust(
                fn(RectangleFactory $rectangle) => $rectangle->at(0, 0)
            )
        );
    }

    protected function renderBorderBottom(): void
    {
        $this->canvas->drawRectangle(
            $this->horizontalAccentedRectangle()->adjust(
                fn(RectangleFactory $rectangle) => $rectangle->at(0, $this->height - $this->border->getWidth())
            )
        );
    }

    protected function verticalAccentedRectangle(): Rectangle
    {
        return RectangleFactory::build(function ($rectangle) {
            $rectangle->size($this->border->getWidth(), $this->height);
            $rectangle->background($this->border->getColor());
        });
    }

    protected function horizontalAccentedRectangle(): Rectangle
    {
        return RectangleFactory::build(function ($rectangle) {
            $rectangle->size($this->width, $this->border->getWidth());
            $rectangle->background($this->border->getColor());
        });
    }

    /**
     * Repeats the supplied background image across the canvas.
     */
    protected function renderBackground(): void
    {
        $background = $this->config->theme->getBackground();

        $path = $background->path();

        if ($background->isUrl()) {
            $imageInfo = @getimagesize($path);

            if (! $imageInfo) {
                throw new InvalidArgumentException('Background URL provided is invalid');
            }

            $data = file_get_contents($path);
        }

        $panel = $this->manager->decode($data ?? $path);

        $imagick = $panel->core()->native();

        $imagick->setImageVirtualPixelMethod(1);
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);

        $imagick->evaluateImage(
            Imagick::EVALUATE_MULTIPLY,
            $background->opacity(),
            Imagick::CHANNEL_ALPHA
        );

        match ($background->placement()) {
            BackgroundPlacement::Repeat => $this->renderBackgroundRepeat($panel),
            BackgroundPlacement::Cover => $this->renderBackgroundCover($panel),
            default => null,
        };
    }

    protected function renderBackgroundRepeat(ImageInterface $panel): void
    {
        $width = $panel->width();
        $height = $panel->height();

        $columns = ceil($this->width / $width);
        $rows = ceil($this->height / $height);

        $filledRows = 0;

        while ($filledRows <= $rows) {
            $filledColumns = 0;

            while ($filledColumns <= $columns) {
                $this->canvas->insert(
                    image: $panel,
                    x: $filledColumns * $width,
                    y: $filledRows * $height,
                );

                ++$filledColumns;
            }

            ++$filledRows;
        }
    }

    /**
     * Resizes the background image to cover the canvas.
     *
     * @param ImageInterface $panel
     */
    protected function renderBackgroundCover(ImageInterface $panel): void
    {
        $this->canvas->insert($panel->cover($this->width, $this->height));
    }
}
