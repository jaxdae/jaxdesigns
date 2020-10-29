<?php

namespace Towa\Theme\Cpt;

class Person extends TowaPost
{
    public const NAME = 'person';

    final public function register()
    {
        $args = [
            'label' => __('Person', 'towa'),
            'description' => __('Person', 'towa'),
            'labels' => [
                'name' => _x('Personen', 'Post Type General Name', 'towa'),
                'singular_name' => _x('Person', 'Post Type Singular Name', 'towa'),
                'add_new_item' => __('Erstellen', 'towa'),
            ],
            'supports' => ['title', 'revisions', 'author'],
            'hierarchical' => false,
            'public' => self::$public,
            'show_ui' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-admin-users',
        ];

        register_post_type(self::NAME, $args);
    }
}
