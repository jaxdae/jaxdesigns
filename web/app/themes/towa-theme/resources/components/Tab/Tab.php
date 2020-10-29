<?php
namespace Towa\Components\Tab;

use Towa\Acf\BaseSection;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\Wysiwyg;

class Tab extends BaseSection
{
    public $name = 'Tab';

    public $view = 'components/Tab/Tab.twig';

    public function get_acf_fields($prefix = '')
    {
        return [
            'key' => $prefix . $this->name,
            'name' => $this->name,
            'label' => __('Tabs', 'towa'),
            'display' => 'block',
            'sub_fields' => [
                ( new Repeater($this->get_key(), 'items', 'Items') )->build([
                    'layout' => 'row',
                    'button_label' => 'Tab hinzufügen',
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
