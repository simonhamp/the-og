<?php

namespace SimonHamp\TheOg\Layout;

use SimonHamp\TheOg\Border;
use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Interfaces\Box as BoxInterface;
use SimonHamp\TheOg\Interfaces\Layout;
use SimonHamp\TheOg\Theme\Picture;
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

    /**
     * @var array<string, BoxInterface>
     */
    protected array $features = [];

    public function addFeature(BoxInterface $feature): void
    {
        $name = $feature->getName() ?? $this->generateFeatureName($feature);
        $this->features[$name] = $feature;
    }

    public function getFeature(string $name): ?BoxInterface
    {
        return $this->features[$name] ?? null;
    }

    public function border(Border $border): self
    {
        $this->border = $border;
        return $this;
    }

    public function callToAction(): ?string
    {
        return $this->config->callToAction ?? null;
    }

    public function description(): ?string
    {
        return $this->config->description ?? null;
    }

    public function picture(): ?Picture
    {
        return $this->config->picture ?? null;
    }

    public function title(): string
    {
        return $this->config->title;
    }

    public function url(): ?string
    {
        if (!isset($this->config->url)) {
            return null;
        }

        return parse_url($this->config->url, PHP_URL_HOST) ?? $this->config->url;
    }

    public function watermark(): ?Picture
    {
        return $this->config->watermark ?? null;
    }

    /**
     * The area within the canvas that we should be rendering content. This is just a convenience object to help layout
     * of other features and is not normally rendered (it's not added to the $features list)
     */
    public function mountArea(): BoxInterface
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

    protected function generateFeatureName(BoxInterface $feature): string
    {
        return $feature::class . '_' . (count($this->features) + 1);
    }
}
