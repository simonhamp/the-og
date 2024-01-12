<?php

namespace SimonHamp\TheOg\Traits;

use Imagick;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Image as Config;
use SimonHamp\TheOg\Interfaces\Background;

trait RendersFeatures
{
    protected Config $config;
    protected Image $canvas;
    protected ImageManager $manager;

    public function render(Config $config): Image
    {
        $this->config = $config;

        $this->manager = ImageManager::imagick();

        $this->canvas = $this->manager->create($this->width, $this->height)
            ->fill($this->config->theme->getBackgroundColor());

        if ($this->config->theme->getBackground() instanceof Background) {
            $this->renderBackground();
        }

        if (isset($this->config->backgroundUrl) && $backgroundUrl = $this->getUrl($this->config->backgroundUrl)) {
            if (!filter_var($this->config->backgroundUrl, FILTER_VALIDATE_URL)) {
                throw new \InvalidArgumentException('URL is not valid');
            }
            $imageInfo = @getimagesize($this->config->backgroundUrl);
            if (!$imageInfo) {
                throw new \InvalidArgumentException('URL is not an image');
            }

            $this->renderBackgroundUrl();
        }

        // Loop over the stack of features and render each to the canvas
        // The order of the items in the stack will determine the order in which they are rendered and thus their
        // 'layering' on the canvas: earlier elements will be rendered 'underneath' later elements.
        $this->features();

        foreach ($this->features as $feature) {
            $feature->render($this->canvas);
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
            BorderPosition::All => $this->renderBorderLeft() || $this->renderBorderRight()  || $this->renderBorderTop() || $this->renderBorderBottom(),
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
        $this->canvas->drawRectangle(0, 0, $this->renderVerticalAccentedRectangle());
    }

    protected function renderBorderRight(): void
    {
        $this->canvas->drawRectangle(
            $this->width - $this->border->getWidth(),
            0,
            $this->renderVerticalAccentedRectangle()
        );
    }

    protected function renderBorderTop(): void
    {
        $this->canvas->drawRectangle(0, 0, $this->renderHorizontalAccentedRectangle());
    }

    protected function renderBorderBottom(): void
    {
        $this->canvas->drawRectangle(
            0,
            $this->height - $this->border->getWidth(),
            $this->renderHorizontalAccentedRectangle()
        );
    }

    protected function renderVerticalAccentedRectangle(): callable
    {
        return function ($rectangle) {
            $rectangle->size($this->border->getWidth(), $this->height);
            $rectangle->background($this->border->getColor());
        };
    }

    protected function renderHorizontalAccentedRectangle(): callable
    {
        return function ($rectangle) {
            $rectangle->size($this->width, $this->border->getWidth());
            $rectangle->background($this->border->getColor());
        };
    }

    /**
     * Repeats the supplied background image across the canvas
     */
    protected function renderBackground(): void
    {
        $panel = $this->manager->read($this->config->theme->getBackground()->path());

        $imagick = $panel->core()->native();

        $imagick->setImageVirtualPixelMethod(1);
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);

        $imagick->evaluateImage(
            Imagick::EVALUATE_MULTIPLY,
            $this->config->theme->getBackgroundOpacity(),
            Imagick::CHANNEL_ALPHA
        );

        $width = $panel->width();
        $height = $panel->height();

        $columns = ceil($this->width / $width);
        $rows = ceil($this->height / $height);

        $filledRows = 0;

        while ($filledRows <= $rows) {
            $filledColumns = 0;

            while ($filledColumns <= $columns) {
                $this->canvas->place(
                    element: $panel,
                    offset_x: $filledColumns * $width,
                    offset_y: $filledRows * $height,
                );

                $filledColumns++;
            }

            $filledRows++;
        }
    }

    /**
     * Renders a background image URL across the canvas and resizes it to cover the canvas
     */
    protected function renderBackgroundUrl(): void
    {
        $panel = $this->manager->read(file_get_contents($this->config->backgroundUrl));

        $imagick = $panel->core()->native();

        $imagick->setImageVirtualPixelMethod(1);
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);

        $imagick->evaluateImage(
            Imagick::EVALUATE_MULTIPLY,
            $this->config->theme->getBackgroundOpacity(),
            Imagick::CHANNEL_ALPHA
        );

        $width = $panel->width();
        $height = $panel->height();

        $panel->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $this->canvas->place(
            element: $panel,
            offset_x: 0,
            offset_y: 0,
        );
    }
}
