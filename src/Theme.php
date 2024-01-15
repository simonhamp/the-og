<?php

namespace SimonHamp\TheOg;

use SimonHamp\TheOg\Interfaces\Theme as ThemeInterface;
use SimonHamp\TheOg\Theme\Fonts\Inter;
use SimonHamp\TheOg\Theme\Theme as BaseTheme;

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
        return new BaseTheme(
            accentColor: '#247BA0',
            baseFont: Inter::bold(),
            baseColor: '#153B50',
            backgroundColor: '#ECEBE4',
            callToActionColor: '#153B50',
            descriptionColor: '#429EA6',
            descriptionFont: Inter::light(),
            titleFont: Inter::black(),
        );
    }

    /**
     * https://coolors.co/02111b-3f4045-30292f-5d737e-fcfcfc
     */
    protected function darkTheme(): ThemeInterface
    {
        return new BaseTheme(
            accentColor: '#5D737E',
            baseFont: Inter::bold(),
            baseColor: '#FCFCFC',
            backgroundColor: '#02111B',
            descriptionColor: '#3F4045',
            descriptionFont: Inter::light(),
            titleFont: Inter::black(),
        );
    }
}
