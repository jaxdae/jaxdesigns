<?php

namespace Towa\Theme\Controller;

use Towa\Theme\Cpt\Post;
use Towa\Theme\Term\Department;

class TaxCtr
{
    const SEASON = 'saison';

    public function register_taxs()
    {
        $Taxs = [
            // Department::class
        ];

        array_walk($Taxs, function ($Tax) {
            (new $Tax())->register();
        });

        // $this->register_taxonomy_which_need_no_dedicated_class_nor_functions();
    }

    public function register_taxonomy_which_need_no_dedicated_class_nor_functions()
    {
        $args = [
            'labels' => [
                'name' => _x('Saison', 'Taxonomy General Name', 'towa'),
                'singular_name' => _x('Saison', 'Taxonomy Singular Name', 'towa'),
                'view_item' => _x('Saison ansehen', 'Taxonomy Singular Name', 'towa'),
            ],
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
        ];

        register_taxonomy(self::SEASON, Post::NAME, $args);
    }
}
