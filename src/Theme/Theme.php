<?php

namespace SimonHamp\TheOg\Theme;

use SimonHamp\TheOg\Theme\Fonts\Inter;
use SimonHamp\TheOg\Interfaces\Theme as ThemeInterface;

enum Theme: string
{
    case Light = 'light';
    case Dark = 'dark';

    public function load(): ThemeInterface
    {
        return match ($this) {
            self::Light => $this->lightTheme(),
            self::Dark => $this->darkTheme(),
        };
    }

    /**
     * https://coolors.co/ecebe4-cc998d-16f4d0-429ea6-153b50
     */
    protected function lightTheme(): ThemeInterface
    {
        return new class(
            accentColor: '#247BA0',
            backgroundColor: '#ECEBE4',
            baseColor: '#153B50',
            baseFont: Inter::bold(),
            callToActionColor: '#153B50',
            descriptionColor: '#429EA6',
            descriptionFont: Inter::light(),
            titleFont: Inter::black(),
        ) extends AbstractTheme {};
    }

    /**
     * https://coolors.co/02111b-3f4045-30292f-5d737e-fcfcfc
     */
    protected function darkTheme(): ThemeInterface
    {
        return new class(
            accentColor: '#5D737E',
            backgroundColor: '#02111B',
            baseColor: '#FCFCFC',
            baseFont: Inter::bold(),
            descriptionColor: '#3F4045',
            descriptionFont: Inter::light(),
            titleFont: Inter::black(),
        ) extends AbstractTheme {};
    }
}
