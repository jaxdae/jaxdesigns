<?php

namespace Towa\Theme\Cpt;

use Timber\Post;

abstract class TowaPost extends Post
{
    protected static $public = false;

    public function __construct($pid = null)
    {
        parent::__construct($pid);
    }

    protected function fetch_field($name)
    {
        if (! isset($this->$name)) {
            $this->$name = $this->get_field($name);
        }

        return $this->$name;
    }

    public function teaser_image()
    {
        return $this->fetch_field('teaser_image');
    }

    public function teaser_text()
    {
        return $this->fetch_field('teaser_text');
    }
}
