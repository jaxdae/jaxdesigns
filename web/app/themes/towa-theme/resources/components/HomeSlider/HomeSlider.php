<?php

namespace Towa\Components\HomeSlider;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Relation;

class HomeSlider extends BaseSection
{
    public $name = 'HomeSlider';
    public $view = 'resources/components/HomeSlider/HomeSlider.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('HomeSlider', 'towa'),
            'display' => 'block',
            'sub_fields' => [
               ( new Relation($this->get_key(), 'featured', 'Featured Posts') )->build([
                   'conditional_logic' => 0,
			'post_type' => array(
                0 => 'post',
                1 => 'page'
			),
			'filters' => array(
				0 => 'search',
				1 => 'post_type',
			),
               ]),
               (new Image($this->get_key(), 'welcome', 'Welcome Bild') )->build([])
            ],
        ];
    }
}
