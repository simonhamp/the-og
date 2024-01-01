<?php

namespace SimonHamp\TheOg;

enum Layout: string
{
    case Standard = 'standard';
    case Bold = 'bold';
    case Split = 'split';

    public function getUrlX(): int
    {
        return match ($this) {
            self::Standard => 80,
            self::Bold => 120,
            self::Split => 120,
        };
    }

    public function getUrlY(): int
    {
        return match ($this) {
            self::Standard => 80,
            self::Bold => 120,
            self::Split => 120,
        };
    }

    public function getUrlSize(): int
    {
        return match ($this) {
            self::Standard => 28,
            self::Bold => 28,
            self::Split => 28,
        };
    }

    public function getUrlFont(): Font
    {
        return match ($this) {
            self::Standard => Font::InterBold,
            self::Bold => Font::Inter,
            self::Split => Font::Inter,
        };
    }

    public function getTitleX(): int
    {
        return match ($this) {
            self::Standard => 80,
            self::Bold => 120,
            self::Split => 120,
        };
    }

    public function getTitleY(): int
    {
        return match ($this) {
            self::Standard => 120,
            self::Bold => 120,
            self::Split => 120,
        };
    }

    public function getTitleSize(): int
    {
        return match ($this) {
            self::Standard => 72,
            self::Bold => 28,
            self::Split => 28,
        };
    }

    public function getTitleFont(): Font
    {
        return match ($this) {
            self::Standard => Font::InterBold,
            self::Bold => Font::InterBold,
            self::Split => Font::InterBold,
        };
    }

    public function getDescriptionX(): int
    {
        return match ($this) {
            self::Standard => 80,
            self::Bold => 120,
            self::Split => 120,
        };
    }

    public function getDescriptionY(): int
    {
        return match ($this) {
            self::Standard => 300,
            self::Bold => 120,
            self::Split => 120,
        };
    }

    public function getDescriptionSize(): int
    {
        return match ($this) {
            self::Standard => 40,
            self::Bold => 40,
            self::Split => 40,
        };
    }

    public function getDescriptionFont(): Font
    {
        return match ($this) {
            self::Standard => Font::InterLight,
            self::Bold => Font::InterLight,
            self::Split => Font::InterLight,
        };
    }
}
