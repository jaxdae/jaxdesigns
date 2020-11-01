<?php

namespace Towa\Components\PostSlider;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Gallery;
use Towa\Acf\Fields\Text;

class PostSlider extends BaseSection
{
    public $name = 'PostSlider';
    public $view = 'resources/components/PostSlider/PostSlider.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('PostSlider', 'towa'),
            'display' => 'block',
            'sub_fields' => [
            (new Text($this->get_key(), 'hashtag', 'Hashtag') )->build(),
             (new Gallery($this->get_key(), 'slides', 'Highlight Bilder Slider') )->build()
            ],
        ];
    }
}
