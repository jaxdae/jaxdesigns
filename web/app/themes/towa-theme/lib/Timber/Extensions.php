<?php

namespace Towa\Theme\Timber;

use Twig_SimpleFunction;
use Twig_Extension_StringLoader;

class Extensions
{
    protected $components = [];
    protected $instanceCounter = [];

    public function __construct()
    {
        add_filter('get_twig', [$this, 'add_to_twig']);
    }

    public function add_to_twig($twig)
    {
        $twig->addExtension(new Twig_Extension_StringLoader());

        $twig->addFunction(new Twig_SimpleFunction('dd', 'dd'));
        $twig->addFunction(new Twig_SimpleFunction('dump', 'dump'));
        $twig->addFunction(new Twig_SimpleFunction('env', 'get_stage'));
        $twig->addFunction(new Twig_SimpleFunction('get_relative_path', 'view_path'));
        $twig->addFunction(new Twig_SimpleFunction('primary_category', [$this, 'primary_category']));
        $twig->addFunction(new Twig_SimpleFunction('load_component_json', [$this, 'load_component_json']));

        return $twig;
    }

    public function load_component_json($json, $context = [])
    {
        return array_merge($context, json_decode($json, true));
    }

    public function primary_category($tax, $post_id)
    {
        if (! class_exists('WPSEO_Primary_Term')) {
            return false;
        }

        return get_term((new WPSEO_Primary_Term($tax, $post_id))->get_primary_term());
    }
}
