<?php

namespace SimonHamp\TheOg\Layout;

use SimonHamp\TheOg\Interfaces\Layout;
use SimonHamp\TheOg\Layout\Layouts;

enum Layouts: string
{
    case Standard = 'standard';
    case GitHubBasic = 'github-basic';

    public function getLayout(): Layout
    {
        return match ($this) {
            self::Standard => new Layouts\Standard(),
            self::GitHubBasic => new Layouts\GitHubBasic(),
        };
    }
}
