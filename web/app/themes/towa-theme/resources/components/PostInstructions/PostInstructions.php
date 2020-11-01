<?php

namespace Towa\Components\PostInstructions;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\TextArea;

class PostInstructions extends BaseSection
{
    public $name = 'PostInstructions';
    public $view = 'resources/components/PostInstructions/PostInstructions.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('How to', 'towa'),
            'display' => 'block',
            'sub_fields' => [
               (new TextArea($this->get_key(), 'abstract', 'Introtext'))->build([
                    'required' => true,
                ]),
            ],
        ];
    }
}
