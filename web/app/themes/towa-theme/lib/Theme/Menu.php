<?php

namespace Towa\Theme\Theme;

class Menu
{
    public function __construct()
    {
        $this->register_menues();
        $this->register_website_options();
    }

    private function register_menues()
    {
        register_nav_menu('primary', __('Hauptmenü', 'towa'));
    }

    private function register_website_options()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Website Optionen',
                'menu_title' => 'Website Optionen',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
            ]);
        }
    }
}
