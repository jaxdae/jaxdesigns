<?php

namespace Towa\Theme\Term;

use Timber\Term;
use Towa\Theme\Cpt\Page;
use Towa\Theme\Cpt\Person;

class Department extends Term
{
    public const NAME = 'department';
    public const CPTS = [Person::NAME, Page::NAME];

    private $fetch_id;

    public function __construct($pid = null)
    {
        parent::__construct($pid);

        $this->fetch_id = "term_{$this->term_id}";
    }

    final public function register()
    {
        $args = [
            'labels' => [
                'name' => _x('Abteilungen', 'Taxonomy General Name', 'towa'),
                'singular_name' => _x('Abteilung', 'Taxonomy Singular Name', 'towa'),
                'view_item' => __('Abteilungen ansehen', 'towa'),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
        ];

        register_taxonomy(self::NAME, self::CPTS, $args);
    }

    protected function fetch_field($name)
    {
        if (! isset($this->$name)) {
            $this->$name = get_field($name, $this->fetch_id);
        }

        return $this->$name;
    }
}
