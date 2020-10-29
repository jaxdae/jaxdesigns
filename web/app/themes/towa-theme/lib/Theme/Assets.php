<?php

namespace Towa\Theme\Theme;

class Assets
{
    private $built = true;

    public function __construct()
    {
        $this->initialize_actions();
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
        wp_enqueue_style('towa-style', mix('css/main.css'), [], null);
    }

    private function register_scripts()
    {
        $bundleServer = $this->built ? PATH_DIST : 'http://localhost:8080/';

        wp_enqueue_script('towa-bundle', mix('js/main.js'), [], null, true);
    }

    public function add_editor_styles()
    {
        add_editor_style(mix('css/main.css'));
    }

    private function add_global_variables_to_component_loader()
    {
        wp_localize_script('towa-bundle', 'towa', [
            'path' => [
                'dist' => get_template_directory_uri() . '/dist',
            ],
            'stage' => get_stage(),
            'restTerms' => esc_url(home_url() . '/wp-json/towa/v1/terms/'),
            'restCpt' => esc_url(home_url() . '/wp-json/towa/v1/posts/'),
        ]);

        wp_localize_script('towa-bundle', 'api', [
            'terms' => esc_url(home_url() . '/wp-json/towa/v1/terms/'),
            'posts' => esc_url(home_url() . '/wp-json/towa/v1/posts/'),
        ]);
    }
}
