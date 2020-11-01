<?php

namespace Towa\Components\Wysiwyg;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Wysiwyg as WysiwygField;

class Wysiwyg extends BaseSection
{
    public $name = 'Wysiwyg';
    public $view = 'resources/components/Wysiwyg/Wysiwyg.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => 'Text',
            'display' => 'block',
            'sub_fields' => [
                (new WysiwygField($this->get_key()))->build(),
            ],
        ];
    }
}
