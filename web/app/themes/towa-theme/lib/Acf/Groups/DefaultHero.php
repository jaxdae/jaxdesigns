<?php

namespace Towa\Theme\Acf\Groups;

use Towa\Acf\Fields\Image;

use Towa\Acf\Fields\Text;
use Towa\Theme\Cpt\Page as Page;
use Towa\Theme\Cpt\Post as Post;

class DefaultHero
{
    private $name = 'default_hero';

    public function register()
    {
        acf_add_local_field_group([
            'key' => $this->name,
            'title' => 'Hero - Default',
            'fields' => $this->build_fields(),
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => Page::NAME,
                    ],
                ],
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => Post::NAME,
                    ],
                ],
            ],
            'menu_order' => 3,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => [],
            'active' => 1,
            'description' => '',
        ]);
    }

    private function build_fields()
    {
        return [
            ( new Text($this->name, 'title', 'Titel') )->build([
                'instructions' => 'Optional. Wenn nicht befüllt, wird der Seiten-Titel verwendet.',
            ]),
            ( new Text($this->name, 'subtitle', 'Untertitel') )->build([
                'instructions' => 'Optional.',
            ]),
            ( new Image($this->name, 'image', 'Bild'))->build([
                'required' => true,
            ]),
        ];
    }
}
