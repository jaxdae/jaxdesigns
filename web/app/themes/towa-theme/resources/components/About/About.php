<?php

namespace Towa\Components\About;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Select;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\TextArea;
use Towa\Acf\Fields\Wysiwyg;

class About extends BaseSection
{
    public $name = 'About';
    public $view = 'resources/components/About/About.twig';

    public function get_acf_fields($prefix = '')
    {
        $choices = new Select($this->get_key(), 'chooser', 'Block Auswahl');
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Legal Page Block', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                $choices->build([
                    'choices' => [
                    'About' => 'About',
                    'Imprint' => 'Imprint',
                    'Privacy Policy' => 'Privacy Policy',
                    'Contact' => 'Contact'
                    ]
                ]),
                (new Image($this->get_key(), 'portrait', 'Portrait'))->build([]),
                (new Repeater($this->get_key(), 'joboptions', 'Job Bezeichnungen'))->build([
                     'conditional_logic' => [
                                [
                                    [
                                        'field' => $choices->get_key(),
                                        'operator' => '==',
                                        'value' => 'About',
                                    ],
                                ],
                            ],
                    'sub_fields' => [
                        ( new Text($this->get_key(), 'options', 'Option'))->build()
                    ],
               ]),
               (new TextArea($this->get_key(), 'description', 'Beschreibungstext'))->build([
                   'conditional_logic' => [
                                [
                                    [
                                        'field' => $choices->get_key(),
                                        'operator' => '==',
                                        'value' => 'About',
                                    ],
                                ],
                            ],
               ]),
                (new Wysiwyg($this->get_key(), 'text', 'Text'))->build([
                    'conditional_logic' => [
                                [
                                    [
                                        'field' => $choices->get_key(),
                                        'operator' => '==',
                                        'value' => 'Imprint',
                                    ],
                                ],
                                [
                                    [
                                        'field' => $choices->get_key(),
                                        'operator' => '==',
                                        'value' => 'Privacy Policy',
                                    ],
                                ],
                            ],
                ]),
            ],
        ];
    }
}
