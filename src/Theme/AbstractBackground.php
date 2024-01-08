<?php

namespace SimonHamp\TheOg\Theme;

use SimonHamp\TheOg\Interfaces\Background;

abstract class AbstractBackground implements Background
{
    public function __construct(protected string $path)
    {
        
    }
    
    public function path(): string
    {
        return $this->path;
    }
}
