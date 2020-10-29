<?php

namespace Towa\Theme\Cpt;

class Post extends TowaPost
{
    public const NAME = 'post';

    protected static $public = true;

    public function __construct($pid = null)
    {
        parent::__construct($pid);
    }
}
