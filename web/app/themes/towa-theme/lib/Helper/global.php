<?php

use Towa\Theme\Cpt\Page;
use Towa\Theme\Cpt\Post;
use Towa\Theme\Cpt\Download;

if (! function_exists('get_cpt_classmap')) {
    /**
     * build cpt classmap for queryiterator in timber
     *
     * @return array
     */
    function get_cpt_classmap()
    {
        return [
            Page::NAME => Page::class,
            Post::NAME => Post::class,
            Download::NAME => Download::class,
        ];
    }
}

if (! function_exists('get_stage')) {
    function get_stage()
    {
        return env('WP_ENV');
    }
}

if (! function_exists('is_development_stage')) {
    function is_development_stage()
    {
        return ('development' === get_stage());
    }
}

if (! function_exists('is_test_stage')) {
    function is_test_stage()
    {
        return ('test' === get_stage());
    }
}

if (! function_exists('is_production_stage')) {
    function is_production_stage()
    {
        return ('production' === get_stage());
    }
}

if (! function_exists('view_path')) {
    function view_path($to)
    {
        return sprintf('views/%1$s', $to);
    }
}

if (! function_exists('register_style')) {
    function register_style($name)
    {
        wp_enqueue_style(
            $name,
            PATH_COMPONENTS . $name . '/' . $name . '.css',
            ['towa-main-style'],
            theme_version()
        );
    }
}

if (! function_exists('theme_version')) {
    function theme_version()
    {
        $theme = wp_get_theme();

        return $theme->get('Version');
    }
}
