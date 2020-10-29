<?php
namespace Towa\Components\Accordion;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\Wysiwyg;

class Accordion extends BaseSection
{
    public $name = 'Accordion';

    public $view = 'components/Accordion/Accordion.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Accordion', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                ( new Repeater($this->get_key(), 'items', 'Items') )->build([
                    'layout' => 'row',
                    'button_label' => 'Reihe hinzufügen',
                    'collapsed' => $this->get_key() . '_title',
                    'sub_fields' => [
                        ( new Text($this->get_key(), 'title', __('Titel', 'towa')) )->build([
                            'required' => true,
                        ]),
                        ( new Wysiwyg($this->get_key(), 'text') )->build([
                            'required' => true,
                        ]),
                    ],
                    'min' => '',
                    'max' => '',
                ]),
            ],
        ];
    }
}
