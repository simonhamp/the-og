<?php

namespace SimonHamp\TheOg\Layout;

use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Interfaces\Layout;
use SimonHamp\TheOg\Traits\RendersFeatures;

abstract class AbstractLayout implements Layout
{
    use RendersFeatures;

    protected Border $border;
    protected BorderPosition $borderPosition;
    protected int $borderWidth;
    protected int $height;
    protected int $padding;
    protected int $width;

    protected TextBox $callToAction;
    protected TextBox $description;
    protected TextBox $title;
    protected TextBox $url;

    abstract protected function features(string $feature, string $setting): mixed;

    public function border(Border $border): self
    {
        $this->border = $border;
        return $this;
    }

    public function callToAction(): string
    {
        return $this->config->callToAction;
    }

    public function getCallToAction(): TextBox
    {
        return $this->callToAction ??= (new TextBox())
            ->text($this->callToAction())
            ->color($this->config->theme->getCallToActionColor())
            ->font($this->config->theme->getCallToActionFont())
            ->size($this->features('call_to_action', 'font_size'))
            ->box(...$this->features('call_to_action', 'dimensions'))
            ->position(...$this->features('call_to_action', 'layout'));
    }

    public function description(): string
    {
        return $this->config->description;
    }

    public function getDescription(): TextBox
    {
        return $this->description ??= (new TextBox())
            ->text($this->description())
            ->color($this->config->theme->getDescriptionColor())
            ->font($this->config->theme->getDescriptionFont())
            ->size($this->features('description', 'font_size'))
            ->box(...$this->features('description', 'dimensions'))
            ->position(...$this->features('description', 'layout'));
    }

    public function title(): string
    {
        return $this->config->title;
    }

    public function getTitle(): TextBox
    {
        return $this->title ??= (new TextBox())
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size($this->features('title', 'font_size'))
            ->box(...$this->features('title', 'dimensions'))
            ->position(...$this->features('title', 'layout'));
    }

    public function url(): string
    {
        return parse_url($this->config->url, PHP_URL_HOST) ?? $this->config->url;
    }

    public function getUrl(): TextBox
    {
        return $this->url ??= (new TextBox())
            ->text($this->url())
            ->color($this->config->theme->getUrlColor())
            ->font($this->config->theme->getUrlFont())
            ->size($this->features('url', 'font_size'))
            ->box(...$this->features('url', 'dimensions'))
            ->position(...$this->features('url', 'layout'));
    }

    /**
     * The area within the canvas that we should be rendering content. This is just a convenience object
     */
    public function mountArea(): Box
    {
        return (new Box)
            ->box(
                $this->width - (($this->padding + $this->getBorderWidth()) * 2),
                $this->height - (($this->padding + $this->getBorderWidth()) * 2)
            )
            ->position(
                $this->padding + $this->getBorderWidth(),
                $this->padding + $this->getBorderWidth()
            );
    }

    public function getBorderWidth(): int
    {
        if (isset($this->border)) {
            return $this->border->getWidth();
        }

        return $this->borderWidth;
    }

    public function getBorderPosition(): BorderPosition
    {
        if (isset($this->border)) {
            return $this->border->getPosition();
        }

        return $this->borderPosition;
    }
}
