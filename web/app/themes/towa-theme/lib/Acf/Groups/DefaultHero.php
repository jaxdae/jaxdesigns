<?php

namespace Towa\Theme\Acf\Groups;

use Towa\Acf\Fields\Text;
use Towa\Acf\Fields\TextArea;
use Towa\Acf\Fields\Image;
use Towa\Acf\Fields\Wysiwyg;
use Towa\Acf\Fields\Repeater;
use Towa\Acf\Fields\Relation;
use Towa\Acf\Fields\Select;
use Towa\Theme\Cpt\Page as Page;
use Towa\Theme\Cpt\Post as Post;

class DefaultHero
{
    private $name = 'default_hero';

    public function register()
    {
        acf_add_local_field_group([
            'key' => $this->name,
            'title' => 'Post Informationen',
            'fields' => $this->build_fields(),
            'location' => [
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
             (new TextArea($this->name, 'abstract', 'Zusammenfassung'))->build([
                    'required' => true,
                    'maxlength' => 400,
                ]),
                (new Image($this->name, 'image', 'Highlight Bild'))->build([
                    'required' => true,
                ]),
                (new Select($this->name, 'category', 'Kategorie'))->build([
	                'choices' => array(
				'Furniture & Co.' => 'Furniture & Co.',
				'Sewing' => 'Sewing',
				'Decorations' => 'Decorations',
				'Bullet Journal' => 'Bullet Journal',
                'Wood working' => 'Wood working',
                'Jaxdesigns' => 'Jaxdesigns'
			),
                ]),
                 (new Select($this->name, 'difficulty', 'Schwierigkeit'))->build([
	                'choices' => array(
				'Easy' => 'Easy',
				'Intermediate' => 'Intermediate',
				'Difficult' => 'Difficult'
			),
                ]),

        ];
    }
}
