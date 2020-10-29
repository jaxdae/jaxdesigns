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

    public function transform()
    {
        return [
            'id' => $this->id,
            'link' => $this->link,
            'title' => $this->post_title,
            'image' => $this->image(),
        ];
    }

    public function image()
    {
        return $this->fetch_field('image');
    }

    protected function fetch_field($name)
    {
        if (! isset($this->$name)) {
            $this->$name = $this->get_field($name);
        }

        return $this->$name;
    }

    protected function primary_category($taxonomy = 'category')
    {
        if (! class_exists('WPSEO_Primary_Term')) {
            return false;
        }

        $term = (new WPSEO_Primary_Term($taxonomy, $this->id))->get_primary_term();

        if (! $term) {
            $term = collect($this->terms($taxonomy))->first();
        }

        return $term ? get_term($term)->name : '';
    }
}
