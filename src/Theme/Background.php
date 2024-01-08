<?php

namespace SimonHamp\TheOg\Theme;

use SimonHamp\TheOg\Interfaces\Background as BackgroundInterface;

class Background implements BackgroundInterface
{
    public function __construct(protected string $path)
    {
        
    }
    
    public function path(): string
    {
        return $this->path;
    }
}
