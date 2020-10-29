<?php

namespace Towa\Theme\Extensions\Sectionpreviews;

class Sectionpreviews
{
    private $previews;

    private $components_path;

    private $img_suffix;

    public function __construct()
    {
        $this->components_path = get_template_directory() . '/resources/components/';
        $this->img_suffix = '.jpg';
        add_action('acf/input/admin_enqueue_scripts', [$this, 'register_js']);
        add_filter('acf/fields/flexible_content/layout_title', [$this,'change_flexible_layout_title'], 10, 4);
    }

    public function register_sectionpreviews()
    {
        $all_sections = collect(scandir($this->components_path))->map(function ($section) {
            if (is_dir($this->components_path . $section)) {
                if (file_exists($this->components_path . $section . '/' . $section . '.php') &&
                    file_exists($this->components_path . $section . '/' . $section . $this->img_suffix)
                ) {
                    return [
                        'path' => $this->components_path . $section . '/' . $section . $this->img_suffix,
                        'name' => $section,
                    ];
                }
            }

            return '';
        })->filter();

        $this->previews = $all_sections;
    }

    public function register_js()
    {
        wp_enqueue_script(
            'towa-previews',
            PATH_THEME.'/lib/Extensions/Sectionpreviews/preview.js',
            ['jquery'],
            theme_version(),
            true
        );

        wp_localize_script('towa-previews', 'vars', [
            'sections' => $this->previews,
            'sectionImgSuffix' => $this->img_suffix,
            'componentsPath' => \PATH_THEME.'/resources/components/',
        ]);

        wp_enqueue_style(
            'towa-previews-style',
            PATH_THEME .'/lib/Extensions/Sectionpreviews/preview.css',
            [],
            theme_version()
        );
    }

    public function change_flexible_layout_title($title, $field, $layout, $i)
    {
        $theme_path = PATH_THEME;
        $title .= "<a class='towa-eye' href='#' title='Voransicht von {$layout['name']}' data-layout='{$layout['key']}'><img class='image' src='{$theme_path}/lib/Extensions/Sectionpreviews/eye.png'/><img class='hover-image' src='{$theme_path}/lib/Extensions/Sectionpreviews/eye-hover.png'/></a>";

        return $title;
    }
}
