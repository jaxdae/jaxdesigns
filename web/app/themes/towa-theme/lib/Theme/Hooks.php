<?php

namespace Towa\Theme\Theme;

use Timber;

class Hooks
{
    public function __construct()
    {
        $this->actions();
        $this->filters();
    }

    public function actions()
    {
    }

    public function filters()
    {
        // get classmap for cpt resolving!
        add_filter('Timber\PostClassMap', function () {
            return get_cpt_classmap();
        });

        add_filter('acf/format_value/type=relationship', [$this, 'towa_resolve_cpts'], 9999, 3);
        add_filter('acf/format_value/type=post_object', [$this, 'towa_resolve_cpt'], 9999, 3);

        // faster load times in backend
        add_filter('acf/settings/remove_wp_meta_box', '__return_true');

        add_filter('wpseo_metabox_prio', [$this, 'yoast_to_bottom']);

        add_filter('jpeg_quality', function () {
            return 100;
        });
    }

    public function towa_resolve_cpts($value)
    {
        if (! empty($value)) {
            $value = Timber::get_posts([
                'post__in' => $value,
                'post_type' => array_keys(get_cpt_classmap()),
                'ignore_sticky_posts' => true,
                'orderby' => 'post__in',
                'nopaging' => true,
            ], get_cpt_classmap());
        }

        return $value;
    }

    public function towa_resolve_cpt($value)
    {
        if (! empty($value)) {
            $value = Timber::get_post($value);
        }

        return $value;
    }

    public function yoast_to_bottom()
    {
        return 'low';
    }
}
