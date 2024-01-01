<?php

namespace SimonHamp\TheOg;

enum Font: string
{
    case Inter = 'Inter/static/Inter-Regular.ttf';
    case InterBold = 'Inter/static/Inter-Bold.ttf';
    case InterLight = 'Inter/static/Inter-Light.ttf';
    
    public function path(): string
    {
        return __DIR__ . '/../resources/fonts/' . $this->value;
    }
}
