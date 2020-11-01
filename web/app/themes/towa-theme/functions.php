<?php

use Timber\Timber;
use Towa\Theme\Theme\Theme;
use Towa\Theme\Controller\AcfCtr;
use Towa\Theme\Controller\CptCtr;
use Towa\Theme\Controller\TaxCtr;

new Timber();

( new Theme() )->defines()
               ->settings()
               ->support()
               ->assets()
               ->menues()
               ->media()
               ->timber()
               ->permission()
               ->hooks()
               ->cleanup();

add_action('init', function () {
    ( new CptCtr() )->register_cpts();
    ( new TaxCtr() )->register_taxs();
});

add_action('acf/init', function () {
    ( new AcfCtr() )->register_groups();
});

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}
