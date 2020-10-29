<?php

namespace Towa\Theme\Acf\Groups;

use Towa\Acf\Fields\Email;
use Towa\Theme\Cpt\Person as CptPerson;

class Person
{
    private $name = 'person_single';

    public function register()
    {
        acf_add_local_field_group([
            'key' => $this->name,
            'title' => 'Ansprechpartner',
            'fields' => $this->build_fields(),
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => CptPerson::NAME,
                    ],
                ],
            ],
            'menu_order' => 4,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => [],
            'active' => 1,
            'description' => '',
        ]);
    }

    private function build_fields()
    {
        return [
            (new Email($this->name))->build(),
        ];
    }
}
