<?php

namespace Towa\Theme\Cpt;

class Page extends TowaPost
{
    public const NAME = 'page';

    protected static $public = true;

    public function __construct($pid = null)
    {
        parent::__construct($pid);
    }
}
