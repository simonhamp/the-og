<?php

namespace SimonHamp\TheOg\Layout\Layouts;

use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Layout\TextBox;

class Standard extends AbstractLayout
{
    protected BorderPosition $borderPosition = BorderPosition::All;
    protected int $borderWidth = 25;
    protected int $height = 630;
    protected int $padding = 40;
    protected int $width = 1200;

    public function features(): void
    {
        $this->addFeature('title', (new TextBox())
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size(60)
            ->box($this->mountArea()->box->width(), 400)
            ->position(
                x: 0,
                y: 0,
                relativeTo: fn () => $this->getFeature('url'),
                position: Position::BottomLeft
            )
        );

        if ($description = $this->description()) {
            $this->addFeature('description', (new TextBox())
                ->text($description)
                ->color($this->config->theme->getDescriptionColor())
                ->font($this->config->theme->getDescriptionFont())
                ->size(40)
                ->box($this->mountArea()->box->width(), 240)
                ->position(
                    x: 0,
                    y: 50,
                    relativeTo: fn() => $this->getFeature('title'),
                    position: Position::BottomLeft
                )
            );
        }

        if ($callToAction = $this->callToAction()) {
            $this->addFeature('call_to_action', (new TextBox())
                ->text($callToAction)
                ->color($this->config->theme->getCallToActionColor())
                ->font($this->config->theme->getCallToActionFont())
                ->size(20)
                ->box($this->mountArea()->box->width(), 240)
                ->position(
                    x: 0,
                    y: 20,
                    relativeTo: fn() => $this->getFeature('description')
                )
            );
        }

        if ($url = $this->url()) {
            $this->addFeature('url', (new TextBox())
                ->text($url)
                ->color($this->config->theme->getUrlColor())
                ->font($this->config->theme->getUrlFont())
                ->size(28)
                ->box($this->mountArea()->box->width(), 45)
                ->position(
                    x: 0,
                    y: 20,
                    relativeTo: fn() => $this->mountArea()
                )
            );
        }
    }

    public function url(): string
    {
        return strtoupper(parent::url());
    }
}
