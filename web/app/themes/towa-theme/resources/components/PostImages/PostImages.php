<?php

namespace Towa\Components\PostImages;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image;

class PostImages extends BaseSection
{
    public $name = 'PostImages';
    public $view = 'resources/components/PostImages/PostImages.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => 'PostImages',
            'label' => __('Highlight Bilder', 'towa'),
            'display' => 'block',
            'sub_fields' => [
               (new Image($this->get_key(), 'imageLeft', 'Linkes Bild'))->build([
                    'required' => true,
                    'wrapper' => array(
				'width' => '50')
                ]),
                (new Image($this->get_key(), 'imageRight', 'Rechtes Bild'))->build([
                    'required' => true,
                    'wrapper' => array(
				'width' => '50')
                ]),
            ],
        ];
    }
}
