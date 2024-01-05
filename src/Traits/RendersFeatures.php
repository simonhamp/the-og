<?php

namespace SimonHamp\TheOg\Traits;

use Imagick;
use Intervention\Image\Geometry\Point;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Font;
use SimonHamp\TheOg\Image as Config;
use SimonHamp\TheOg\Layout\TextBox;

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

        // TODO: This would be better as a homogenous stack where we can simply add items of a given type to the stack
        // and then loop over the items on the stack and call `render` on each one

        // Worth noting here that the order of the items in the stack should determine the order of execution, which
        // may have implications on the rendering of later elements due to dependencies on rendered dimensions

        // Basically, it's up to the layout developer to know the order of the dependencies and layering needs of the
        // design and reconcile that themselves by ordering the stack appropriately

        if ($this->config->theme->getBackground() instanceof Background) {
            $this->renderBackground();
        }

        if (isset($this->config->url) && $url = $this->getUrl($this->config->url)) {
            $this->renderTextBox($url);
        }

        if (isset($this->config->title) && $title = $this->getTitle($this->config->title)) {
            $this->renderTextBox($title);
        }

        if (isset($this->config->description) && $description = $this->getDescription($this->config->description)) {
            $this->renderTextBox($description);
        }

        // TODO: Render callToActionBackground

        if (isset($this->config->callToAction) && $callToAction = $this->getCallToAction($this->config->callToAction)) {
            $this->renderTextBox($callToAction);
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

    protected function renderTextBox(TextBox $textBox): void
    {
        $textBox->render()->apply($this->canvas);
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
}
