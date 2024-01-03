<?php

namespace SimonHamp\TheOg\Traits;

use Imagick;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Font;

trait RendersImages
{
    protected Image $image;
    protected ImageManager $manager;
    
    public function render(): Image
    {
        $this->manager = ImageManager::imagick();

        $this->image = $this->manager->create($this->width, $this->height)
            ->fill($this->backgroundColor);

        if ($this->background instanceof Background) {
            $this->renderBackground();
        }

        if ($this->url) {
            $this->renderUrl();
        }

        if ($this->title) {
            $this->renderTitle();
        }

        if ($this->description) {
            $this->renderDescription();
        }

        if ($this->border instanceof Border) {
            $this->renderBorder();
        }

        return $this->image;
    }

    protected function renderTitle(): void
    {
        $this->renderText(
            wordwrap($this->title, 30),
            '#000000',
            $this->layout->getTitleSize(),
            $this->layout->getTitleX(),
            $this->layout->getTitleY(),
            $this->layout->getTitleFont(),
        );
    }

    protected function renderDescription(): void
    {
        $this->renderText(
            wordwrap($this->description, 50),
            '#999999',
            $this->layout->getDescriptionSize(),
            $this->layout->getDescriptionX(),
            $this->layout->getDescriptionY(),
            $this->layout->getDescriptionFont(),
        );
    }

    protected function renderUrl(): void
    {
        $this->renderText(
            strtoupper(parse_url($this->url, PHP_URL_HOST) ?? $this->url),
            $this->accentColor,
            $this->layout->getUrlSize(),
            $this->layout->getUrlX(),
            $this->layout->getUrlY(),
            $this->layout->getUrlFont(),
        );
    }

    protected function renderText(string $text, string $color, int $size, int $x, int $y, Font $font): void
    {
        $this->image->text($text, $x, $y, function(FontFactory $fontFactory) use ($color, $size, $font) {
            $fontFactory->filename($font->path());
            $fontFactory->size($size);
            $fontFactory->color($color);
            $fontFactory->valign('top');
            $fontFactory->lineHeight(1.6);
        });
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
        $this->image->drawRectangle(0, 0, $this->renderVerticalAccentedRectangle());
    }

    protected function renderBorderRight(): void
    {
        $this->image->drawRectangle($this->width - $this->border->getWidth(), 0, $this->renderVerticalAccentedRectangle());
    }

    protected function renderBorderTop(): void
    {
        $this->image->drawRectangle(0, 0, $this->renderHorizontalAccentedRectangle());
    }

    protected function renderBorderBottom(): void
    {
        $this->image->drawRectangle(0, $this->height - $this->border->getWidth(), $this->renderHorizontalAccentedRectangle());
    }

    protected function renderVerticalAccentedRectangle(): callable
    {
        return function ($rectangle) {
            $rectangle->size($this->border->getWidth(), $this->height);
            $rectangle->background($this->accentColor);
        };
    }

    protected function renderHorizontalAccentedRectangle(): callable
    {
        return function ($rectangle) {
            $rectangle->size($this->width, $this->border->getWidth());
            $rectangle->background($this->accentColor);
        };
    }

    protected function renderBackground(): void
    {
        $panel = $this->manager->read($this->background->path());

        $imagick = $panel->core()->native();

        $imagick->setImageVirtualPixelMethod(1);
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);

        $imagick->evaluateImage(Imagick::EVALUATE_MULTIPLY, $this->backgroundOpacity, Imagick::CHANNEL_ALPHA);

        $width = $panel->width();
        $height = $panel->height();

        $columns = ceil($this->width / $width);
        $rows = ceil($this->height / $height);

        $filledRows = 0;

        while ($filledRows <= $rows) {
            $filledColumns = 0;

            while ($filledColumns <= $columns) {
                $this->image->place(
                    element: $panel,
                    offset_x: $filledColumns * $width,
                    offset_y: $filledRows * $height,
                );

                $filledColumns++;
            }

            $filledRows++;
        }
    }

    protected function renderBackgroundURL(): void
    {
        $panel = $this->manager->read(file_get_contents($this->backgroundURL));

        $imagick = $panel->core()->native();

        $imagick->setImageVirtualPixelMethod(1);
        $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);

        $imagick->evaluateImage(Imagick::EVALUATE_MULTIPLY, $this->backgroundOpacity, Imagick::CHANNEL_ALPHA);

        $width = $panel->width();
        $height = $panel->height();
    
        $columns = ceil($this->width / $width);
        $rows = ceil($this->height / $height);

        $panel->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $filledRows = 0;

        while ($filledRows <= $rows) {
            $filledColumns = 0;

            while ($filledColumns <= $columns) {
                $this->image->place(
                    element: $panel,
                    offset_x: $filledColumns * $width,
                    offset_y: $filledRows * $height,
                );

                $filledColumns++;
            }

            $filledRows++;
        }
    }
}
