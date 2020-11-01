<?php

namespace Towa\Theme\Timber;

use TimberMenu;
use Towa\Theme\Theme\Media;

class Context
{
    public function __construct()
    {
        add_filter('timber_context', [$this, 'add_to_context']);
    }

    public function add_to_context($data)
    {
        $data = $this->add_stage_info($data);
        $data = $this->add_paths($data);
        $data = $this->add_menues($data);
        $data = $this->add_site_settings($data);
        $data = $this->add_breakpoints($data);

        return $data;
    }

    private function add_stage_info($data)
    {
        $data[ 'env' ] = [
            'env' => get_stage(),
            'is_production_stage' => is_production_stage(),
            'is_test_stage' => is_test_stage(),
            'is_development_stage' => is_development_stage(),
            'show_bp_badge' => env('SHOW_BP_BADGE'),
        ];

        return $data;
    }


    private function add_paths($data)
    {
        $data[ 'path' ] = [
            'dist' => PATH_THEME . '/dist',
            'css' => PATH_CSS,
            'fonts' => PATH_FONTS,
            'images' => PATH_IMAGES,
            'js' => PATH_JS,

            'components' => 'resources/components/',
            'partials' => view_path('partials'),
            'sections' => view_path('sections'),
            'templates' => view_path('templates'),
            'layouts' => view_path('layouts'),
        ];

        return $data;
    }

    private function add_menues($data)
    {
        $data[ 'primary_menu' ] = new TimberMenu('primary');

        return $data;
    }

    private function add_site_settings($data)
    {
        $data['option'] = get_fields('options');

        return $data;
    }

    private function add_breakpoints($data)
    {
        $data[ 'breakpoints' ] = Media::$breakpoints;

        return $data;
    }
}
