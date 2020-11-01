<?php

namespace Towa\Components\PostIntro;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\TextArea;

class PostIntro extends BaseSection
{
    public $name = 'PostIntro';
    public $view = 'resources/components/PostIntro/PostIntro.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Einleitung', 'towa'),
            'display' => 'block',
            'sub_fields' => [
               (new TextArea($this->get_key(), 'abstract', 'Zusammenfassung'))->build([
                    'required' => true,
                    'maxlength' => 400,
                ]),
            ],
        ];
    }
}
