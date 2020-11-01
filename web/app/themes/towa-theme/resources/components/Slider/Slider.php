<?php

namespace Towa\Components\Slider;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Wysiwyg;
use Towa\Acf\Fields\Repeater;

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
                    'button_label' => 'Reihe hinzufügen',
                    'sub_fields' => [
                        ( new Text($this->get_key(), 'heading', 'Überschrift') )->build(),
                        ( new Image($this->get_key(), 'image', 'Bild') )->build(),
                        ( new Wysiwyg($this->get_key(), 'content') )->build([
                            'tabs' => 'visual',
                        ]),
                    ],
                    'min' => '',
                    'max' => '',
                ]),
            ],
        ];
    }
}
