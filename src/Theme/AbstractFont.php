<?php

namespace SimonHamp\TheOg\Theme;

use SimonHamp\TheOg\Interfaces\Font;

abstract class AbstractFont implements Font
{
    abstract public function path(): string;
    
    protected function __construct(protected ?string $variant = null)
    {

    }
}
