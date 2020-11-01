<?php

namespace Towa\Theme\Acf\Groups;

use Towa\Theme\Cpt\Page;
use Towa\Theme\Cpt\Post;
use Towa\Components\Slider\Slider;
use Towa\Components\Content\Content;
use Towa\Components\HomeSlider\HomeSlider;
use Towa\Components\About\About;
use Towa\Components\PostContent\PostContent;

class Sections
{
    private $prefix = 'flexible_components_';
    private $name = 'sections';

    public function __construct($prefix = '')
    {
        if (! empty($prefix)) {
            $this->prefix = $prefix;
        }
    }

    public function register()
    {
        acf_add_local_field_group([
            'key' => $this->prefix . 'module',
            'title' => 'Module',
            'fields' => [
                [
                    'key' => $this->prefix . $this->name,
                    'name' => $this->name,
                    'type' => 'flexible_content',
                    'button_label' => 'Sektion hinzufügen',
                    'layouts' => $this->get_sections(),
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => Post::NAME,
                    ]
                ],
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => Page::NAME,
                    ],
                ],
            ],
            'menu_order' => 4,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => [],
            'active' => 1,
            'description' => '',
        ]);
    }

    private function get_sections()
    {
        $Sections = [
            About::class,
            Content::class,
            Slider::class,
            HomeSlider::class,
            PostContent::class,
        ];

        return collect($Sections)->map(function ($Section) {
            return $Section::get_instance($this->prefix)->get_acf_fields();
        })->toArray();
    }
}
