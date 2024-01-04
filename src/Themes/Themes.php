<?php

namespace SimonHamp\TheOg\Themes;

use SimonHamp\TheOg\Font;
use SimonHamp\TheOg\Interfaces\Theme;

enum Themes: string
{
    case Light = 'light';
    case Dark = 'dark';

    public function getTheme(): Theme
    {
        return match ($this) {
            self::Light => $this->lightTheme(),
            self::Dark => $this->darkTheme(),
        };
    }

    /**
     * https://coolors.co/ecebe4-cc998d-16f4d0-429ea6-153b50
     */
    protected function lightTheme(): Theme
    {
        return new class(
            accentColor: '#247BA0',
            backgroundColor: '#ECEBE4',
            baseColor: '#153B50',
            baseFont: Font::InterBold,
            callToActionBackgroundColor: '#153B50',
            callToActionColor: '#ECEBE4',
            descriptionColor: '#429EA6',
            descriptionFont: Font::InterLight,
            titleFont: Font::InterBlack,
        ) extends AbstractTheme {};
    }

    /**
     * https://coolors.co/02111b-3f4045-30292f-5d737e-fcfcfc
     */
    protected function darkTheme(): Theme
    {
        return new class(
            accentColor: '#5D737E',
            backgroundColor: '#02111B',
            baseColor: '#FCFCFC',
            baseFont: Font::InterBold,
            descriptionColor: '#3F4045',
            descriptionFont: Font::InterLight,
            titleFont: Font::InterBlack,
            urlColor: '#30292F',
        ) extends AbstractTheme {};
    }
}
