<?php

use Timber\Timber;
use Towa\Theme\Controller\AcfCtr;
use Towa\Theme\Controller\CptCtr;
use Towa\Theme\Controller\RestCtr;
use Towa\Theme\Controller\TaxCtr;
use Towa\Theme\Theme\Theme;

new Timber();

(new Theme())
    ->defines()
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
    (new CptCtr())->register_cpts();
    (new TaxCtr())->register_taxs();
    (new RestCtr())->register_routes();
});

add_action('acf/init', function () {
    (new AcfCtr())->register_groups();
});
