<?php

namespace Towa\Components\Slider;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Link;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\Wysiwyg;

class Slider extends BaseSection
{
    public $name = 'Slider';

    public $view = 'resources/components/Slider/Slider.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Slider', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                ( new Repeater($this->get_key(), 'slides', 'Slides') )->build([
                    'layout' => 'row',
                    'button_label' => __('Slide hinzufügen', 'towa'),
                    'sub_fields' => [
                        ( new Text($this->get_key(), 'title', __('Überschrift', 'towa')) )->build(),
                        ( new Image($this->get_key(), 'image', __('Bild', 'towa')) )->build(),
                        ( new Wysiwyg($this->get_key(), __('Content', 'towa')) )->build([
                            'tabs' => 'visual',
                        ]),
                        (new Link($this->get_key(), 'link', __('Link', 'towa')) )->build(),
                    ],
                    'min' => '',
                    'max' => '',
                ]),
            ],
        ];
    }
}
