<?php

namespace Towa\Theme\Timber;

use Twig\Extension\StringLoaderExtension;
use Twig\TwigFunction;
use WPSEO_Primary_Term;

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
        $twig->addExtension(new StringLoaderExtension());

        $twig->addFunction(new TwigFunction('dd', 'dd'));
        $twig->addFunction(new TwigFunction('dump', 'dump'));
        $twig->addFunction(new TwigFunction('env', 'get_stage'));
        $twig->addFunction(new TwigFunction('get_relative_path', 'view_path'));
        $twig->addFunction(new TwigFunction('primary_category', [$this, 'primary_category']));
        $twig->addFunction(new TwigFunction('load_component_json', [$this, 'load_component_json']));
        $twig->addFunction(new TwigFunction('section_id', [$this, 'section_id']));

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

    public function section_id($counter)
    {
        return sprintf('section-%s', $counter + 1);
    }
}
