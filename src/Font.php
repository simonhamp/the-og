<?php

namespace SimonHamp\TheOg;

enum Font: string implements Interfaces\Font
{
    case Inter = 'Inter/static/Inter-Regular.ttf';
    case InterBlack = 'Inter/static/Inter-Black.ttf';
    case InterBold = 'Inter/static/Inter-Bold.ttf';
    case InterLight = 'Inter/static/Inter-Light.ttf';

    public function path(): string
    {
        return __DIR__ . '/../resources/fonts/' . $this->value;
    }
}
