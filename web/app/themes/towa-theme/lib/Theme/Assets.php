<?php

namespace Towa\Theme\Theme;

class Assets
{
    private $built = true;

    public function __construct()
    {
        $this->initialize_actions();

        if (is_development_stage()) {
            $this->built = file_exists(get_template_directory() . '/dist/main.css');
        }
    }

    private function initialize_actions()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_assets'], 20);
        add_action('after_setup_theme', [$this, 'add_editor_styles']);
    }

    public function register_assets()
    {
        $this->register_styles();
        $this->register_scripts();
        $this->add_global_variables_to_component_loader();
    }

    private function register_styles()
    {
        if ($this->built) {
            wp_enqueue_style('towa-style', PATH_DIST . 'main.css', [], filemtime(get_theme_file_path('/dist/main.css')));
        }
    }

    private function register_scripts()
    {
        $bundleServer = $this->built ? PATH_DIST : 'http://localhost:8080/';

        wp_enqueue_script('towa-bundle', $bundleServer . 'bundle.js', [], filemtime(get_theme_file_path('/dist/bundle.js')), true);
    }

    public function add_editor_styles()
    {
        if ($this->built) {
            add_editor_style(PATH_DIST . 'main.css');
        }
    }

    private function add_global_variables_to_component_loader()
    {
        wp_localize_script('towa-bundle', 'towa', [
            'path' => [
                'dist' => get_template_directory_uri() . '/dist',
            ],
            'stage' => get_stage(),
        ]);
    }
}
